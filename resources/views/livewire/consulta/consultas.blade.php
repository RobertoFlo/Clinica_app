<div>
    @livewire('components.titulo', ['titulo' => 'Consultas Medicas'])
    <div class="flex justify-end mb-4">
        <button wire:click="crearConsulta" type="button"
            class="inline-flex items-center px-4 py-2 bg-green-600 gap-1 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
            Crear Consulta
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                class="size-5 fill-on-info dark:fill-on-info" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    <div>
        @livewire('components.tabla',[
        'datos' => $consultas,
        'headers' => ['Paciente', 'Medico', 'Fecha Consulta', 'Tipo Consulta', 'Estado', 'Subtotal Final'],
        'fields' => [['expediente.paciente.nombre','expediente.paciente.apellido'], 'medico.nombre', 'fecha_consulta', 'tipoconsulta.nombre', 'estado.nombre', 'subtotal_final'],
        'acciones' => collect(['editar', 'ver','eliminar']),
        ])
    </div>
</div>