<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    @livewire('components.titulo', ['titulo' => 'Expediente Médico'])
     <div class="w-full flex justify-end px-1 mb-6">
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
        'datos' => $datas,
        'fields' => ['numero_expediente',['paciente'=>['nombre','apellido']],['paciente'=>['documento_identidad']],'fecha_creacion','deleted_at'],
        'headers' => ['Expediente','Nombre','DUI','Fecha', 'Estado'],
        'acciones' => collect(['editar', 'eliminar']),
        ])
        <div class="mt-4 flex flex-col justify-center gap-2 px-2 w-full">
            {{ $paginator->links() }}
        </div>  

    </div>
</div>
