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
                <th>Titulo</th>
                <th>Autor</th>
            </tr>
        </thead>
        <tbody>
            {{-- Cada vez que entre en el foreach hara una consulta a la DB
                con la relación post->user generando el problema de N+1 --}}

            {{-- Para evitar el problema de N+1 se tiene que cargar la
                relación user en el controlador con el método with()  --}}

            {{-- Con esto se reduce las consultas a 1 o 2. --}}

            @foreach ($posts as $post)
                <tr>
                    <th>{{ $post->title }}</th>
                    <td>{{ $post->user->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
