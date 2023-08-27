<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relación uno a uno
    public function phone()
    {
        return $this->hasOne(Phone::class)->withDefault([
            'phone' => 'No tiene teléfono',
        ]);
    }

    // Relación uno a muchos
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    // Relación uno a uno
    public function latestCourses()
    {
        return $this->hasOne(Course::class)->latestOfMany();
    }

    // Relación uno a uno
    public function oldestCourses()
    {
        return $this->hasOne(Course::class)->oldestOfMany();
    }

    // Relación muchos a muchos
    public function roles()
    {
        return $this->belongsToMany(Role::class)
            ->as('subscriptions') // as() Cambia el nombre del atributo 'pivot'
            ->withPivot('active')
            ->withTimestamps();
    }

    // Relación uno a muchos
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Accesores
    protected function isActive(): Attribute
    {
        // Verifica la relación entre usuarios y posts, si la cantidad de posts asociados a un usuario es mayor a 0, retorna true o false
        return Attribute::make(
            get: fn () => $this->posts->count() > 0, // return true o false
        );
    }

    /**
     * Mutadores y Casting
     *
     * https://laravel.com/docs/10.x/eloquent-mutators
     *
     * Los mutadores te permiten modificar los valores de los atributos de un
     * modelo antes de que se almacenen en la base de datos. Por ejemplo, si
     * quieres almacenar un valor en formato de fecha, puedes utilizar un
     * mutador para convertir la fecha en un formato adecuado antes de que
     * se almacene.
     *
     * Los accesores, por otro lado, te permiten recuperar valores de los
     * atributos de un modelo de una forma personalizada. Por ejemplo, si
     * quieres mostrar una fecha en un formato específico en tu aplicación,
     * puedes utilizar un accesor para convertir la fecha en el formato
     * adecuado antes de que se muestre.
     */

    protected function name(): Attribute
    {
        return Attribute::make(
            // Accesores
            get: fn (string $value) => ucwords($value),

            // Mutadores
            set: fn (string $value) => strtolower($value),
        );
    }

    // Forma de escribir un accesor y mutador anteriormente
    // public function getNameAttribute($value)
    // {
    //     return ucwords($value);
    // }

    // public function setNameAttribute($value)
    // {
    //     $this->attributes['name'] = strtolower($value);
    // }
}
