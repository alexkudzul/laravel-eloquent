<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    // Relación uno a uno o muchos inversa
    public function mechanic()
    {
        return $this->belongsTo(Mechanic::class);
    }

    // Relación uno a uno o muchos inversa
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
