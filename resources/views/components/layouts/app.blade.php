<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'App' }}</title>
    @vite('resources/css/app.css')
    @livewireStyles
    @vite(['resources/js/app.js'])
</head>

<body class="">
    @auth
    @livewire('components.navbar')
    @livewire('components.slidebar')
    @endauth
    @livewire('components.notify')
    <main class="w-full mx-auto py-10 px-4 sm:px-6 lg:px-8  transition-all duration-300 ">
        <h1 class="text-6xl font-bold text-center mb-4 pb-7">{{ $title ?? '' }}</h1>
        {{ $slot }}
        @livewireScriptConfig
    </main>
    @livewireScripts
</body>

</html>
