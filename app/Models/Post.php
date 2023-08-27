<?php

namespace App\Models;

use App\Casts\Meta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Attribute Casting
     *
     * La conversión de atributos proporciona una funcionalidad similar a los
     * accesores y mutadores sin necesidad de definir ningún método adicional
     * en su modelo. En cambio, la propiedad de su modelo $casts proporciona
     * un método conveniente para convertir atributos a tipos de datos comunes.
     *
     * La $casts propiedad debe ser una matriz donde la clave es el nombre del
     * atributo que se está convirtiendo y el valor es el tipo al que desea
     * convertir la columna.
     *
     * https://laravel.com/docs/10.x/eloquent-mutators#attribute-casting
     *
     * Custom Casts
     *
     * Laravel tiene una variedad de tipos de conversión útiles e integrados;
     * sin embargo, es posible que en ocasiones necesites definir tus propios
     * tipos de conversión.
     *
     * https://laravel.com/docs/10.x/eloquent-mutators#custom-casts
     */
    protected $casts = [
        // 'meta' => 'array', // Sin casts personalizado
        'meta' => Meta::class, // Con casts personalizado
    ];

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
