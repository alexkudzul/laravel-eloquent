<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    // Relación polimórfica inversa de muchos a muchos.
    public function courses()
    {
        return $this->morphedByMany(Course::class, 'taggable');
    }

    // Relación polimórfica inversa de muchos a muchos.
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }
}
