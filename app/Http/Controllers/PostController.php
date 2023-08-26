<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Problema de N+1 y como solucionarlo
     *
     * - Revisar la vista posts.index
     * - Cada vez que entre en el foreach hara una consulta a la DB con la
     * relación post->user generando el problema de N+1.
     * - Para evitar el problema de N+1 se tiene que cargar la relación user
     * en el controlador con el método with()
     * - Con esto se reduce las consultas a 1 o 2.
     */
    public function index()
    {
        // with: Consulta un modelo con carga ansiosa.
        $posts = Post::with('user')->get();

        return view('posts.index', compact('posts'));
    }
}
