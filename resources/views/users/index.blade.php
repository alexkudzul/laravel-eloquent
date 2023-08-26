<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>Autor</th>
                <th>Posts</th>
            </tr>
        </thead>
        <tbody>
            {{-- Cada vez que entre en el foreach hara una consulta a la DB
                con la relación user->posts generando el problema de N+1 --}}

            {{-- Para evitar el problema de N+1 se tiene que cargar la
                relación user en el controlador con el método with()  --}}

            {{-- Con esto se reduce las consultas a 1 o 2. --}}

            {{-- Nota: Con with() queda almacenado en memoria y para hacer uso de esa
                informacion se accede de la siguiente manera $user->posts sin el
                parentesis como $user->posts() --}}

            @foreach ($users as $user)
                <tr>
                    <th>{{ $user->name }}</th>
                    {{-- Si se utiliza el $user->posts() obligamos a laravel a hacer la consulta la DB --}}
                    {{-- <td>{{ $user->posts()->count() }}</td> --}}

                    {{-- Forma correcta de usar with --}}
                    {{-- <td>{{ $user->posts->count() }}</td> --}}

                    {{-- withCount() : ayuda a obtener la cantidad de registros relacionados
                        dentro del objeto principal generando una nueva propiedad posts_count --}}
                    <td>{{ $user->posts_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
