<div>
    @livewire('components.titulo', ['titulo' => 'Mantenimiento de Consulta'])
    <div class="">
        <div>
            <button wire:click="regresar" class="bg-gray-500 text-white rounded-md p-2">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 fill-on-info dark:fill-on-info inline-block">
                    <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Regresar
            </button>
        </div>
        @if ($modo_edicion)
        <div class="flex flex-wrap space-y-3">
            <div class="flex w-full flex-col  p-4 rounded-md mb-4 space-y-4">
                <h3 class="font-bold text-3xl text-center uppercase">informacion de consulta</h3>
                <div class="border shadow-md rounded-md p-4 w-full">
                    <p><span class="font-bold">Paciente:</span> {{ $paciente_selected->expediente->paciente->nombre }} {{ $paciente_selected->expediente->paciente->apellido }}</p>
                    <p><span class="font-bold">DUI:</span> {{ $paciente_selected->expediente->paciente->documento_identidad }}</p>
                    <p><span class="font-bold">Fecha Nacimiento:</span> {{ $paciente_selected->expediente->paciente->fecha_nacimiento }}</p>
                    <p><span class="font-bold">Genero:</span> {{ $paciente_selected->expediente->paciente->sexo }}</p>
                    <p><span class="font-bold">Tipo Consulta:</span> {{ $paciente_selected->tipoconsulta->nombre }}</p>
                    <p><span class="font-bold">Médico:</span> {{ $paciente_selected->medico->nombre }} {{ $paciente_selected->medico->apellido }}</p>
                    <p><span class="font-bold">Estado Consulta:</span> {{ $paciente_selected->estado->nombre }}</p>
                    <p><span class="font-bold">Subtotal Final:</span> ${{ number_format($paciente_selected->subtotal_final, 2) }}</p>
                </div>
                <div class=" space-y-2">
                    <h3 class="font-bold text-3xl text-center uppercase">informacion examenes clinicos</h3>
                    @if (count($paciente_selected_examenes) == 0)
                    <div class="flex justify-end">
                        <button wire:click="agregarFicha" class="bg-green-500 text-white rounded-md p-2">Agregar Ficha
                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-5 fill-on-info dark:fill-on-info inline-block" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    @endif
                    <div>
                        @livewire('components.tabla',[
                        'datos' => $paciente_selected_examenes,
                        'headers' => [ 'Tipo Examen','Documento','Estado'],
                        'fields' => ['tipoexamen.nombre', 'documento_publico', 'estado.nombre'],
                        ])
                    </div>
                </div>
                <div class=" space-y-4">
                    <h3 class="font-bold text-3xl text-center uppercase">Sintomas</h3>
                   
                    <div class="flex w-full  flex-col gap-1 text-slate-700 ">
                        <label for="textAreasintomas" class="w-fit pl-0.5 text-xl">Sintomas del paciente</label>
                        <textarea id="textAreasintomas" wire:model.live.debounce.250ms="descripcion_consulta"  class="w-full rounded-lg border border-slate-300 bg-white px-2.5 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 disabled:cursor-not-allowed disabled:opacity-75" rows="6" placeholder="We'd love to hear from you..."></textarea>
                      
                    </div>

                </div>
                <div class=" space-y-4">
                    <h3 class="font-bold text-3xl text-center uppercase">informacion recetas medicas</h3>
                    <div class="w-full flex justify-end">

                        @if($this->paciente_selected->receta)
                        <button class="bg-blue-500 text-white rounded-md p-2">Impresion
                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 fill-on-info dark:fill-on-info inline-block">
                                <path d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0014.414 6L10 1.586A2 2 0 008.586 1H6zm5 1.5v3a1.5 1.5 0 001.5 1.5h3l-4.5-4.5zM6 4h2v3a1 1 0 001 1h3v9H6V4zm2 5a1 1 0 100 2h4a1 1 0 100-2H8zm-1 3a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1z" />
                            </svg>
                        </button>
                        @else
                        <button wire:click="agregarReceta" class="bg-green-500 text-white rounded-md p-2 hover:cursor-pointer">Guardar Receta
                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-5 fill-on-info dark:fill-on-info inline-block" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        @endif
                    </div>
                    <div class="flex w-full  flex-col gap-1 text-slate-700 ">
                        <label for="textArea" class="w-fit pl-0.5 text-xl">Indicaciones de Medicas</label>
                        <textarea id="textArea" wire:model="indicaciones_medicas" {{ !empty($this->paciente_selected->receta) ? 'disabled' : '' }}  class="w-full rounded-lg border border-slate-300 bg-white px-2.5 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 disabled:cursor-not-allowed disabled:opacity-75" rows="6" placeholder="We'd love to hear from you..."></textarea>
                        @error( 'indicaciones_medicas') <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="flex justify-end mt-4">
                    <button wire:click="guardarIndicaciones" class="bg-blue-500 text-white rounded-md p-2">Finalizar consulta</button>
                </div>
            </div>
            <div wire:show="showModal" x-transition.opacity.duration.500ms x-cloak
                class="hs-overlay fixed inset-0 z-[60] bg-transparent bg-opacity-50 flex justify-center items-center">
                <div wire:show="showModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="transform overflow-hidden rounded-lg bg-white border border-gray-200 shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2/6">
                    <div class="px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <div class="mt-2 space-y-4">
                                <h1 class="text-2xl text-center">Ficha de examenes</h1>
                                <div class="overflow-y-auto max-h-40">
                                    @foreach($informacion_ficha as $examen)
                                    <div class="flex flex-col border border-gray-300 rounded-md p-2 text-sm ">
                                        <p><strong>Fecha de examenes:</strong> {{ $examen->fecha_consulta }}</p>
                                        <p><strong>Estado:</strong> {!! formatValue($examen->nombre) !!}</p>
                                        <p class="text-wrap"><strong>Examenes realizados:</strong>{{ $examen->todos_examenes }}</p>
                                        <div class="flex justify-end">
                                            <button wire:click="anexarExamen({{ $examen->id }})" class="bg-green-500 text-white rounded-md p-1">Anexar</button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" px-4 py-3 flex flex-col justify-center sm:flex-row gap-2">
                        <button type="button" wire:click="modalFichaClose"
                            class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white hover:bg-red-400 sm:ml-3 sm:w-auto">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
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