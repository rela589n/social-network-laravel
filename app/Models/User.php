<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $avatar
 * @property string $username
 * @property string $password
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $gender
 * @property string|null $location
 * @property int $verify
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $friendOf
 * @property-read int|null $friend_of_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $friendsOfMine
 * @property-read int|null $friends_of_mine_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Like[] $likes
 * @property-read int|null $likes_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Wall[] $walls
 * @property-read int|null $walls_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereVerify($value)
 * @mixin \Eloquent
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
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    # получить имя и фамилию, или имя
    public function getName() 
    {
        if ($this->first_name && $this->last_name) 
        {
            return "{$this->first_name} {$this->last_name}";
        }

        if ($this->first_name) return $this->first_name;

        return null;
    }

    # получить имя и фамилию, или логин
    public function getNameOrUsername() 
    {
        return $this->getName() ?: $this->username;
    }

    # получить имя или логин
    public function getFirstNameOrUsername() 
    {
        return $this->first_name ?: $this->username;
    }

    # получить аватарку из Gravatar
    public function getAvatarUrl() 
    {
        return "https://www.gravatar.com/avatar/{{ md5($this->email)?d=mp&s=40 }}";
    }

    # пользователю принадлежит статус (связь один ко многим)
    public function walls()
    {
        return $this->hasMany('App\Models\Wall', 'user_id');
    }

    # получить лайки пользователя (связь один ко многим)
    public function likes()
    {
        return $this->hasMany('App\Models\Like', 'user_id');
    }

    # устанавливаем отношение многие ко многим, мои друзья
    public function friendsOfMine()
    {
        return $this->belongsToMany('App\Models\User', 'friends', 'user_id', 'friend_id');    
    }

    # устанавливаем отношение многие ко многим, друг
    public function friendOf() {
        return $this->belongsToMany('App\Models\User', 'friends', 'friend_id', 'user_id');
    }

    # получить друзей
    public function friends()
    {
        return $this->friendsOfMine()->wherePivot('accepted', true)->get()
           ->merge( $this->friendOf()->wherePivot('accepted', true)->get() );
    }

    # запросы в друзья
    public function friendRequests()
    {
        return $this->friendsOfMine()->wherePivot('accepted', false)->get();
    }

    # запрос на ожидание друга
    public function friendRequestsPending()
    {
        return $this->friendOf()->wherePivot('accepted', false)->get();
    }

    # есть запрос на добавление в друзья
    public function hasFriendRequestPending(User $user)
    {
        return (bool) $this->friendRequestsPending()->where('id', $user->id)->count();
    }

    # получил запрос о дружбе
    public function hasFriendRequestReceived(User $user)
    {
        return (bool) $this->friendRequests()->where('id', $user->id)->count();
    }

    # добавить друга
    public function addFriend(User $user)
    {
        $this->friendOf()->attach($user->id);
    }

    # удалить из друзей
    public function deleteFriend(User $user)
    {
        $this->friendOf()->detach($user->id);
        $this->friendsOfMine()->detach($user->id);
    }

    # принять запрос на дружбу
    public function acceptFriendRequest(User $user)
    {
        $this->friendRequests()->where('id', $user->id)->first()->pivot->update([
            'accepted' => true
        ]);
    }

    # пользователь уже в друзьях
    public function isFriendWith(User $user)
    {
        return (bool) $this->friends()->where('id', $user->id)->count();
    }

    # запись уже пролайкана
    public function hasLikedWall(Wall $wall)
    {
        return (bool) $wall->likes
            ->where('user_id', $this->id)
            ->count();
    }

    # получить путь к аватарке
    # создать папки по пути, если не существуют
    public function getAvatarsPath($user_id)
    {
        $path = "uploads/avatars/id{$user_id}";

        if ( ! file_exists($path) ) mkdir($path, 0777, true);

        return "/$path/";
    }

    # удалить все аватарки в папке пользователя
    public function clearAvatars($user_id) {
        $path = "uploads/avatars/id{$user_id}";

        if ( file_exists( public_path("/$path") ) ) {
            foreach( glob( public_path("/$path/*") ) as $avatar )
            unlink($avatar);
        }
    }
}
