@php
$headers = ['Nombre','Categoria', 'Estado'];
$fields = ['nombre',['categoria'=>['nombre']],'deleted_at'];
$acciones = collect(['editar', 'eliminar']);
@endphp
<div>
    <div class="">
        @livewire('components.titulo', ['titulo' => 'Alergias'])
        <div class="w-full flex justify-end mb-6">
            <!-- info Button with Icon -->
            <button type="button" wire:click="modalAlergia"
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
        <div class="w-full">
            @livewire('components.tabla', [
            'datos' => $datos,
            'fields' => $fields,
            'headers' => $headers,
            'acciones' => $acciones,
            ])
            <div class="mt-4 flex flex-col justify-center gap-2 px-2 w-full">
                {{ $paginator->links() }}
            </div>
        </div>

        <div x-data="{ showModal: @entangle('showModal') }">
            <div x-show="showModal" x-transition.opacity.duration.500ms
                class="hs-overlay fixed inset-0 z-[60] bg-transparent bg-opacity-50 flex justify-center items-center">
                <div x-show="showModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="transform overflow-hidden rounded-lg bg-white border border-gray-200 shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">
                    <div class="px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 id="dialog-title" class="text-xl font-semibold text-center leading-6">Se
                                {{ $modalText }} el registro seleccionado</h3>
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
                        <button type="button" wire:click="eliminar"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white ring-1 ring-inset ring-white/5 hover:bg-blue-400 sm:mt-0 sm:w-auto">
                            Aceptar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div x-data="{ showModal: @entangle('showAlergia') }">
            <div x-show="showModal" x-transition.opacity.duration.500ms
                class="hs-overlay fixed inset-0 z-[60] bg-transparent bg-opacity-50 flex justify-center items-center">
                <div x-show="showModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="transform overflow-hidden rounded-lg bg-white border border-gray-200 shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-3/6">
                    <div class="px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <div class="mt-2 space-y-4">
                                <div>
                                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre de la
                                        Alergia</label>
                                    <input type="text" wire:model="nombre" placeholder="Nombre de la alergia"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 @error('nombre') !border-red-600 @enderror" />
                                    @error('nombre') <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <div
                                        class="relative flex w-full max-w-xs flex-col gap-1 text-on-surface dark:text-on-surface-dark">
                                        <label for="country" class="w-fit pl-0.5 text-sm">Country</label>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="absolute pointer-events-none right-4 top-8 size-5">
                                            <path fill-rule="evenodd"
                                                d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <select id="categoria" name="categoria" autocomplete="nombre"
                                            wire:model="categoria_seleccionada"
                                            class="w-full appearance-none rounded-radius border border-gray-300  px-4 py-2 text-sm @error('categoria_seleccionada') !border-red-600 @enderror ">
                                            <option value="">Seleccione Categoria</option>
                                            @foreach ($categorias as $categoria)
                                            <option value="{{ $categoria->id }}"
                                                @if($categoria_seleccionada==$categoria->id) selected @endif>{{
                                                $categoria->nombre }}</option>
                                            @endforeach
                                        </select>
                                        @error('categoria_seleccionada') <span class="text-red-600 text-sm">{{ $message
                                            }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" px-4 py-3 flex flex-col justify-center sm:flex-row gap-2">
                        <button type="button" wire:click="modalAlergiaClose"
                            class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white hover:bg-red-400 sm:ml-3 sm:w-auto">
                            Cancelar
                        </button>
                        <button type="button" wire:click="saveAlergia"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white ring-1 ring-inset ring-white/5  hover:bg-blue-400 sm:mt-0 sm:w-auto">
                            Aceptar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>