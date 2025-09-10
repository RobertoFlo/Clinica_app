<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Dashboard')]

class Index extends Component
{
    public function render()
    {
        return view('livewire.dashboard.index');
    }
}
