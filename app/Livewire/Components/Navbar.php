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
        $usuarios = \App\Models\User::all();
        return view('livewire.components.navbar',['user'=> $usuarios]);
    }
}
