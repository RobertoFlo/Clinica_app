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
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full  {{ data_get($data, $field) ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    {{ data_get($data, $field) ? 'Inactivo' : 'Activo' }}
                                </span>
                            @else
                                @if (is_array($field))
                                    @foreach ($field as $parent => $children)
                                        @if (is_array($children))
                                            @foreach ($children as $child)
                                                {{ data_get($data, "$parent.$child") }}
                                            @endforeach
                                        @else
                                            {{ data_get($data, "$parent.$children") }}
                                        @endif
                                    @endforeach
                                @else
                                    {{ data_get($data, $field) }}
                                @endif
                            @endif
                        </td>
                    @endforeach
                    @if (isset($acciones))
                        <td class="px-6 py-4 whitespace-nowrap  text-sm font-medium w-[280px]">
                            @if ($acciones->contains('editar') && data_get($data, 'deleted_at') === null)
                                <a href="#" wire:click="$dispatch('item_tabla', { itemId: {{ data_get($data, 'id') }} , accion: 'editar' })"
                                    class="text-indigo-600 hover:text-indigo-900">Editar</a>
                            @endif
                            @if ($acciones->contains('eliminar'))
                                <a href="#" wire:click="$dispatch('item_tabla', { itemId: {{ data_get($data, 'id') }} , accion: 'eliminar' })"
                                    class="ml-2 {{ data_get($data, 'deleted_at') ? 'text-green-600 hover:text-green-900' : 'hover:text-red-900 text-red-600' }}">
                                    {{ data_get($data, 'deleted_at') ? 'Activar' : 'Desactivar' }}
                                </a>
                            @endif
                            @if ($acciones->contains('destroy'))
                                <a href="#" wire:click="$dispatch('item_tabla', { itemId: {{ data_get($data, 'id') }} , accion: 'destroy' })"
                                    class="ml-2 hover:text-red-900 text-red-600">
                                    Eliminar
                                </a>
                            @endif
                            @if ($acciones->contains('agregar'))
                                <a href="#" wire:click="$dispatch('item_tabla', { itemId: {{ data_get($data, 'id') }} , accion: 'agregar' })"
                                    class="ml-2 text-blue-600 hover:text-blue-900">
                                    Agregar
                                </a>
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