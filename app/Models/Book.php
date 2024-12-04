<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author', 'description'];

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function userRating()
    {
        return $this->hasOne(Rating::class)->where('user_id', auth()->id());
    }

    public function userComment()
    {
        return $this->hasOne(Comment::class)->where('user_id', auth()->id());
    }
}
