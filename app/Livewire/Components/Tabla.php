<?php

namespace App\Livewire\Components;

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
        $this->dispatch('seleccion', id: $id, accion: $accion);
    }

    public function render()
    {
        return view('livewire.components.tabla');
    }
}
