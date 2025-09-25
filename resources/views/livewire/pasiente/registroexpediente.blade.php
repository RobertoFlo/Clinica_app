<div>
    {{-- Stop trying to control. --}}
    @livewire('components.titulo', ['titulo' => 'Registro de Expediente Médico'])
    <div class="w-full max-w-3xl mx-auto border border-gray-300 ">

        <form wire:submit="saveRegistro" class="space-y-4 bg-white p-6 rounded shadow">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Nombre</label>
                    <input type="text" wire:model="nombre" name="nombre"
                        class="mt-1 block w-full border border-gray-300 rounded p-2 @error('nombre') border-red-500 @enderror">
                    @error('nombre') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium">Apellido</label>
                    <input type="text" wire:model="apellido" name="apellido"
                        class="mt-1 block w-full border border-gray-300 rounded p-2 @error('apellido') border-red-500 @enderror">
                    @error('apellido') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium">Teléfono</label>
                    <input type="text" wire:model="telefono" name="telefono" placeholder="9999-9999" x-mask="9999-9999"
                        class="mt-1 block w-full border border-gray-300 rounded p-2 @error('telefono') border-red-500 @enderror">
                    @error('telefono') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium">Dirección</label>
                    <input type="text" wire:model="direccion" name="direccion"
                        class="mt-1 block w-full border border-gray-300 rounded p-2 @error('direccion') border-red-500 @enderror">
                    @error('direccion') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium">Documento Identidad</label>
                    <input type="text" wire:model="documento_identidad" name="documento_identidad" placeholder="99999999-9" x-mask="99999999-9"
                        class="mt-1 block w-full border border-gray-300 rounded p-2 @error('documento_identidad') border-red-500 @enderror">
                    @error('documento_identidad') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium">Fecha Nacimiento</label>
                    <input type="date" wire:model="fecha_nacimiento" name="fecha_nacimiento"
                        class="mt-1 block w-full border border-gray-300 rounded p-2 @error('fecha_nacimiento') border-red-500 @enderror">
                    @error('fecha_nacimiento') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium">Sexo</label>
                    <select name="sexo" wire:model="sexo"
                        class="mt-1 block w-full border border-gray-300 rounded p-2 @error('sexo') border-red-500 @enderror">
                        <option value="">Seleccione</option>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                    </select>
                    @error('sexo') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
            <hr>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium">Número de Expediente</label>
                    <input type="text" wire:model="numero_expediente" disabled
                        class="mt-1 block w-full border border-gray-300 rounded p-2 ">
                </div>
                <div>
                    <label class="block text-sm font-medium">Fecha de Creación</label>
                    <input type="date" wire:model="fecha_creacion" disabled
                        class="mt-1 block w-full border border-gray-300 rounded p-2 @error('fecha_creacion') border-red-500 @enderror">
                    @error('fecha_creacion') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
            <hr>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Alergias</label>
                    <select wire:model="alergia_selected"
                        class="mt-1 block w-full border border-gray-300 rounded p-2 @error('alergia_selected') border-red-500 @enderror">
                        <option value="">Seleccione</option>
                        @foreach($alergias as $alergia)
                        <option value="{{ $alergia->id }}">{{ $alergia->nombre }}</option>
                        @endforeach
                    </select>
                    @error('alergia_selected') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="flex items-start">
                    <div class="w-full flex mt-6 justify-end ">
                        <!-- info Button with Icon -->
                        <button type="button" wire:click="agregarAlergia"
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
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4">
                <div class="w-full">
                    @livewire('components.tabla', [
                    'headers' => ['Nombre','Estado'],
                    'fields' => ['nombre','deleted_at'],
                    'datos' => $alergias_selected,
                    'acciones' => collect(['destroy']),
                    ])
                </div>
            </div>
            <div class="mt-6 flex justify-between">
                <button type="submit" wire:click="goBack"
                    class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 ">Cancelar
                    </button>
                <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 gap-1 rounded hover:bg-blue-700 flex items-center justify-center">Guardar
                     <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        class="size-5 fill-on-info dark:fill-on-info" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('redirect-expediente', () => {
            setTimeout(() => {
                window.location.href = "{{ route('expediente') }}";
            }, 5000); // 5 segundos
        });
    });
</script>