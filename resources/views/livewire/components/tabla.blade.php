<div class=" w-full  overflow-x-auto shadow">
    <table class="min-w-full divide-y divide-gray-200 overflow-x-auto">
        <thead class="bg-gray-800">
            <tr>
                @foreach ($headers as $header)
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                        {{ $header }}
                    </th>
                @endforeach
                @if (isset($acciones) && $acciones->count() > 0)
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                        Acciones
                    </th>
                @endif
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($datos as $data)
                <tr class="hover:bg-blue-100">
                    @foreach ($fields as $field)
                        <td class="px-6 py-4 whitespace-nowrap text-sm ">
                            @if ($field === 'deleted_at')
                                <span
                                    class=" inline-flex  leading-5 font-semibold rounded text-white px-2 py-1 {{ data_get($data, $field) ? 'bg-red-500 text-red-800' : 'bg-green-500 text-green-800' }}">
                                    {{ data_get($data, $field) ? 'Inactivo' : 'Activo' }}
                                </span>
                            @else
                                @php
                                    // Función auxiliar para aplanar las rutas de los arrays anidados
                                    $flattenKeys = function (array $keys, string $prefix = '') use (&$flattenKeys) {
                                        $result = [];
                                        foreach ($keys as $key => $value) {
                                            if (is_array($value)) {
                                                $result = array_merge($result, $flattenKeys($value, $prefix . ($prefix ? '.' : '') . $key));
                                            } else {
                                                $result[] = $prefix . ($prefix ? '.' : '') . $value;
                                            }
                                        }
                                        return $result;
                                    };
                                    // Generamos la lista final de rutas a buscar
                                    $fieldsToProcess = is_array($field) && !array_is_list($field)
                                        ? $flattenKeys($field)
                                        : (array) $field;
                                @endphp
                                {{-- Recorremos la lista aplanada y mostramos los valores --}}
                               {!! collect($fieldsToProcess)->map(fn($f) => formatValue(data_get($data, $f)))->implode(' ') !!}
                            @endif
                        </td>
                    @endforeach
                    @if (isset($acciones) && $acciones->count() > 0)
                        <td class="px-6 py-4 whitespace-nowrap  text-sm font-medium w-[150px] flex gap-3">
                            @if ($acciones->contains('ver'))
                                <a href="#" wire:click="$dispatch('item_tabla', { itemId: {{ data_get($data, 'id') }} , accion: 'ver' })" title="Ver Detalles"
                                    class=" text-blue-600 hover:text-blue-900">
                                    <svg width="19px" height="19px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="#000000"><path fill-rule="evenodd" clip-rule="evenodd" d="M1 10c0-3.9 3.1-7 7-7s7 3.1 7 7h-1c0-3.3-2.7-6-6-6s-6 2.7-6 6H1zm4 0c0-1.7 1.3-3 3-3s3 1.3 3 3-1.3 3-3 3-3-1.3-3-3zm1 0c0 1.1.9 2 2 2s2-.9 2-2-.9-2-2-2-2 .9-2 2z"/></svg>
                                </a>
                            @endif
                            @if ($acciones->contains('editar') && data_get($data, 'deleted_at') === null)
                                <a href="#" wire:click="$dispatch('item_tabla', { itemId: {{ data_get($data, 'id') }} , accion: 'editar' })" title="Editar"
                                    class="text-indigo-600 hover:text-indigo-900">
                                <svg width="19px" height="19px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="#000000"><path d="M13.23 1h-1.46L3.52 9.25l-.16.22L1 13.59 2.41 15l4.12-2.36.22-.16L15 4.23V2.77L13.23 1zM2.41 13.59l1.51-3 1.45 1.45-2.96 1.55zm3.83-2.06L4.47 9.76l8-8 1.77 1.77-8 8z"/></svg>
                            @endif
                            @if ($acciones->contains('eliminar'))
                                <a href="#" wire:click="$dispatch('item_tabla', { itemId: {{ data_get($data, 'id') }} , accion: 'eliminar' })" title="{{ data_get($data, 'deleted_at') ? 'Activar' : 'Desactivar' }}"
                                    class="{{ data_get($data, 'deleted_at') ? 'text-green-600 hover:text-green-900' : 'hover:text-red-900 text-red-600' }}">
                                    @if (data_get($data, 'deleted_at'))
                                    <svg width="19px" height="19px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="#000000"><path fill-rule="evenodd" clip-rule="evenodd" d="M2.006 8.267L.78 9.5 0 8.73l2.09-2.07.76.01 2.09 2.12-.76.76-1.167-1.18a5 5 0 0 0 9.4 1.983l.813.597a6 6 0 0 1-11.22-2.683zm10.99-.466L11.76 6.55l-.76.76 2.09 2.11.76.01 2.09-2.07-.75-.76-1.194 1.18a6 6 0 0 0-11.11-2.92l.81.594a5 5 0 0 1 9.3 2.346z"/></svg>
                                    @else
                                    <svg width="19px" height="19px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="#000000"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.116 8l-4.558 4.558.884.884L8 8.884l4.558 4.558.884-.884L8.884 8l4.558-4.558-.884-.884L8 7.116 3.442 2.558l-.884.884L7.116 8z"/></svg>
                                    @endif
                                </a>
                            @endif
                            @if ($acciones->contains('destroy'))
                                <a href="#" wire:click="$dispatch('item_tabla', { itemId: {{ data_get($data, 'id') }} , accion: 'destroy' })"
                                    class=" hover:text-red-900 text-red-600" title="Eliminar Permanentemente">
                                    <svg width="19px" height="19px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="#000000"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 3h3v1h-1v9l-1 1H4l-1-1V4H2V3h3V2a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v1zM9 2H6v1h3V2zM4 13h7V4H4v9zm2-8H5v7h1V5zm1 0h1v7H7V5zm2 0h1v7H9V5z"/></svg>
                                </a>
                            @endif
                            @if ($acciones->contains('agregar'))
                                <a href="#" wire:click="$dispatch('item_tabla', { itemId: {{ data_get($data, 'id') }} , accion: 'agregar' })"
                                    class=" text-blue-600 hover:text-blue-900" title="Agregar Nuevo Registro">
                                  <svg width="19px" height="19px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="#000000"><path d="M14 7v1H8v6H7V8H1V7h6V1h1v6h6z"/></svg>
                            @endif
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) + (isset($acciones) && $acciones->count() > 0 ? 1 : 0) }}"
                        class="px-6 py-4 text-center text-sm ">
                        No hay registros
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


{{-- indicaciones de uso:
- headers: array con los nombres de las columnas
- fields: array con los nombres de los campos en los datos
- datos: array de datos a mostrar

- acciones: array con las acciones a mostrar (opcional)
- wire:listen: nombre del evento a emitir al seleccionar una fila (opcional)

ejemplo de uso:
las acciones pueden ser: agregar, editar, eliminar
se debe de declarar como colección

$acciones = collect(['editar', 'eliminar']);

<livewire:table :datos="$ejemplo" :fields="['nombre','apellidos']" :headers="['Nombre','Apellidos']"
    :acciones="$acciones"  wire:listen="filaSeleccionada" /> --}}