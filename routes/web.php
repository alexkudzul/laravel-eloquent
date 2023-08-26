<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Phone;
use App\Models\Course;
use App\Models\Flight;
use App\Models\Comment;
use App\Models\Mechanic;
use App\Models\Destination;
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

Route::get('flight-first', function () {
    $flight = Flight::find(1);
    $flight = Flight::where('departed', true)->first();
    $flight = Flight::firstWhere('departed, true');

    $flight = Flight::findOr(101, function () {
        return 'No existe el vuelo';
    });

    $flight = Flight::where('legs', '>', 10)->firstOr(function () {
        return 'No se encontro el vuelo';
    });

    // Trea el primer elemento y si no existe retorna una excepcion
    $flight = Flight::where('legs', '>', 10)->firstOrFail();
    $flight = Flight::findOrFail(101);

    return $flight;
});

Route::get('destination-first', function () {
    /**
     * Al ser solo un campo en la tabla hace el filtro con first y si no
     * existe crea un nuevo registro con el nombre
     */
    $destination = Destination::firstOrCreate([
        'name' => 'Guerrero'
    ]);

    /**
     * Al ser varios campos en la tabla, primero se hace el filtro con first
     * y si no existe crea un nuevo registro con los 2 arreglos
     */
    $flight = Flight::firstOrCreate([
        'name' => 'Alex Ku'
    ], [
        'number' => '123456',
        'legs' => 4,
        'active' => true,
        'departed' => false,
        'arrived_at' => now(),
        'destination_id' => 1
    ]);

    /**
     * Crea una nueva instancia, sin guardarlo en la DB, es util cuando se
     * desea hacer otras acciones antes de guardar.
     */
    $flight = Flight::firstOrNew([
        'name' => 'Alex Ku Dzul'
    ], [
        'number' => '123456',
        'legs' => 4,
        'active' => true,
        'departed' => false,
        'arrived_at' => now(),
        'destination_id' => 1
    ]);

    // $flight->save();

    $flight = Flight::where('departed', true)->count(); // return count
    $flight = Flight::where('departed', true)->sum('legs'); // return sum
    $flight = Flight::where('departed', true)->max('legs'); // return max number (10 es el numero maximo)
    $flight = Flight::where('departed', true)->avg('legs'); // return avg number (promedio)

    return [$destination, $flight];
});

Route::get('flight-destination-update-create', function () {
    /**
     * Insertar un nuevo registro
     */
    // $destination = new Destination();
    // $destination->name = 'Baja California';
    // $destination->save();

    $data = [
        'name' => 'Flight 2',
        'number' => '1234',
        'legs' => 1,
        'active' => true,
        'departed' => false,
        'arrived_at' => null,
        'destination_id' => 1,
    ];

    /**
     * Create
     */
    // $flight = Flight::create($data);

    /**
     * Update
     */
    // $flight = Flight::find(102);
    // $flight->update($data);

    /**
     * updateOrCreate, el primer array hace un filtro o busca que exista un
     * registro para actualizar, sino existe crea un nuevo registro con esos
     * datos.
     */
    $flight = Flight::updateOrCreate([
        'name' => 'Flight 2',
    ], [
        'name' => 'Flight 2',
        'number' => '12345',
        'legs' => 1,
        'active' => true,
        'departed' => false,
        'arrived_at' => null,
        'destination_id' => 1,
    ]);

    return $flight;
});

Route::get('delete-softdeletes', function () {
    /**
     * Eliminar registros
     */
    // $flight = Flight::find(102);
    // $flight->delete();

    /**
     * Eliminar registros con destroy
     */
    // Flight::destroy(102);
    // Flight::destroy([99, 100, 101]);

    /**
     * Eliminar todo los registros en una tabla, de igual manera los ids de
     * incremento, se restablece a 1.
     */
    // Flight::truncate();

    /**
     * Eliminar un registro por medio de un filtro
     */
    // Flight::where('active', 0)->delete();


    /**
     * SoftDeletes
     * Crear una papelera de reciclaje
     */

    Flight::destroy(90, 91, 92, 100);

    // Al estar eliminado con SoftDeletes no buscara ni mostrara ese dato al recuperarlo
    // $flight = Flight::findOrFail(100);

    // Mostrar todo los registros más los eliminados con SoftDeletes
    $flight = Flight::orderBy('id', 'desc')->withTrashed()->get();

    // Mostrar solo los registros eliminados con SoftDeletes
    $flight = Flight::orderBy('id', 'desc')->onlyTrashed()->get();

    // Busca un id que ha sido eliminado
    $flight = Flight::where('id', 100)->onlyTrashed()->get();

    // Busca un id que ha sido eliminado y restaurar el registro
    $flight = Flight::where('id', 100)->onlyTrashed()->restore();

    // Busca un id que ha sido eliminado y elimina el registro de forma permanente
    $flight = Flight::where('id', 90)->onlyTrashed()->forceDelete();

    // Verificar si un registro se encuentra en la papelera de reciclaje
    $flight = Flight::where('id', 91)->withTrashed()->first();

    if ($flight->trashed()) {
        return 'El registro SI se encuentra en la papelera de reciclaje';
    }

    return 'El registro NO se encuentra en la papelera de reciclaje';
});

