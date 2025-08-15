<?php

namespace App\Livewire\Components;

use App\Livewire\Alergia\Index;
use Livewire\Component;

class Tabla extends Component
{
    public $datos;
    public $fields;
    public $headers;
    public $acciones;
    public $especiales;


    public function seleccion($id, $accion)
    {
        logger('Método tabla ', ['id' => $id, 'accion' => $accion]);
        $this->dispatch('seleccion', id: $id, accion: $accion)->to(Index::class, 'seleccion_tabla');
        logger('Despachado', ['id' => $id, 'accion' => $accion]);
    }

    public function render()
    {
        return view('livewire.components.tabla');
    }
}
