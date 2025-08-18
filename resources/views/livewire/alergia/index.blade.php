@php
    $headers = ['Nombre', 'Estado'];
    $fields = ['nombre', 'deleted_at'];
    $fields_especial = ['name', 'texto'];
    $acciones = collect(['editar', 'eliminar']);
    // $data = $datos;
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

        </div>


        {{--
    </div><button x-on:click="$wire.showModal = true"
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded hover:cursor-pointer">New
        Post</button>

    <div wire:show="showModal">
        <div>hola</div>
    </div> --}}



        {{-- otro boton  --}}
        
    </div>
