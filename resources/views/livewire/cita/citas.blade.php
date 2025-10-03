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
                            <button wire:click="buscarCitas" class="inline-flex gap-1.5 items-center px-3 py-1.5 border border-transparent text-lg font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 hover:cursor-pointer">
                                Filtrar
                                <svg fill="#ffff" width="25px" height="25px" viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M196,128a4.0002,4.0002,0,0,1-4,4H64a4,4,0,0,1,0-8H192A4.0002,4.0002,0,0,1,196,128Zm36-52H24a4,4,0,0,0,0,8H232a4,4,0,0,0,0-8Zm-80,96H104a4,4,0,0,0,0,8h48a4,4,0,0,0,0-8Z" />
                                </svg>
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
                                class="mt-2 inline-flex gap-1.5 items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 hover:cursor-pointer">
                                Buscar
                                <svg fill="#ffff" width="20px" height="20px" viewBox="0 0 256.00098 256.00098" id="Flat" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M226.82129,221.17236,180.955,175.306a88.10138,88.10138,0,1,0-5.657,5.65649L221.165,226.82959a3.99992,3.99992,0,0,0,5.65625-5.65723ZM35.999,116a80,80,0,1,1,80,80A80.09041,80.09041,0,0,1,35.999,116Z" />
                                </svg>
                            </button>
                            <button wire:click="LimpiarPaciente"
                                class="mt-2 inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 hover:cursor-pointer">
                                Limpiar
                            </button>
                        </div>
                        <div>
                            <button wire:click="Paciente"
                                class="mt-2 inline-flex items-center gap-2 px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 hover:cursor-pointer">
                                Crear Expediente
                                <svg fill="#ffff" width="20px" height="20px" viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M252,136a4.0002,4.0002,0,0,1-4,4H228v20a4,4,0,0,1-8,0V140H200a4,4,0,0,1,0-8h20V112a4,4,0,0,1,8,0v20h20A4.0002,4.0002,0,0,1,252,136Zm-55.145,61.42578a3.99975,3.99975,0,1,1-6.125,5.14551,108.00719,108.00719,0,0,0-165.45947,0,3.9999,3.9999,0,0,1-6.125-5.146A115.828,115.828,0,0,1,82.7041,158.77777a63.99993,63.99993,0,1,1,50.5918.00006A115.832,115.832,0,0,1,196.855,197.42578ZM108,156a56,56,0,1,0-56-56A56.06353,56.06353,0,0,0,108,156Z" />
                                </svg>
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
                    @if ($modo_edicion)
                    <div class="relative w-full overflow-hidden rounded-lg border border-amber-500 bg-surface text-on-surface" role="alert">
                        <div class="flex w-full items-center gap-2 bg-amber-100 p-4">
                            <div class="bg-amber-500/15 text-amber-500 rounded-full p-1" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-2">
                                <h3 class="text-sm font-semibold text-warning">Generar una consulta</h3>
                                <p class="text-xs font-medium sm:text-sm">Para generar una consulta debe completar los detalles.</p>
                            </div>
                            <button class="ml-auto" aria-label="dismiss alert">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="2.5" class="size-4 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <select name="tipo_consulta" id="tipo_consulta" wire:model="tipo_consulta_selected"
                            class="mt-1 block w-full border border-gray-300 rounded p-2 @error('tipo_consulta_selected') border-red-500 @enderror">
                            <option value="">Seleccione Tipo de Consulta</option>
                            @foreach($tipos_consulta as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }} Precio: ${{ $tipo->precio }}</option>
                            @endforeach
                        </select>
                        @error('tipo_consulta_selected') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>

                    @endif
                    <div class="flex justify-between">
                        <div>
                            <button type="button" wire:click="LimpiarFormulario"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 hover:cursor-pointer">
                                Limpiar
                            </button>
                        </div>
                        <div class="flex flex-col gap-2">
                            @if ($modo_edicion)
                            <button type="button" wire:click="crearConsulta"
                                class="inline-flex items-center gap-2 px-4 py-2 border border-transparent text-sm font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 hover:cursor-pointer">
                                Generar Consulta
                                <svg fill="#ffff" width="20px" height="20px" viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M160,144a4.0002,4.0002,0,0,1-4,4H132v24a4,4,0,0,1-8,0V148H100a4,4,0,0,1,0-8h24V116a4,4,0,0,1,8,0v24h24A4.0002,4.0002,0,0,1,160,144Zm68.00781-64V208a12.01343,12.01343,0,0,1-12,12h-176a12.01343,12.01343,0,0,1-12-12V80a12.01343,12.01343,0,0,1,12-12H84V56a20.02229,20.02229,0,0,1,20-20h48a20.02229,20.02229,0,0,1,20,20V68h44.00781A12.01343,12.01343,0,0,1,228.00781,80ZM92,68h72V56a12.01375,12.01375,0,0,0-12-12H104A12.01375,12.01375,0,0,0,92,56ZM220.00781,80a4.00458,4.00458,0,0,0-4-4h-176a4.00458,4.00458,0,0,0-4,4V208a4.00458,4.00458,0,0,0,4,4h176a4.00458,4.00458,0,0,0,4-4Z" />
                                </svg>
                            </button>
                            @endif
                            <button type="button" wire:click="agendarCita"
                                class="inline-flex items-center gap-2 px-4 py-2 border border-transparent text-sm font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 hover:cursor-pointer">
                                {{$modo_edicion?'Actualizar':'Agendar'}} Cita
                                <svg fill="#ffff" width="20px" height="20px" viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M208,36H180V24a4,4,0,0,0-8,0V36H84V24a4,4,0,0,0-8,0V36H48A12.01343,12.01343,0,0,0,36,48V208a12.01343,12.01343,0,0,0,12,12H208a12.01343,12.01343,0,0,0,12-12V48A12.01343,12.01343,0,0,0,208,36ZM48,44H76V56a4,4,0,0,0,8,0V44h88V56a4,4,0,0,0,8,0V44h28a4.00427,4.00427,0,0,1,4,4V84H44V48A4.00427,4.00427,0,0,1,48,44ZM208,212H48a4.00427,4.00427,0,0,1-4-4V92H212V208A4.00427,4.00427,0,0,1,208,212Zm-41.09473-86.749a4.00012,4.00012,0,0,1-.1665,5.65429l-46.667,44a3.99857,3.99857,0,0,1-5.49463-.00683l-25.3335-24a3.99964,3.99964,0,1,1,5.502-5.80664l22.58886,21.39941,43.916-41.40625A4.00113,4.00113,0,0,1,166.90527,125.251Z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
        </div>
        <div class="w-full">
            <button type="button" href="/" wire:navigate
                class="inline-flex items-center gap-1.5 px-4 py-2 border border-transparent text-sm font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 hover:cursor-pointer m-3">
                Regresar
                <svg fill="#ffff" width="20px" height="20px" viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg">
                    <path d="M228,112a60.06812,60.06812,0,0,1-60,60H41.65723l41.17089,41.17187a3.99957,3.99957,0,1,1-5.65625,5.65625l-47.99847-47.998a4.045,4.045,0,0,1-.50018-.61182c-.065-.09765-.1095-.20312-.1651-.3042a3.97021,3.97021,0,0,1-.20215-.38427,3.93036,3.93036,0,0,1-.126-.40577c-.03345-.11377-.07757-.22265-.10095-.34082a4.0123,4.0123,0,0,1,0-1.5664c.02338-.11817.0675-.22705.10095-.34082a3.93036,3.93036,0,0,1,.126-.40577,3.97021,3.97021,0,0,1,.20215-.38427c.0556-.10108.1001-.20655.1651-.3042a4.02228,4.02228,0,0,1,.50049-.61182l47.99816-47.998a3.99957,3.99957,0,0,1,5.65625,5.65625L41.65723,164H168a52,52,0,0,0,0-104H80a4,4,0,0,1,0-8h88A60.06812,60.06812,0,0,1,228,112Z" />
                </svg>
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