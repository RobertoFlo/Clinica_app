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

<body class="bg-gray-100">
    @auth
        @livewire('components.navbar')
        @livewire('components.slidebar')
    @endauth
    @livewire('components.notify')
    @livewire('components.loader')

    <main class="w-full mx-auto py-10 px-4 sm:px-6 lg:px-8  transition-all duration-300 ">
        {{ $slot }}
        @livewireScriptConfig
    </main>
    @livewireScripts
</body>
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('redirect', (data) => {
            setTimeout(() => {
                window.location.href = data.data.url;
            }, 6000);
        });
        Livewire.on('auto-hide-loader', () => {
            setTimeout(() => {
                Livewire.dispatch('hide-loader');
            }, 5000);
        });
    });
</script>

</html>