<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    /**
     * Algunas de las variables y constantes que se pueden modificar sino
     * se sigue las convenciones de Laravel y Eloquent.
     */
    // const CREATED_AT = 'creation_date';
    // const UPDATED_AT = 'updated_date';

    // protected $connection = 'sqlite';
    // protected $table = 'example_table';
    // protected $primaryKey = 'identificator';
    // protected $incrementing = false;
    // protected $keyType = 'string';
    // public $timestamps = false;
    // protected $dateFormat = 'U';

    /**
     * attributes: agrega valores predeterminados para algunos de los atributos
     */
    protected $attributes = [
        'name' => 'México',
    ];
}
