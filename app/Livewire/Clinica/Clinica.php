<?php

namespace App\Livewire\Clinica;

use App\Models\MntClinico;
use App\Models\MntExpediente;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;


#[Title('Examenes')]
class Clinica extends Component
{
    public $perPage = 5;
    public $item = [] ;

    #[On('item_tabla')]
    public function tabla($itemId, $accion){
        $this->item = MntClinico::withTrashed()->find($itemId);
        $seleccion = $accion;
        
        switch ($seleccion) {
            case 'eliminar':
                $this->dispatch('notify', [
                    'variant' => 'info',
                    'title' => 'Editar',
                    'message' => 'Funcionalidad de edición en desarrollo.'
                ]);
                break;
            case 'editar':
                session()->forget('clinica_examen_id');
                session(['previous_url' => url()->previous()]);
                session(['clinica_examen_modo_edicion' => true]);
                $this->redirect(route('clinica.examenes', ['id' => $this->item['id']]), true);
                break;
            default:
                $this->dispatch('notify', [
                    'variant' => 'danger',
                    'title' => 'Error',
                    'message' => 'Acción no reconocida. Inténtalo de nuevo.'
                ]);
                break;
        }
    }
    public function gestionexamen(){
        session()->forget('clinica_examen_id');
        $item = MntClinico::create([
            'fecha_consulta' => now(),
            'estado_id'=>1,
            'deleted_at'=> now(),
        ]);
        session(['previous_url' => url()->previous()]);
        session(['clinica_examen_modo_edicion' => false]);

        $this->redirect(route('clinica.examenes', ['id' => $item->id]), true);
    }
    public function render()
    {
        $paginator = MntClinico::with('estadoClinico','Expediente.paciente')->orderBy('id')->paginate($this->perPage);
        $datos = collect($paginator->items())->map->toArray()->all();
        return view('livewire.clinica.clinica',[
            'paginator'=> $paginator,
            'datos' => $datos,
        ]);
    }
}
