<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wall extends Model
{
    protected $table = 'walls';
    protected $fillable = ['body'];

    # получить пользователя по записи на стене (обратное отношение)
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    # выбрать все родительские записи на стене
    public function scopeNotReply($query)
    {
        return $query->whereNull('parent_id');
    }

    # получить комментарии к записи на стене (связь один ко многим)
    public function replies()
    {
        return $this->hasMany('App\Models\Wall', 'parent_id')->latest();
    }

    # Получить все лайки к записи
    public function likes()
    {
        return $this->morphMany('App\Models\Like', 'likeable');
    }
}
