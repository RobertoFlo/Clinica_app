<?php

namespace App\Livewire\Pasiente;

use Livewire\Component;
use App\Models\MntExpediente;   
class Expediente extends Component
{
    public function render()
    {
        $paginator = MntExpediente::withTrashed()->orderBy('id')->with('paciente')->paginate(10);
        
        return view('livewire.pasiente.expediente', ['paginator'=> $paginator,'datas'=> $paginator->items(),]); 
    }
}
