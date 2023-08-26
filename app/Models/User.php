<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
}
