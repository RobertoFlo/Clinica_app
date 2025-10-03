<div>
    @livewire('components.titulo', ['titulo' => 'Mantenimiento de Consulta'])
    <div class="space-y-2">
        <div>
            <button wire:click="regresar" class="bg-gray-500 text-white rounded-md p-2">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 fill-on-info dark:fill-on-info inline-block">
                    <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Regresar
            </button>
        </div>
        @if ($modo_edicion)
        @else
        <div class="flex w-full  flex-col bg-gray-300 p-4 rounded-md">
            <div class="w-full flex flex-col gap-3">
                <div class="w-full flex md:flex-row  flex-col gap-3">
                    <input type="text" wire:model="search_expediente" placeholder="Buscar Nombre o DUI Paciente"
                        class="border border-gray-300 rounded-md shadow-sm p-2 w-full  bg-white">
                    <div class="flex gap-2 ">
                        <button wire:click="buscarPaciente" class="bg-blue-500 text-white rounded-md p-2">Buscar</button>
                        <button wire:click="limpiarPaciente" class="bg-red-500 text-white rounded-md p-2">Limpiar</button>
                    </div>
                </div>

                <ul class="w-full max-h-60 min-h-10 overflow-y-auto bg-white rounded-md p-2">
                    @foreach($expedientes as $expediente)
                    <li class="border border-gray-300 rounded-md shadow-sm p-2 my-2 w-full flex justify-between items-center">
                        <a href="#" wire:click="seleccionarPaciente({{ $expediente }})">
                            {{ $expediente->nombre }} {{ $expediente->apellido }}
                        </a>
                        <button wire:click="seleccionarPaciente({{ $expediente }})" class="bg-sky-500 text-white rounded-md px-2 py-1">Seleccionar</button>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="flex flex-col ">
                <h3 class="font-bold">Datos del Paciente</h3>
                <div class="flex md:flex-row flex-col gap-3">
                    <div class="p-4 bg-white rounded-md shadow-md md:w-1/2 flex flex-col space-y-2">
                        <p><span class="font-bold">Nombre:</span> {{ $paciente_selected ? $paciente_selected['nombre'] : '' }} {{ $paciente_selected ? $paciente_selected['apellido'] : '' }}</p>
                        <p><span class="font-bold">DUI:</span> {{ $paciente_selected ? $paciente_selected['documento_identidad'] : '' }}</p>
                        <p><span class="font-bold">Fecha Nacimiento:</span> {{ $paciente_selected ? $paciente_selected['fecha_nacimiento'] : '' }}</p>
                        <p><span class="font-bold">Genero:</span> {{ $paciente_selected ? $paciente_selected['sexo'] : '' }}</p>
                        <div>
                            <button wire:click="cambiarPaciente" class="mt-2 bg-red-500 text-white rounded-md p-2">Cambiar Paciente</button>

                            @error('paciente_selected') <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="p-4 bg-white rounded-md shadow-md md:w-1/2 space-y-3 flex flex-col">
                        <select name="tipo_consulta_selected" id="tipo_consulta_selected" wire:model="tipo_consulta_selected" class="border border-gray-300 rounded-md shadow-sm p-2 w-full bg-white @error('tipo_consulta_selected') border-red-500 @enderror">
                            <option value="">Seleccione un tipo de consulta</option>
                            @foreach($tipo_consulta as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                        @error('tipo_consulta_selected') <span class="text-red-500">{{ $message }}</span>
                        @enderror


                        <select name="medico_selected" id="medico_selected" wire:model="medico_selected" class="border border-gray-300 rounded-md shadow-sm p-2 w-full bg-white @error('medico_selected') border-red-500 @enderror">
                            <option value="">Seleccione un médico</option>
                            @foreach($medicos as $medico)
                            <option value="{{ $medico->id }}">{{ $medico->nombre }} {{ $medico->apellido }} - {{ $medico->especialidad }}</option>
                            @endforeach
                        </select>


                        @error('medico_selected') <span class="text-red-500">{{ $message }}</span>
                        @enderror

                    </div>
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <button wire:click="crearConsulta" class="bg-green-500 text-white rounded-md p-2 px-4" x-on:click={$dispatch('show-loader')}>Crear Consulta</button>
            </div>
        </div>
        @endif
    </div>
</div>