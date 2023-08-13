<?php

use App\Models\Destination;
use App\Models\Flight;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/flights-test', function () {
    // $destination = new Destination();

    // return $destination;

    // $flights = Flight::all();

    // $flights = Flight::where('active', 1)
    //     ->where('legs', '>', 2)
    //     ->get();

    // $flights = Flight::where('active', 1)
    //     ->orderBy('name', 'desc')
    //     ->take(10)
    //     ->get();

    /**
     * Si los registros de la tabla de la base de datos es poca se usa de
     * forma tradicional all() y get()
     */
    // $flights = Flight::all();

    // foreach ($flights as $flight) {
    //     $flight->number = 'a-' . $flight->number;
    //     $flight->save();
    // }

    /**
     * chunk() - Si la tabla de su base de datos tiene muchos datos, el
     * método chunk() es el mejor para usar. El método chunk() se puede usar
     * en la fachada de DB y también en modelos Eloquent.
     *
     * El chunk() se encarga de obtener una pequeña cantidad de datos a la vez
     * y el resultado está presente dentro del cierre para su procesamiento.
     */
    Flight::chunk(20, function ($flights) {
        foreach ($flights as $flight) {
            $flight->number = 'a-' . $flight->number;
            $flight->save();
        }
    });

    /**
     * chunkById() - https://laravel.com/docs/10.x/eloquent#chunking-results
     */
    Flight::where('departed', true)->chunkById(20, function ($flights) {
        foreach ($flights as $flight) {
            $flight->departed = false;
            $flight->save();
        }
    }, 'id');

    /**
     * Similar al lazymétodo, el cursormétodo puede usarse para reducir
     * significativamente el consumo de memoria de su aplicación al iterar
     * a través de decenas de miles de registros del modelo Eloquent.
     *
     * El cursormétodo solo ejecutará una sola consulta de base de datos; sin
     * embargo, los modelos individuales de Eloquent no se hidratarán hasta
     * que se vuelvan a iterar. Por lo tanto, solo se mantiene un modelo de
     * Eloquent en la memoria en un momento dado mientras se itera sobre el
     * cursor.
     *
     * https://laravel.com/docs/10.x/eloquent#cursors
     */
    foreach (Flight::cursor() as $flight) {
        $flight->active = true;
        $flight->save();
    }

    /*
    Generadores:
    Explicacion del metodo cursor() de como funciona internamente:

    function myRange($start, $end, $step = 1)
    {
        for ($i = $start; $i <= $end; $i += $step) {
            yield $i;
        }
    }

    // $range = range(1, 10000000);
    $range = myRange(1, 10000000);

    foreach ($range as $number) {
        echo $number . PHP_EOL;
    }
    */



    // return $flights;
});

Route::get('/destinations-test', function () {
    /**
     * Subconsultas avanzadas con Eloquent
     * https://laravel.com/docs/10.x/eloquent#subquery-selects
     *
     * Usando la funcionalidad de subconsultas disponible para los métodos
     * select y el generador de consultas addSelect, podemos seleccionar
     * todos los vuelos destinationsy el nombre del vuelo que llegó más
     * recientemente a ese destino usando una sola consulta
     */
    $destinations = Destination::addSelect([
        'last_flight' => Flight::select('number')
            ->whereColumn('destination_id', 'destinations.id')
            ->orderBy('arrived_at', 'desc')
            ->limit(1),
    ])->get();

    return $destinations;
});
