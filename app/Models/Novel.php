<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Novel extends Model
{
    protected $fillable = [
        'title',
        'author',
        'genre',
        'year',
        'pages',
        'photo',
        'synopsis', // ← Tambahkan ini
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function bookmarkedBy()
    {
        return $this->belongsToMany(User::class, 'bookmarks')->withTimestamps();
    }
}
