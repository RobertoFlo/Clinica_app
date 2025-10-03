<?php

namespace App\Livewire\Consulta;

use App\Models\Medicos;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\User;
use App\Models\MntConsulta;
use Livewire\WithPagination;
use Livewire\Attributes\On;

#[Title('Consultas Medicas')]
class Consultas extends Component
{
    use WithPagination;
    #[On('item_tabla')]
    public function tabla($itemId,$accion){
        switch ($accion) {
            case 'editar':
                session()->forget('previous_url');
                session(['previous_url' => url()->previous()]);
                session(['consulta' => $itemId]);
                session(['modo_edicion' => true]);
                redirect(route('consulta.mantenimiento'));
                break;
            case 'eliminar':
                $this->dispatch('notify', ['variant' => 'warning', 'message' => 'Funcionalidad en desarrollo']);
                break;
            default:
                // Acción no reconocida
                $this->dispatch('notify', ['variant' => 'warning', 'message' => 'Acción no reconocida']);
                break;
        }
    }



   public $perPage = 5;
   public function crearConsulta(){
        session()->forget('previous_url');
        session('modo_edicion', false);
        session(['previous_url' => url()->previous()]);
        redirect(route('consulta.mantenimiento'));
   }
    public function render()
    {
        $user = Auth::user();
        $medico = Medicos::where('usuario_id', $user->id)->first();
        if($medico){
            $query = MntConsulta::with('expediente.paciente','clinico', 'tipoconsulta', 'medico', 'estado')->orderBy('id', 'desc')->where('medico_id', $medico->id);
        }else{
            $query = MntConsulta::with('expediente.paciente', 'clinico', 'tipoconsulta', 'medico', 'estado')->orderBy('id', 'desc');
        }
        $paginate = $query->paginate($this->perPage);
        return view('livewire.consulta.consultas', ['consultas' => collect($paginate->items())->map->toArray()->all()]);
    }
}
