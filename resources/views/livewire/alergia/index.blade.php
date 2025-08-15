@php
    $headers = ['Nombre', 'Estado'];
    $fields = ['nombre', 'deleted_at'];
    $fields_especial = ['name', 'texto'];
    $acciones = collect(['editar', 'eliminar']);
@endphp
    <div>
        <div class="flex justify-center">
            <div class="w-full max-w-6xl">
                @livewire('components.tabla', [
                    'datos' => $datos,
                    'fields' => $fields,
                    'headers' => $headers,
                    'acciones' => $acciones,
                    'especiales' => $fields_especial,
                ])
                {{-- <livewire:components.tabla :datos="$datos" :fields="$fields" :headers="$headers" :acciones="$acciones"
                    :especiales="$fields_especial" @seleccion="$parent.seleccion_tabla" /> --}}
            </div>
        </div>
    </div>
