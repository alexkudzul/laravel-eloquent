<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mechanic extends Model
{
    use HasFactory;

    // Relación uno a uno
    public function car()
    {
        return $this->hasOne(Car::class);
    }

    // Relación uno a uno a través
    public function owner()
    {
        // NOTA: con esta relación se puede obtener información del dueño del Car con el que hizo trato el Mechanic

        // Tiene uno a través de.
        return $this->hasOneThrough(Owner::class, Car::class);
    }
}
