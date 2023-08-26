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
                <th>Activo (si tiene más de un post publicado)</th>
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
                    {{-- Verifica la relación entre usuarios y posts, si la
                        cantidad de posts asociados a un usuario es mayor a 0,
                        retorna true o false --}}
                    <td>{{ $user->is_active ? 'Si' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
