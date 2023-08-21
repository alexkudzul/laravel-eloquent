<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // Relación uno a uno o muchos inversa
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'No tiene usuario',
        ]);
    }

    // Relación uno a muchos
    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    // Relación uno a muchos a través
    public function lessons()
    {
        // NOTA: con esta relación se puede obtener información de lecciones del Section de un Course

        // Tiene muchos a través de.
        return $this->hasManyThrough(Lesson::class, Section::class);
    }
}
