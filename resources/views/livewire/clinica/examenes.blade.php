<div>
    @if($modo_edicion)
    @livewire('components.titulo', ['titulo' => 'Exámenes Médicos'])
    <div class="flex flex-col gap-4">
        <div>
            <button wire:click="goBack" type="button"
                class="inline-flex items-center px-4 py-2 bg-gray-600 gap-1 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Volver
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    class="size-5 fill-on-info dark:fill-on-info" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-xl leading-6 font-medium text-gray-900">Detalles del Examen Médico</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Información detallada de los examenes medicos.</p>
                <div class="mt-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Número de Expediente</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $persona_registo_examen->expediente->numero_expediente ?? 'N/A' }}</dd>
                            <dt class="text-sm font-medium text-gray-500">Fecha del Examen</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $persona_registo_examen->fecha_consulta ?? 'N/A' }}</dd>
                            <dt class="text-sm font-medium text-gray-500">Nombre del Paciente</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $persona_registo_examen->expediente->paciente->nombre ?? 'N/A' }} {{ $persona_registo_examen->expediente->paciente->apellido ?? '' }}</dd>
                            <dt class="text-sm font-medium text-gray-500">Sexo del Paciente</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $persona_registo_examen->expediente->paciente->sexo ?? 'N/A' }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Documento de identidad Paciente</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $persona_registo_examen->expediente->paciente->documento_identidad ?? 'N/A' }}</dd>
                            <dt class="text-sm font-medium text-gray-500">Teléfono del Paciente</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $persona_registo_examen->expediente->paciente->telefono ?? 'N/A' }}</dd>
                            <dt class="text-sm font-medium text-gray-500">Estado Clínico de los exámenes</dt>
                            <div class="flex items-center gap-2">
                            <dd class=" text-sm text-blue-900 font-bold">{{ $persona_registo_examen->estadoclinico->nombre ?? 'N/A' }}</dd> 
                            @if($modo_edicion)
                                <button wire:click="editEstadoClinico" class="text-sm text-white hover:underline bg-blue-500 border-blue-900 rounded-full px-3 py-1 ">Editar</button>
                            @endif
                            </div>
                            <dt class="text-sm font-medium text-gray-500">Total valor de Examenes</dt>
                            <dd class="mt-1 text-sm text-red-900 font-bold">$ {{ $persona_registo_examen->total_pagar ?? '--' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
            <div class="px-4 py-5 sm:px-6">
                @livewire('components.tabla', [
                'datos' => $tabla_examenes ?? [],
                'fields' => ['tipoexamen.nombre', 'resultado','tipoexamen.precio','estado.nombre'],
                'headers' => ['Tipo de Examen', 'Documento','Precio','Estado'],
                'acciones' => collect(['editar']),
                ])
            </div>
        </div>
    </div>
    @else
    @livewire('components.titulo', ['titulo' => 'Registro de Exámenes Médicos'])
    <div class="flex flex-col gap-4">
        <div>
            <button wire:click="goBack" type="button"
                class="inline-flex items-center px-4 py-2 bg-red-600 gap-1 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Cancelar y Volver
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    class="size-5 fill-on-info dark:fill-on-info" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-xl leading-6 font-medium text-gray-900">Formulario de Registro de Exámenes Médicos</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Complete el formulario para registrar los examenes medicos.</p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <h3 class="text-xl font-medium text-gray-900 text-center">Detalles del Examen</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mt-4 ">
                        <div class="flex flex-col gap-3">
                            <label for="expediente_id" class="block text-sm font-medium text-gray-700">Selección de expediente de paciente</label>
                            <input type="text" wire:model="search" id="search" name="search" class="mt-1 block  py-2 px-3 border w-full border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Buscar por nombres o apellidos">
                            <div>
                                <button wire:click="searchExpediente" class=" bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 text-sm px-3 rounded">
                                    Buscar
                                </button>
                            </div>
                        </div>
                        <div class="mt-4 overflow-y-auto">
                            @if ($search_expediente)
                            <ul class="divide-y divide-gray-200 overflow-y-auto">
                                @foreach ($search_expediente as $expediente)
                                <li class="py-2 flex justify-between items-center">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $expediente->paciente->nombre }} {{ $expediente->paciente->apellido }}</p>
                                        <p class="text-sm text-gray-500">Documento: {{ $expediente->paciente->documento_identidad ?? 'No disponible' }}</p>
                                    </div>
                                    <button wire:click="selectExpediente({{ $expediente->id }})"
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
                    <div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2 text-center">Información del Paciente</h3>
                            @if ($persona_registo_examen)
                            <div class=" p-4 rounded-lg">
                                <p class="text-sm"><strong>Expediente N°:</strong> {{ $persona_registo_examen->expediente->numero_expediente ?? 'N/A' }}</p>
                                <p class="text-sm"><strong>Nombre:</strong> {{ $persona_registo_examen->expediente->paciente->nombre ?? 'N/A' }} {{ $persona_registo_examen->expediente->paciente->apellido ?? '' }}</p>
                                <p class="text-sm"><strong>Documento:</strong> {{ $persona_registo_examen->expediente->paciente->documento_identidad ?? 'N/A' }}</p>
                                <p class="text-sm"><strong>Sexo:</strong> {{ $persona_registo_examen->expediente->paciente->sexo ?? 'N/A' }}</p>
                                <p class="text-sm"><strong>Teléfono:</strong> {{ $persona_registo_examen->expediente->paciente->telefono ?? 'N/A' }}</p>
                                <p class="text-sm"><strong>Estado Clínico:</strong> {{ $persona_registo_examen->estadoClinico->nombre ?? 'N/A' }}</p>
                                <p class="text-sm"><strong>Total de Examenes:</strong>${{ $persona_registo_examen->total_pagar ?? '0.00' }}</p>
                            </div>

                            @endif
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2 text-center">Agregar Nuevo Examen</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="tipo_examen" class="block text-sm font-medium text-gray-700">Tipo de Examen</label>
                            <select wire:model="tipo_examen_id" id="tipo_examen_id" name="tipo_examen_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('tipo_examen_id') border-red-500 @enderror">

                                <option value="">Seleccione un tipo de examen</option>
                                @foreach($tipos_examenes as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->nombre }} - <strong class="text-green-500">${{ $tipo->precio }}</strong></option>
                                @endforeach
                            </select>
                            @error('tipo_examen_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            <div class="flex justify-end">
                                <button wire:click="agregarExamen" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 gap-1 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Agregar Examen
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        class="size-5 fill-on-info dark:fill-on-info" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            @livewire('components.tabla', [
                            'datos' => $tabla_examenes ?? [],
                            'fields' => ['tipoexamen.nombre', 'resultado','tipoexamen.precio','estado.nombre'],
                            'headers' => ['Tipo de Examen', 'Documento','Precio','Estado'],
                            'acciones' => collect(['editar','destroy']),
                            ])
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-start px-5 py-4">
                <button wire:click="finalizarExamenes" x-on:click="$dispatch('show-loader')" class="mt-4 inline-flex items-center px-4 py-2 bg-green-600 gap-1 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Finalizar ficha de examenes
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        class="size-5 fill-on-info dark:fill-on-info" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    @endif
    <div wire:show="showModal" x-transition.opacity.duration.500ms
        class="hs-overlay fixed inset-0 z-[60] bg-transparent bg-opacity-50 flex justify-center items-center">
        <div wire:show="showModal" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="transform overflow-hidden rounded-lg bg-white border border-gray-200 shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm">
            <div class="px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left space-y-3">
                    <h3 id="dialog-title" class="text-xl font-semibold text-center leading-6">
                        Actualización del Estado de Examen Médico
                    </h3>
                    <p class="text-sm text-center text-gray-500">Al realizar este acción es de forma
                        inmediata.</p>
                    <div class="flex justify-center flex-col items-center">
                        <select wire:model="select_estado_examen_id"
                            class="mt-1 block w-9/12 border border-gray-300 rounded p-2 @error('select_estado_examen_id') border-red-500 @enderror">
                            <option value="">Seleccione un estado</option>
                            @foreach($estados_examenes as $estado)
                            <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                            @endforeach
                        </select>
                        @error('select_estado_examen_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class=" px-4 py-3 flex flex-col justify-center sm:flex-row gap-2">
                <button type="button" wire:click="closeModal"
                    class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white hover:bg-red-400 sm:ml-3 sm:w-auto">
                    Cancelar
                </button>
                <button type="button" wire:click="saveestado"
                    class="mt-3 inline-flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white ring-1 ring-inset ring-white/5 hover:bg-blue-400 sm:mt-0 sm:w-auto">
                    Aceptar
                </button>
            </div>
        </div>
    </div>
</div>