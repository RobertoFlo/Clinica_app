<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    @livewire('components.titulo', ['titulo' => 'Expediente Médico'])
     <div class="w-full flex justify-end  mb-6">
        <!-- info Button with Icon -->
        <button type="button" href="/registro-expediente" wire:navigate
            class="inline-flex justify-center items-center gap-2 whitespace-nowrap rounded-radius bg-blue-300 border border-blue-800 px-4 py-2 text-sm font-medium tracking-wide transition hover:opacity-75 text-center focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-info active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed">
            Agregar
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                class="size-5 fill-on-info dark:fill-on-info" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    <div class="w-full">
        @livewire('components.tabla', [
        'datos' => $datos,
        'fields' => ['numero_expediente',['paciente'=>['nombre','apellido']],['paciente'=>['documento_identidad']],'fecha_creacion','deleted_at'],
        'headers' => ['Expediente','Nombre','DUI','Fecha', 'Estado'],
        'acciones' => collect(['editar', 'eliminar']),
        ])
        <div class="mt-4 flex flex-col justify-center gap-2 px-2 w-full">
            {{ $paginator->links() }}
        </div>
        <div wire:show="showModal" x-transition.opacity.duration.500ms
            class="hs-overlay fixed inset-0 z-[60] bg-transparent bg-opacity-50 flex justify-center items-center">
            <div wire:show="showModal" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="transform overflow-hidden rounded-lg bg-white border border-gray-200 shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">
                <div class="px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 id="dialog-title" class="text-xl font-semibold text-center leading-6">Se
                            {{ $modalText }} el registro seleccionado</h3>
                        <div class="mt-2">
                            <p class="text-sm text-center text-gray-500">Al realizar este acción es de forma
                                inmediata.</p>
                        </div>
                    </div>
                </div>
                <div class=" px-4 py-3 flex flex-col justify-center sm:flex-row gap-2">
                    <button type="button" wire:click="closeModal"
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
</div>
