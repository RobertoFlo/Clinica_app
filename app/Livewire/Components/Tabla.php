<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\Reactive;

class Tabla extends Component
{
    #[Reactive] 
    public $datos;
    public $fields;
    public $headers;
    public $acciones;
    public $especiales;

    // public function tabla($accion)
    // {
    //     $this->dispatch('item_tabla',  itemId: $this->datos->id, accion: $accion);
    // }

    public function render()
    {
        return view('livewire.components.tabla');
    }
}
