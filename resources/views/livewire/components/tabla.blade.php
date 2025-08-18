<div class=" w-full -m-1.5 overflow-x-auto">
    <div class="p-1.5 min-w-full inline-block align-middle">
        <div class="overflow-hidden">
            <table class="min-w-full table-fixed" wire:poll.1s>
                <thead class=" dark:bg-blue-500  border-b ">
                    <tr class="divide-gray-200 dark:divide-neutral-700">
                        @foreach ($headers as $header)
                            <th scope="col" class="px-6 py-3 text-start text-xs text-white font-medium  uppercase">
                                {{ $header }}
                            </th>
                        @endforeach
                        @if (isset($acciones) && $acciones->count() > 0)
                            {{-- Si hay acciones, se agrega una columna para las acciones --}}
                            <th scope="col" class="px-6 py-3 text-white text-xs font-medium  uppercase">
                                Acciones
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                    @forelse ($datos as $data)
                        <tr class="hover:bg-gray-100 dark:hover:bg-neutral-100">
                            @foreach ($fields as $field)
                                <td
                                    class="px-6 py-4 text-md font-medium{{ $field === 'deleted_at' ? '   w-[275px]' : '' }} ">
                                    @if ($field === 'deleted_at')
                                        <a
                                            class="border rounded px-2 py-1  text-center w-4/12 px-4 py-2 {{ $data->$field ? 'bg-red-600 text-white border-red-600' : 'bg-green-800 text-white border-green-800' }}">
                                            {{ $data->$field ? 'Inactivo' : 'Activo' }}
                                        </a>
                                    @else
                                        @if (is_array($data->$field ?? null) && isset($especiales))
                                            @foreach ($data->$field as $item)
                                                @foreach ($especiales as $especial)
                                                    @if (isset($item[$especial]))
                                                        {{ $item[$especial] }}
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @else
                                            {{ $data->$field }}
                                        @endif
                                    @endif
                                </td>
                            @endforeach
                            @if (isset($acciones))
                                <td class="py-4 text-sm w-[250px] font-medium">
                                    {{-- Aquí se generan los botones de acción --}}
                                    <div class="flex justify-center items-center gap-2">
                                        {{-- Verifica si hay acciones y genera los botones correspondientes --}}
                                        @if ($acciones->contains('agregar'))
                                            <a type="button" wire:click="tabla({{ $data}},'agregar' )"
                                                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-teal-500 text-white hover:bg-teal-600 focus:outline-hidden focus:bg-teal-600 disabled:opacity-50 disabled:pointer-events-none hover:cursor-pointer">
                                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 4.5v15m7.5-7.5h-15" />
                                                </svg>
                                            </a>
                                        @endif
                                        @if ($acciones->contains('editar'))
                                            <a type="button" wire:click="tabla({{ $data }},'editar')"
                                                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-yellow-500 text-white hover:bg-yellow-600 focus:outline-hidden focus:bg-yellow-600 disabled:opacity-50 disabled:pointer-events-none hover:cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.678.736a.5.5 0 0 1-.65-.65l.736-2.678a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                </svg>
                                            </a>
                                        @endif
                                        @if ($acciones->contains('eliminar'))
                                            <a type="button" wire:click="tabla({{ $data }},'eliminar')"
                                                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent  text-white  focus:outline-hidden  disabled:opacity-50 disabled:pointer-events-none hover:cursor-pointer {{ $data->deleted_at ? 'bg-blue-500 hover:bg-blue-600 focus:bg-blue-600' : 'bg-red-500 hover:bg-red-600 focus:bg-red-600' }}">
                                                {{-- Cambia el ícono según el estado de deleted_at --}}
                                                @if ($data->deleted_at)
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 15L3 9m0 0l6-6m-6 6h12a6 6 0 010 12h-3" />
                                                    </svg>
                                                @else
                                                    <svg class="h-4 w-4 " fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-9V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                @endif


                                            </a>
                                        @endif
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($headers) + (isset($acciones) && $acciones->count() > 0 ? 1 : 0) }}"
                                class="px-6 py-4 text-center text-sm  dark:text-neutral-400">
                                No hay registros
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>


{{-- indicaciones de uso:
    - headers: array con los nombres de las columnas
    - fields: array con los nombres de los campos en los datos
    - datos: array de datos a mostrar
    - especiales: array con los nombres de los campos especiales, es para impresión de una variable dentro de otra variable (opcional)
    - acciones: array con las acciones a mostrar (opcional)
    - wire:listen: nombre del evento a emitir al seleccionar una fila (opcional)

    ejemplo de uso:
    las acciones pueden ser: agregar, editar, eliminar
    se debe de declarar como colección

    $acciones = collect(['editar', 'eliminar']);

    <livewire:table
        :datos="$ejemplo"
        :fields="['nombre','apellidos']"
        :headers="['Nombre','Apellidos']"
        :acciones="$acciones"
        :especiales="['name', 'texto']"
        wire:listen="filaSeleccionada"
    /> --}}

