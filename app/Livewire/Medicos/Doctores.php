<?php

namespace App\Livewire\Medicos;

use App\Models\Medicos;
use Livewire\Component;

class Doctores extends Component
{
    public $showModal = false;
    public function modalMedicoClose()
    {
        $this->showModal = false;
    }
    public function modalMedicoOpen()
    {
        $this->showModal = true;
    }   
    public function saveMedico()
    {
        $this->showModal = false;
    }
    public function render()
    {
        $query = Medicos::withTrashed();
        $paginator = $query->paginate(10);
        return view('livewire.medicos.doctores', [
            'medicos' => $paginator->items(),
            'paginator' => $paginator,
        ]);
    }
}
