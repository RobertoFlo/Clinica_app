<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    @livewire('components.titulo', ['titulo' => 'Citas Médicas'])
    <div class="w-full h-full border border-gray-300  rounded grid md:grid-cols-2 grid-cols-1 gap-2">
        <div class="p-4">
            <label for="paciente" class="block text-sm font-medium text-gray-700">Paciente</label>
            <input type="text" wire:model="paciente" placeholder="Buscar paciente por nombre o documento"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 @error('paciente') !border-red-600 @enderror" />
            @error('paciente') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            <div class="mt-4 max-h-96 overflow-y-auto">
                @if ($pacientes->count() > 0)
                    <ul class="divide-y divide-gray-200">
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
        <div class="p-4 border-l border-gray-300">
            @if ($selectedPaciente)
                <h2 class="text-lg font-medium text-gray-900 mb-4">Paciente Seleccionado</h2>
                <div class="mb-4">
                    <p><span class="font-semibold">Nombre:</span> {{ $selectedPaciente->nombre }}
                        {{ $selectedPaciente->apellido }}</p>
                    <p><span class="font-semibold">Documento:</span> {{ $selectedPaciente->documento_identidad }}</p>
                    <p><span class="font-semibold">Teléfono:</span> {{ $selectedPaciente->telefono }}</p>
                    <p><span class="font-semibold">Dirección:</span> {{ $selectedPaciente->direccion }}</p>
                </div>      
                <div>
                    <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha de la Cita</label>
                    <input type="date" wire:model="fecha" id="fecha"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 @error('fecha') !border-red-600 @enderror" />
                    @error('fecha') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror  
                </div>
                <div class="mt-4">
                    <label for="hora" class="block text-sm font-medium text-gray-700">Hora de la Cita</label>
                    <input type="time" wire:model="hora"      
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 @error('hora') !border-red-600 @enderror" />
                    @error('hora') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror  
                </div>
                <div class="mt-4">
                    <label for="motivo" class="block text-sm font-medium text-gray-700">Motivo de la Cita</label>
                    <textarea wire:model="motivo" id="motivo" rows="3"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 @error('motivo') !border-red-600           @enderror"></textarea>
                    @error('motivo') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror  
                </div>
                <div class="mt-6">
                    <button wire:click="agendarCita"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Agendar Cita
                </button>
                </div>
            @else
                <p class="text-gray-500">Seleccione un paciente para agendar una cita.</p>
            @endif
        </div>
    </div>


</div>  
