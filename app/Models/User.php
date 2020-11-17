<?php

namespace App\Models;

use Eloquent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string|null $avatar
 * @property string $username
 * @property string $password
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $gender
 * @property string|null $location
 * @property int $verify
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|User[] $friendOf
 * @property-read int|null $friend_of_count
 * @property-read Collection|User[] $friendsOfMine
 * @property-read int|null $friends_of_mine_count
 * @property-read Collection|Like[] $likes
 * @property-read int|null $likes_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|Wall[] $walls
 * @property-read int|null $walls_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereGender($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User whereLocation($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUsername($value)
 * @method static Builder|User whereVerify($value)
 * @mixin Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'username',
        'password',
        'first_name',
        'last_name',
        'location',
        'gender',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getName()
    {
        if ($this->first_name && $this->last_name) {
            return "{$this->first_name} {$this->last_name}";
        }

        if ($this->first_name) {
            return $this->first_name;
        }

        return null;
    }

    public function getNameOrUsername()
    {
        return $this->getName() ?: $this->username;
    }

    public function getFirstNameOrUsername()
    {
        return $this->first_name ?: $this->username;
    }

    public function getAvatarUrl()
    {
        return "https://www.gravatar.com/avatar/{{ md5($this->email)?d=mp&s=40 }}";
    }

    # пользователю принадлежит статус (связь один ко многим)
    public function walls()
    {
        return $this->hasMany('App\Models\Wall', 'user_id');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\Like', 'user_id');
    }

    public function myFriends()
    {
        return $this->belongsToMany('App\Models\User', 'friends', 'user_id', 'friend_id');
    }

    public function friendsToMe()
    {
        return $this->belongsToMany('App\Models\User', 'friends', 'friend_id', 'user_id');
    }

    public function acceptedFriends()
    {
        return $this->myFriends()->wherePivot('accepted', true)->get()
            ->merge($this->friendsToMe()->wherePivot('accepted', true)->get());
    }

    public function friendRequests()
    {
        return $this->myFriends()->wherePivot('accepted', false)->get();
    }

    public function friendRequestsPending()
    {
        return $this->friendsToMe()->wherePivot('accepted', false)->get();
    }

    public function hasFriendRequestPending(User $user)
    {
        return (bool)$this->friendRequestsPending()->where('id', $user->id)->count();
    }

    public function hasFriendRequestReceived(User $user)
    {
        return (bool)$this->friendRequests()->where('id', $user->id)->count();
    }

    public function addFriend(User $user)
    {
        $this->friendsToMe()->attach($user->id);
    }

    public function deleteFriend(User $user)
    {
        $this->friendsToMe()->detach($user->id);
        $this->myFriends()->detach($user->id);
    }

    public function acceptFriendRequest(User $user)
    {
        $this->friendRequests()->where('id', $user->id)->first()->pivot->update(
            [
                'accepted' => true
            ]
        );
    }

    public function isFriendOf(User $user)
    {
        return (bool)$this->acceptedFriends()->where('id', $user->id)->count();
    }

    public function hasLikedWall(Wall $wall)
    {
        return (bool)$wall->likes
            ->where('user_id', $this->id)
            ->count();
    }

    public function getAvatarsPath($user_id)
    {
        $path = "uploads/avatars/id{$user_id}";

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        return "/$path/";
    }

    public function clearAvatars($user_id)
    {
        $path = "uploads/avatars/id{$user_id}";

        if (file_exists(public_path("/$path"))) {
            foreach (glob(public_path("/$path/*")) as $avatar) {
                unlink($avatar);
            }
        }
    }
}
