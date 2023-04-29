<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class posts extends Model
{
    //

    public function likedby(User $user)
    {
        return $this->likes->contains('user_id', $user->id);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
