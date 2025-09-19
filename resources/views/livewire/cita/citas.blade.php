<div>
    @livewire('components.titulo', ['titulo' => 'Citas Médicas'])
    <div class="  border border-gray-300  rounded flex  flex-wrap bg-white">
        <div class="lg:w-8/12 w-full">
            <div class="m-2">
                <div class="flex flex-col gap-4 mb-4">
                    <h2 class="text-2xl text-center mt-2 w-full">Citas Agendadas</h2>
                    <div class="flex md:flex-row flex-col w-full gap-3 items-end">
                        <div class="md:w-3/6 w-full">
                            <label for="search" class="block text-sm font-medium">Buscar</label>
                            <input type="text" wire:model="search_cita" placeholder="Buscar..."
                                class="border border-gray-300 rounded p-2 w-full" />
                        </div>
                        <div class="md:w-1/6 w-full">
                            <label class="block text-sm font-medium">Fecha de cita</label>
                            <input type="date" wire:model="fecha_cita_search" name="fecha_cita_search"
                                class="mt-1 block w-full border border-gray-300 rounded p-2 @error('fecha_cita_search') border-red-500 @enderror">
                            @error('fecha_cita_search') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="sm:w-2/6 w-full flex justify-between">
                            <button wire:click="limpiarBusqueda" class="inline-flex items-center px-3 py-1.5 border border-transparent text-lg font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 hover:cursor-pointer">
                                Limpiar
                            </button>
                            <button wire:click="buscarCitas" class="inline-flex items-center px-3 py-1.5 border border-transparent text-lg font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 hover:cursor-pointer">
                                Buscar
                            </button>
                        </div>
                    </div>
                </div>
                @livewire('components.tabla', [
                'datos' => $datos,
                'fields' => ['nombre_paciente',['medico'=>['nombre','apellido']], 'fecha_cita','hora_cita','deleted_at'],
                'headers' => ['Paciente','Médico','Fecha Cita', 'Hora Cita', 'Estado'],
                'acciones' => collect(['editar', 'eliminar','destroy']),

                ])
            </div>
            <div class="mt-4 flex flex-col justify-center gap-2 px-2 w-full">
                {{ $paginator->links() }}
            </div>
        </div>
        <div class="lg:w-4/12 w-full">
            <h2 class="text-2xl text-center mt-2">Formulario</h3>
                <div class="p-4">
                    <label for="paciente" class="block font-medium text-xl">Expedientes persona</label>
                    <input type="text" wire:model="paciente" placeholder="Buscar paciente por nombre o documento"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 @error('paciente') !border-red-600 @enderror" />
                    @error('paciente') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    <div class="flex sm:justify-between flex-col sm:flex-row">
                        <div>
                            <button wire:click="buscarPaciente"
                                class="mt-2 inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 hover:cursor-pointer">
                                Buscar
                            </button>
                            <button wire:click="LimpiarPaciente"
                                class="mt-2 inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 hover:cursor-pointer">
                                Limpiar
                            </button>
                        </div>
                        <div>
                            <button wire:click="Paciente"
                                class="mt-2 inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 hover:cursor-pointer">
                                Crear Expediente
                            </button>
                        </div>
                    </div>
                    <div class="mt-4 h-[125px] overflow-y-auto">
                        @if ($pacientes)
                        <ul class="divide-y divide-gray-200 overflow-y-auto">
                            @foreach ($pacientes as $p)
                            <li class="py-2 flex justify-between items-center">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $p->nombre }} {{ $p->apellido }}</p>
                                    <p class="text-sm text-gray-500">Documento: {{ $p->documento_identidad }}</p>
                                </div>
                                <button wire:click="selectPaciente({{ $p->id }})"
                                    class="ml-4 inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Seleccionar
                                </button>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p class="text-gray-500">No se encontraron pacientes.</p>
                        @endif
                    </div>
                </div>
                <hr>
                <form class="p-4 grid grid-cols-1 gap-4">
                    <div class="grid md:grid-cols-2 grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Hora de cita</label>
                            <input type="time" wire:model="hora_cita" name="hora_cita"
                                class="mt-1 block w-full border border-gray-300 rounded p-2 @error('hora_cita') border-red-500 @enderror">
                            @error('hora_cita') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Fecha de cita</label>
                            <input type="date" wire:model="fecha_cita" name="fecha_cita"
                                class="mt-1 block w-full border border-gray-300 rounded p-2 @error('fecha_cita') border-red-500 @enderror">
                            @error('fecha_cita') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Nombre</label>
                        <input type="text" wire:model="nombre_paciente" name="nombre" disabled
                            class="mt-1 block w-full border border-gray-300 rounded p-2 @error('nombre_paciente') border-red-500 @enderror">
                        @error('nombre_paciente') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <select wire:model="medico_selected" class="mt-1 block w-full border border-gray-300 rounded p-2 @error('medico_selected') border-red-500 @enderror">
                            <option value="">Seleccione Médico</option>
                            @foreach($medicos_planta as $medico)
                            <option value="{{ $medico->id }}">{{ $medico->nombre }} {{ $medico->apellido }}</option>
                            @endforeach
                        </select>
                        @error('medico_selected') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-between">
                        <button type="button" wire:click="LimpiarFormulario"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 hover:cursor-pointer">
                            Limpiar
                        </button>
                        <button type="button" wire:click="agendarCita"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 hover:cursor-pointer">
                            {{$modo_edicion?'Actualizar':'Agendar'}} Cita
                        </button>
                    </div>
                </form>
        </div>
        <div class="w-full">
            <button type="button" href="/" wire:navigate
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 hover:cursor-pointer m-3">
                Regresar
            </button>
        </div>
    </div>

    <div wire:show="showModal" x-transition.opacity.duration.500ms
        class="hs-overlay fixed inset-0 z-[60] bg-transparent bg-opacity-50 flex justify-center items-center">
        <div wire:show="showModal" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="transform overflow-hidden rounded-lg bg-white border border-gray-200 shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm">
            <div class="px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 id="dialog-title" class="text-xl font-semibold text-center leading-6">
                        {{ $modal_text }}
                    </h3>
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
                <button type="button" wire:click="savemodalcita"
                    class="mt-3 inline-flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white ring-1 ring-inset ring-white/5 hover:bg-blue-400 sm:mt-0 sm:w-auto">
                    Aceptar
                </button>
            </div>
        </div>
    </div>
</div>