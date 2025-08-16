<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QualityPlus+</title>
    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    @yield('content')
    @yield('scripts')
</body>
</html>
