<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\On;

class Slidebar extends Component
{
    public $sidebarIsOpen = false;

    #[On('despligue')]
    public function toggleSidebar()
    {
        $this->sidebarIsOpen = !$this->sidebarIsOpen;
    }
    public function render()
    {
        return view('livewire.components.slidebar');
    }
}
