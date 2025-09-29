<div>
    @livewire('components.titulo', ['titulo' => 'Consultas Medicas'])

    <div>
        @livewire('components.tabla',[
            'datos' => $consultas,
            'headers' => ['Paciente', 'Medico', 'Fecha Consulta', 'Tipo Consulta', 'Estado', 'Subtotal Final'],
            'fields' => [['expediente.paciente.nombre','expediente.paciente.apellido'], 'medico.nombre', 'fecha_consulta', 'tipoconsulta.nombre', 'estado.nombre', 'subtotal_final'],
            'acciones' => collect(['editar', 'ver','eliminar']),
        ])
    </div>
</div>
