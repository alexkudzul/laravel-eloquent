<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Eloquent: API Resources
     *
     * Al crear una API, es posible que necesite una capa de transformación que
     * se encuentre entre sus modelos de Eloquent y las respuestas JSON que
     * realmente se devuelven a los usuarios de su aplicación. Por ejemplo, es
     * posible que desee mostrar ciertos atributos para un subconjunto de usuarios
     * y no para otros, o puede que desee incluir siempre ciertas relaciones en
     * la representación JSON de sus modelos. Las clases de recursos de Eloquent
     * te permiten transformar de forma expresiva y sencilla tus modelos y
     * colecciones de modelos a JSON.
     *
     * Resource Collections
     *
     * Además de generar recursos que transforman modelos individuales, puede
     * generar recursos que sean responsables de transformar colecciones de
     * modelos. Esto permite que sus respuestas JSON incluyan enlaces y otra
     * metainformación que sea relevante para una colección completa de un
     * recurso determinado.
     *
     * https://laravel.com/docs/10.x/eloquent-resources
     */

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();

        // Forma de mostrar un Resource - transforma modelos individuales
        // return PostResource::collection($posts);

        // Forma de mostrar un Resource tipo Collection - transforma
        // colecciones de modelos, lo que permite personalizar aun mas
        // los datos a mostrar
        return new PostCollection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
