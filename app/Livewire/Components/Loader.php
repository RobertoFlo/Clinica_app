<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\On;

class Loader extends Component
{
    public $showLoader = false;

    #[On('show-loader')]
    public function loader ()
    {
        $this->showLoader = true;
        $this->dispatch('auto-hide-loader');
    }
     #[On('hide-loader')]
    public function loader_hide ()
    {
        $this->showLoader = false;
    }

    public function render()
    {
        return view('livewire.components.loader');
    }
}
