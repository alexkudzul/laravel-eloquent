<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Problema de N+1 y como solucionarlo
     *
     * Revisar la vista users.index
     *
     * Con with() queda almacenado en memoria y para hacer uso de esa
     * informacion se accede de la siguiente manera $user->posts sin el
     * parentesis como $user->posts()
     * Si se utiliza el $user->posts() obligamos a laravel a hacer la consulta la DB
     */
    public function index()
    {
        // with: Consulta un modelo con carga ansiosa.
        // $users = User::with('posts')->get();

        // withCount() : ayuda a obtener la cantidad de registros relacionados
        // dentro del objeto principal generando una nueva propiedad posts_count
        $users = User::withCount('posts')->get();

        return view('users.index', compact('users'));
    }

    /**
     * Problema de N+1 con uso de un accesor (isActive(): Attribute)
     *
     * Se soluciona de la misma manera usando with
     *
     * Revisar la vista users.active
     */
    public function active()
    {
        $users = User::with('posts')->get();

        return view('users.active', compact('users'));
    }
}
