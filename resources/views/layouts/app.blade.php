<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TravelBuddy')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.styles')
</head>
<body>
    @include('header.header')

    <main>
        @yield('content')
    </main>

    @include('layouts.scripts')
</body>
</html> 