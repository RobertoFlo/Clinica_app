@extends('layouts.app')

@section('title', 'Catálogo de Alergias')

@php
    $headers = ['Nombre', 'Estado'];
    $fields = ['nombre', 'deleted_at'];
    $fiedls_especial = ['name', 'texto'];
    $acciones = collect(['editar', 'eliminar']);

@endphp
@section('content')
<div>
    <div class="flex justify-center">
        <div class="w-full max-w-6xl">
            <livewire:components.tabla
            :datos="$datos"
            :fields="$fields"
            :headers="$headers"
            :acciones="$acciones"
            :especiales="$fiedls_especial"
            />
        </div>
    </div>
</div>
@endsection


