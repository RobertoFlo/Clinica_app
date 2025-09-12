<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

  <!-- Styles / Scripts -->
  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @else

  @endif
</head>

<body class="bg-blue-900">
  <div class="flex h-screen justify-center items-center">
    <div
      class=" bg-white rounded-2xl lg:w-5/12 xl:w-4/12  md:w-6/12 sm:w-8/12 w-full m-4 px-6 py-12 lg:px-8  shadow-lg  border-2 border-gray-400">
      <form action="{{ route('inicio.session') }}" method="POST" class="flex flex-col w-full justify-center items-center gap-4">
        @csrf
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
          <h2 class="text-center text-3xl font-bold leading-9 tracking-tight">Inicio de sesión
          </h2>
        </div>
        <div class="flex w-full max-w-xl flex-col gap-1 text-on-surface ">
          <label for="email" class="w-fit pl-0.5 text-sm">Correo</label>
          <input id="email" type="text"
            class="w-full rounded-radius border border-outline bg-surface-alt px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 border-gray-300 @error('email') !border-red-600 @enderror"
            name="email" placeholder="Enter your name" autocomplete="email" value="{{old('email')}}" />
          @error('email')
            <div class="alert alert-danger text-sm text-red-500">{{ $message }}</div>
          @enderror
        </div>
        <div class="flex w-full max-w-xl flex-col gap-1 ">
          <label for="passwordInput" class="w-fit pl-0.5 text-sm">Password</label>
          <div x-data="{ showPassword: false }" class="relative">
            <input x-bind:type="showPassword ? 'text' : 'password'" id="passwordInput"
              class="w-full rounded-radius border border-outline bg-surface-alt px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 border-gray-300 @error('password') !border-red-600 @enderror"
              name="password" autocomplete="current-password" placeholder="Enter your password"/>
            <button type="button" x-on:click="showPassword = !showPassword"
              class="absolute right-2.5 top-1/2 -translate-y-1/2 text-on-surface text-[#898c91] " aria-label="Show password">
              <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
              </svg>
              <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
              </svg>
            </button>
          </div>
          @error('password')
            <div class="alert alert-danger text-sm text-red-500"">{{ $message }}</div>
          @enderror
        </div>
        <div class="flex justify-between  w-full">
        <a href="{{ route('Register') }}" type="button" class="rounded-2xl bg-gray-900 text-white px-4 py-3 mt-3">Registrarse</a>
        <button type="submit" class="rounded-2xl bg-gray-900 text-white px-4 py-3 mt-3">Iniciar sesión</button>
        </div>
      </form>
    </div>
  </div>

</body>

</html>