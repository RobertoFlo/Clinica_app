<div>
    @livewire('components.titulo', ['titulo' => 'Gestion de examenes clinicos'])
    <div class="flex justify-end mb-4">
            <button wire:click="gestionexamen" type="button"
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
    <div class="my-4">
        @livewire('components.tabla', [
            'datos' => $datos,
           'fields' => ['expediente.numero_expediente', ['expediente.paciente.nombre', 'expediente.paciente.apellido'], 'fecha_consulta', 'estado_clinico.nombre','deleted_at'],
            'headers' => ['Expediente','Nombre Paciente', 'Fecha Consulta', 'Estado Examen','Estado Registro'],
            'acciones' => collect(['ver', 'editar', 'eliminar']),
        ])
    </div>

    <div class="my-4">
        {{ $paginator->links() }}
    </div>
</div>
