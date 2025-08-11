@extends('layouts.app')

@section('title', 'Alergias')

@section('content')
    <h1>Catálogo de Alergias</h1>
    <a href="#">Agregar Alergia</a>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($alergias as $alergia)
                <tr>
                    <td>{{ $alergia->id }}</td>
                    <td>{{ $alergia->nombre }}</td>
                    <td><a href="#">Editar</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No hay alergias registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection


