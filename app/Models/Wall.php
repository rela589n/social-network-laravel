<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Wall
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $parent_id
 * @property string $body
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Like[] $likes
 * @property-read int|null $likes_count
 * @property-read Collection|Wall[] $replies
 * @property-read int|null $replies_count
 * @property-read User $user
 * @method static Builder|Wall newModelQuery()
 * @method static Builder|Wall newQuery()
 * @method static Builder|Wall notReply()
 * @method static Builder|Wall query()
 * @method static Builder|Wall whereBody($value)
 * @method static Builder|Wall whereCreatedAt($value)
 * @method static Builder|Wall whereId($value)
 * @method static Builder|Wall whereParentId($value)
 * @method static Builder|Wall whereUpdatedAt($value)
 * @method static Builder|Wall whereUserId($value)
 * @mixin Eloquent
 */
class Wall extends Model
{
    protected $table = 'walls';
    protected $fillable = ['body'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function scopeNotReply($query)
    {
        return $query->whereNull('parent_id');
    }

    public function replies()
    {
        return $this->hasMany('App\Models\Wall', 'parent_id')->latest();
    }

    public function likes()
    {
        return $this->morphMany('App\Models\Like', 'likeable');
    }
}
