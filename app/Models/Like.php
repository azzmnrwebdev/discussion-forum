<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table    = 'likes';
    protected $fillable = ['users_id', 'posts_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'posts_id');
    }
}
