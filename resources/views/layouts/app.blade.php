<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <title>@yield('title')</title>
    @livewireStyles
</head>
<body class="h-full w-full bg-primaryBackground">
    @if(Session::has('alert'))
        <x-alert :success="Session::get('alert')['success']" :onEvent="false">
            {{ Session::get('alert')['message'] }}
        </x-alert>
    @endif
    <x-alert :onEvent="true">Test</x-alert>
    @yield('content')
    @livewireScripts
</body>
</html>
