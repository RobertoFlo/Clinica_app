<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Navbar extends Component
{
    public function menu(){
        $this->dispatch('despligue');
    }
    public function render()
    {
        return view('livewire.components.navbar');
    }
}
