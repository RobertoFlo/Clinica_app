<div>
    @livewire('components.titulo', ['titulo' => 'Medicos de planta'])
    <div>
        <div class="flex justify-end mb-4">
            <button wire:click="modalMedicoOpen" type="button"
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
        'datos' => $medicos,
        'fields' => [['nombre', 'apellido'], 'especialidad','deleted_at'],
        'headers' => ['Nombre','Especialidad', 'Estado'],
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
                                <div>
                                    <label for="nombre">Nombre</label>
                                    <input type="text" id="nombre" wire:model="nombre"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 @error('nombre') !border-red-600 @enderror">
                                    @error('nombre') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="apellido">Apellido</label>
                                    <input type="text" id="apellido" wire:model="apellido"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 @error('apellido') !border-red-600 @enderror">
                                    @error('apellido') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="especialidad">Especialidad</label>
                                    <input type="text" id="especialidad" wire:model="especialidad"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 @error('especialidad') !border-red-600 @enderror">
                                    @error('especialidad') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" px-4 py-3 flex flex-col justify-center sm:flex-row gap-2">
                        <button type="button" wire:click="modalMedicoClose"
                            class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white hover:bg-red-400 sm:ml-3 sm:w-auto">
                            Cancelar
                        </button>
                        <button type="button" wire:click="saveMedico"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white ring-1 ring-inset ring-white/5  hover:bg-blue-400 sm:mt-0 sm:w-auto">
                            Aceptar
                        </button>
                    </div>
                </div>
            </div>
</div>