<div class="min-h-screen flex flex-col justify-center items-center " >
    <div class="bg-white p-4 rounded-lg text-center border-gray-400 border shadow-xl/30 ">
        @livewire('components.titulo', ['titulo'=> 'Solicitud de registro'])
        <form wire:submit.prevent="save" class="space-y-5 flex flex-wrap">
            <div class="w-full md:w-6/12 mx-auto px-2">
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre de Usuario</label>
                <input type="text" id="name" wire:model="name"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 @error('name') !border-red-600 @enderror" />
                @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="w-full md:w-6/12 mx-auto px-2">
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <input type="email" id="email" wire:model="email"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 @error('email') !border-red-600 @enderror" />
                @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="w-full md:w-6/12 mx-auto px-2">
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <div x-data="{ showPassword: false }" class="relative">
                    <input x-bind:type="showPassword ? 'text' : 'password'" id="passwordInput" wire:model="password"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 @error('password') !border-red-600 @enderror"
                        name="password" autocomplete="current-password" placeholder="Enter your password" />
                    <button type="button" x-on:click="showPassword = !showPassword"
                        class="absolute right-2.5 top-1/2 -translate-y-1/2 text-[#898c91]" aria-label="Show password">
                        <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
                @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="w-full md:w-6/12 mx-auto px-2">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar
                    Contraseña</label>
                <div x-data="{ showPassword: false }" class="relative">
                    <input x-bind:type="showPassword ? 'text' : 'password'" id="password_confirmation"
                        wire:model="password_confirmation"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 @error('password') !border-red-600 @enderror"
                        name="password_confirmation" autocomplete="current-password"
                        placeholder="Enter your password" />
                    <button type="button" x-on:click="showPassword = !showPassword"
                        class="absolute right-2.5 top-1/2 -translate-y-1/2 text-[#898c91]" aria-label="Show password">
                        <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="w-full flex justify-between mx-auto px-2 mt-2">
                <a type="button" href="/login" wire:navigate 
                    class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600 hover:cursor-pointer">Cancelar</a>
                <button type="submit"  
                    class=" bg-blue-500 text-white py-1.5 px-4 rounded-md hover:bg-blue-600 hover:cursor-pointer">Registrar</button>
            </div>
        </form>
    </div>
</div>