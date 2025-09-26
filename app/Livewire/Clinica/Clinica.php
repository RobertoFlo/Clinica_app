<?php

namespace App\Livewire\Clinica;

use App\Models\MntClinico;
use App\Models\MntExpediente;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;

use function Pest\Laravel\delete;

#[Title('Examenes')]
class Clinica extends Component
{
    public $perPage = 5;
    public $item = [] ;
    public $showModal = false;
    public $modal_text = '';

    #[On('item_tabla')]
    public function tabla($itemId, $accion){
        $this->item = MntClinico::withTrashed()->find($itemId);
        $seleccion = $accion;
        
        switch ($seleccion) {
            case 'eliminar':
                if($this->item['deleted_at']) {
                    $this->modal_text = '¿Está seguro de reactivar este examen?';
                } else {
                    $this->modal_text = '¿Está seguro de desactivar este registro de examenes?';
                }
               $this->showModal = true;
                break;
            case 'editar':
                session()->forget('clinica_examen_id');
                session(['previous_url' => url()->previous()]);
                session(['clinica_examen_modo_edicion' => true]);
                $this->redirect(route('clinica.examenes', ['id' => $this->item['id']]), true);
                break;
            default:
                $this->dispatch('notify', [
                        'variant' => 'warning',
                        'title' => 'Desconocido',
                        'message' => 'Funcionalidad desconocida.'
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
    public function closeModal(){
        $this->showModal = false;
        $this->reset('item');
    }
    public function savemodalcita(){
        MntClinico::where('id', $this->item['id'])->update([
            'deleted_at' => $this->item['deleted_at'] ? null : now(),
        ]);
        $this->closeModal();
    }
    public function render()
    {
        $paginator = MntClinico::withTrashed()->with('estadoClinico','Expediente.paciente')->orderBy('id')->paginate($this->perPage);
        $datos = collect($paginator->items())->map->toArray()->all();
        return view('livewire.clinica.clinica',[
            'paginator'=> $paginator,
            'datos' => $datos,
        ]);
    }
}
