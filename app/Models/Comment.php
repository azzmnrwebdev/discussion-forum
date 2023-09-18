<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $table    = 'comments';
    protected $fillable = ['users_id', 'posts_id', 'parents_id', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'posts_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parents_id');
    }

    public function replies()
    {
        return $this->hasMany(self::class, 'parents_id')->orderByDesc('created_at');
    }

    public function formattedTimestamp($dateTime)
    {
        $now = Carbon::now();
        $timestamp = Carbon::parse($dateTime);

        $diffInYears = $timestamp->diffInYears($now);
        $diffInMonths = $timestamp->diffInMonths($now);

        if ($diffInYears >= 1) {
            return $timestamp->format('M j, Y');
        }

        if ($diffInMonths >= 1) {
            return $timestamp->format('M j');
        }

        $diffInDays = $timestamp->diffInDays($now);
        $diffInHours = $timestamp->diffInHours($now);
        $diffInMinutes = $timestamp->diffInMinutes($now);

        if ($diffInDays > 0) {
            return $diffInDays . ' ' . Str::plural('day', $diffInDays) . ' ago';
        } elseif ($diffInHours > 0) {
            return $diffInHours . ' ' . Str::plural('hour', $diffInHours) . ' ago';
        } elseif ($diffInMinutes > 0) {
            return $diffInMinutes . ' ' . Str::plural('minute', $diffInMinutes) . ' ago';
        }

        return 'just now';
    }
}
