<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

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
Route::apiResource('posts', PostController::class);
