<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Relación polimórfica de uno a uno
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    // Relación polimórfica de uno a muchos
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    // Relación polimórfica de uno a uno - obtiene el ultimo registro que se ha realizado
    public function latestComment()
    {
        return $this->morphOne(Comment::class, 'commentable')->latestOfMany();
    }

    // Relación polimórfica de uno a uno - obtiene el más antiguo registro que se ha realizado
    public function oldestComment()
    {
        return $this->morphOne(Comment::class, 'commentable')->oldestOfMany();
    }

    // Relación polimórfica de muchos a muchos
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    // Relación uno a uno o muchos inversa
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