Route::get('query-scopes', function () {
    // https://laravel.com/docs/10.x/eloquent#query-scopes

    // ------- Global Scopes - Uso -------

    // return Flight::where('departed', false)->get(); // select * from flights where departed = false
    // return Flight::all(); // Ya tiene un scope global con la funcion del where('departed', false)

    // Si desea eliminar un ámbito global para una consulta determinada, puede
    // utilizar el withoutGlobalScopemétodo. Este método acepta el nombre de
    // clase del alcance global como su único argumento:
    // Flight::withoutGlobalScopes([NotDepartedScope::class])->get();

    // O bien, si definió el ámbito global mediante un cierre, debe pasar el
    // nombre de la cadena que asignó al ámbito global:
    // Flight::withoutGlobalScopes(['not_departed'])->get();

    // ------- Local Scopes - Uso -------

    $flight = Flight::active()->get(); // Se utiliza sin el prefijo de 'scope'
    $flight = Flight::legs(2)->get(); // Se utiliza sin el prefijo de 'scope'

    return $flight;
});

Route::get('events-observers', function () {

    // Se ejecuta el evento creating del observer FlightObserver y se agrega el campo 'number'
    // Flight::create([
    //     'name' => 'Alex Ku',
    //     'legs' => 2,
    //     'active' => 0,
    //     'departed' => 1,
    //     'destination_id' => 7,
    // ]);

    // Se ejecuta el evento retrieved del observer FlightObserver
    // El evento retrieved se enviará cuando se recupere un modelo existente de la base de datos.
    return Flight::find(1);
});

Route::get('relationship', function () {
    $user = User::find(1);
    $user->phone;
    $user->courses;
    $user->latestCourses; // Retorna el curso mas nuevo
    $user->oldestCourses; // Retorna el curso mas antiguo

    $phone = Phone::find(1);
    $phone->user;

    $course = Course::find(1);
    $course->user;
    $course->sections;
    $course->lessons; // Relación uno a muchos a través // NOTA: con esta relación se puede obtener información de lecciones del Section de un Course

    $mechanic = Mechanic::find(1);
    $mechanic->car;
    $mechanic->owner; // Relación uno a uno a través // NOTA: con esta relación se puede obtener información del dueño del Car con el que hizo trato el Mechanic

    return [
        'user' => $user,
        'phone' => $phone,
        'course' => $course,
        'mechanic' => $mechanic
    ];
});

Route::get('relationship-many-to-many', function () {
    $user = User::find(1);
    $user->roles;

    $roles_active = $user->roles()->wherePivot('active', true)->get();

    return [
        'user' => $user,
        'roles_active' => $roles_active
    ];
});

Route::get('relationships-polymorphic', function () {
    $course = Course::find(1);
    $post = Post::find(1);

    // Relación polimórfica de uno a uno
    $course->image;
    $post->image;

    // Relación polimórfica de uno a muchos
    $course->comments;
    $post->comments;

    // Relación polimórfica de uno a uno con función extra: latestOfMany() y oldestOfMany()
    $course->latestComment;
    $post->oldestComment;

    // Relación polimórfica de muchos a muchos
    $course->tags;
    $post->tags;

    return [
        'course' => $course,
        'post' => $post,
    ];
});

Route::get('queries-in-relationships', function () {
    // ------- Consultas con relaciones -------
    $user = User::find(1);

    // Nota: hay que tener cuidado cuando se usa orWhere ya que traera
    // cualquier posts que tenga likes mayor a 500 ya que se agrupa al
    // mismo nivel que las otras restricciones puestas anteriormente

    // $user_posts = $user->posts()->where('active', true)->orWhere('likes', '>=', 500)->get();
    // select * from posts where user_id = 1 and active = true or likes >= 500

    // Solución para usar mejor un orWhere
    $user_posts = $user->posts()->where(function ($query) {
        $query->where('active', true)
            ->orWhere('likes', '>=', 500);
    })->get();

    // ------- Comprobar la existencia de una relación -------

    // Obtiene los usuarios que tiene posts asociados
    // $users_posts = User::has('posts')->get();

    // Obtiene los usuarios que tiene posts asociados y que tenga más de 4 posts
    $users_posts = User::has('posts', '>', 2)->get();

    // ------- Anidar relaciones en las consultas -------

    // Obtiene los cursos que solo tiene lecciones
    $courses = Course::has('sections.lessons')->get();
    // Existe una relalacion a través de... que tiene el mismo funcionalidad de las relaciones anidadas
    // $courses = Course::has('lessons')->get(); // Esta consulta hace lo mismo con el has('sections.lessons')

    // ------- Especificar filtros adicionales con whereHas -------

    // whereHas() funciona básicamente igual has() pero le permite especificar
    // filtros adicionales para que el modelo relacionado los verifique.

    // Obtiene los usuarios que han escrito un post y que en su title contenga la palabra 'dolorum'
    $user_posts_search = User::whereHas('posts', function ($query) {
        $query->where('title', 'like', '%dolorum%');
    })->get();

    // ------- Comprobar la ausencia de una relación -------

    // Obtiene los usuarios que no han escrito un post
    $user_has_no_post = User::doesntHave('posts')->get();

    // ------- Consulta con relaciones polimórfica -------

    // Obtiene los comentarios de los cursos
    $comments_courses = Comment::whereHasMorph('commentable', Course::class, function ($query) {
        // Se puede agregar más consultas
        return;
    })->get();

    return [
        'user' => $user,
        'user_posts' => $user_posts,
        'users_posts' => $users_posts,
        'courses' => $courses,
        'user_posts_search' => $user_posts_search,
        'user_has_no_post' => $user_has_no_post,
        'comments_courses' => $comments_courses,
    ];
});
