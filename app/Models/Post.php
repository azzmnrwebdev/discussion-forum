<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, Sluggable;

    protected $table    = 'posts';
    protected $fillable = ['users_id', 'title', 'categories_id', 'content', 'views_count'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true
            ]
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'posts_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'posts_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'posts_id')->whereNull('parents_id')->orderByDesc('created_at');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'posts_id');
    }

    public function getFormattedCountAttribute($column)
    {
        $value = $column;

        if ($value >= 1000000) {
            return number_format($value / 1000000, 1) . 'M';
        } elseif ($value >= 1000) {
            return number_format($value / 1000, 1) . 'K';
        } else {
            return $value;
        }
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
