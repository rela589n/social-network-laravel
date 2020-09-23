<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likeable';
    protected $fillable = ['user_id'];

    # полиморфная связь
    public function likeable()
    {
        return $this->morphTo();
    }

    # получить пользователя по лайку (обратное отношение)
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
