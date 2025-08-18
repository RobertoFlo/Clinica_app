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

    public function tabla($item, $accion)
    {
        $this->dispatch('item_tabla', item: $item, accion: $accion);
    }

    public function render()
    {
        return view('livewire.components.tabla');
    }
}
