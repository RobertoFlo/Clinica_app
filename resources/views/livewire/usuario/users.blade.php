<div>
    @livewire('components.titulo', ['titulo' => 'Gestión de usuarios'])
    <div>
        <div class="flex justify-end mb-4">
            <button wire:click="modalOpen" type="button"
                class="inline-flex items-center px-4 py-2 bg-green-600 gap-1 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                Agregar
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    class="size-5 fill-on-info dark:fill-on-info" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
                        clip-rule="evenodd" />
                </svg>
            </button>

        </div>
        @livewire('components.tabla',[
        'datos' => $data,
        'fields' => ['name', 'email','deleted_at'],
        'headers' => ['Usuario','Correo', 'Estado'],
        'acciones' => collect(['editar', 'eliminar']),
        ])
        <div class="w-full">
            {{ $paginator->links() }}
        </div>
    </div>
    <div wire:show="showModal" x-transition.opacity.duration.500ms
        class="hs-overlay fixed inset-0 z-[60] bg-transparent bg-opacity-50 flex justify-center items-center">
        <div wire:show="showModal" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="transform overflow-hidden rounded-lg bg-white border border-gray-200 shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2/6">
            <div class="px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <div class="mt-2 space-y-4">
                        <h1 class="text-2xl text-center">Agregar Médico</h1>
                        <div class="w-full  mx-auto px-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre de Usuario</label>
                            <input type="text" id="name" wire:model="name"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 @error('name') !border-red-600 @enderror" />
                            @error('name') <small class="text-red-600 text-sm">{{ $message }}</small> @enderror
                        </div>
                        <div class="w-full  mx-auto px-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                            <input type="email" id="email" wire:model="email"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 @error('email') !border-red-600 @enderror" />
                            @error('email') <small class="text-red-600 text-sm">{{ $message }}</small> @enderror
                        </div>
                        <div class="w-full mx-auto px-2">
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
                            @error('password') <small class="text-red-600 text-sm">{{ $message }}</small> @enderror
                        </div>
                        <div class="w-full mx-auto px-2">
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

                        <div class="w-full mx-auto px-2">
                            <div class="relative flex w-full flex-col gap-1 text-on-surface ">
                                <label for="os" class="w-fit pl-0.5 text-sm">Rol de usuario</label>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="absolute pointer-events-none right-4 top-8 size-5">
                                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                                <select name="rol_seleccionado" id="rol_seleccionado" wire:model="rol_seleccionado" class="w-full appearance-none rounded-md border border-gray-300  px-4 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 @error('rol_seleccionado') !border-red-600 @enderror">
                                    <option value="" disabled>-- Seleccione un rol --</option>
                                    @foreach ($roles as $rol)
                                    <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                                    @endforeach
                                </select>
                                  @error('rol_seleccionado') <small class="text-red-600 text-sm">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="w-full mx-auto px-2">
                            <div class="relative flex w-full flex-col gap-1 text-on-surface ">
                                <label for="os" class="w-fit pl-0.5 text-sm">Medico</label>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="absolute pointer-events-none right-4 top-8 size-5">
                                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                                <select name="medico_seleccionado" id="medico_seleccionado" wire:model="medico_seleccionado" class="w-full appearance-none rounded-md border border-gray-300  px-4 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 @error('medico_seleccionado') !border-red-600 @enderror">
                                    <option value="" disabled>-- Seleccione un medico --</option>
                                    @foreach ($medicos as $medico)
                                    <option value="{{ $medico->id }}">{{ $medico->nombre }}</option>
                                    @endforeach
                                </select>
                                  @error('medico_seleccionado') <small class="text-red-600 text-sm">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" px-4 py-3 flex flex-col justify-center sm:flex-row gap-2">
                <button type="button" wire:click="modalClose"
                    class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white hover:bg-red-400 sm:ml-3 sm:w-auto">
                    Cancelar
                </button>
                <button type="button" wire:click="saveUser"
                    class="mt-3 inline-flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white ring-1 ring-inset ring-white/5  hover:bg-blue-400 sm:mt-0 sm:w-auto">
                    Aceptar
                </button>
            </div>
        </div>
    </div>
     <div wire:show="showModalDELETE" x-transition.opacity.duration.500ms
            class="hs-overlay fixed inset-0 z-[60] bg-transparent bg-opacity-50 flex justify-center items-center">
            <div wire:show="showModalDELETE" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="transform overflow-hidden rounded-lg bg-white border border-gray-200 shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">
                <div class="px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 id="dialog-title" class="text-xl font-semibold text-center leading-6">
                            {{ $texto_modal }}</h3>
                        <div class="mt-2">
                            <p class="text-sm text-center text-gray-500">Al realizar este acción es de forma
                                inmediata.</p>
                        </div>
                    </div>
                </div>
                <div class=" px-4 py-3 flex flex-col justify-center sm:flex-row gap-2">
                    <button type="button" wire:click="closeModalDELETE"
                        class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white hover:bg-red-400 sm:ml-3 sm:w-auto">
                        Cancelar
                    </button>
                    <button type="button" wire:click="eliminar"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white ring-1 ring-inset ring-white/5 hover:bg-blue-400 sm:mt-0 sm:w-auto">
                        Aceptar
                    </button>
                </div>
            </div>
        </div>
</div>