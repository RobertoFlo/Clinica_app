<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Clínica App')</title>


</head>
<body class="bg-gray-100 dark:bg-neutral-900">
    <main class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

</body>

</html>
