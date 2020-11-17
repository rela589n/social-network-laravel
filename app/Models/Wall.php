<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Wall
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $parent_id
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Like[] $likes
 * @property-read int|null $likes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Wall[] $replies
 * @property-read int|null $replies_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Wall newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wall newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wall notReply()
 * @method static \Illuminate\Database\Eloquent\Builder|Wall query()
 * @method static \Illuminate\Database\Eloquent\Builder|Wall whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wall whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wall whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wall whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wall whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wall whereUserId($value)
 * @mixin \Eloquent
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
