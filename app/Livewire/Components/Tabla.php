<?php

namespace App\Livewire\Components;

use App\Livewire\Alergia\Index;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class Tabla extends Component
{
    public $datos;
    public $fields;
    public $headers;
    public $acciones;
    public $especiales;

    public function tabla($id,$accion)
    {
        logger('Método tabla ejecutado', ['id' => $id, 'accion' => $accion]);
        $this->dispatch('tabla', id: $id, accion: $accion)->to(Index::class);
        logger('Evento tabla-accion despachado', ['id' => $id, 'accion' => $accion]);
    }

    public function render()
    {
        return view('livewire.components.tabla');
    }
}
