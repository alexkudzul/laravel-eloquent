<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    // public static $wrap = 'post'; // cambia el nombre de data a post

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

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
         *
         * Writing Resources
         *
         * Además de permitirte transformar tus modelos y colecciones en formatos
         * de salida personalizados, los recursos también te permiten recibir y
         * validar datos de entrada. En este módulo, aprenderás cómo utilizar
         * recursos de escritura en Laravel para simplificar la validación y el
         * procesamiento de datos de entrada.
         *
         * https://laravel.com/docs/10.x/eloquent-resources#writing-resources
         */
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'active' => $this->active,
            'likes' => $this->likes,
            'user_id' => $this->user_id,
            // Validar con una condición, si es true se muestra en la data y caso contrario no se muestra
            'test' => $this->when(false, 'test'),
            // 'user' => $this->user, // Carga la relacion user
            // 'user' => new UserResource($this->user), // Carga la relacion user personalizado con un Resource
            // Carga la relacion user personalizado con un Resource, con la condicion si se carga la relacion en el controller con with('user')
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
