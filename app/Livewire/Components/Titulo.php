<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Titulo extends Component
{
    public $titulo ;
    public function mount($titulo)
    {
        $this->titulo = $titulo;
    }
    public function render()
    {
        return view('livewire.components.titulo');
    }
}
