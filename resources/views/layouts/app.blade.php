<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $titre ?? config('app.name') }}</title>
</head>
<body>
    <nav>
        <a href="{{ route('home') }}">Accueil</a> |
        <a href="{{ route('trajets.index') }}">Trajets</a>
    </nav>

    <main>
        @yield('content')
    </main>
</body>
</html>
