<?php

namespace App\Livewire\Alergia;

use App\Models\CtlAlergia;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
#[Title('Catálogo de Alergias')]
class Index extends Component
{
    public $datos;
    public $showModal = false;
    #[On('seleccion')]
    public function seleccion_tabla($id, $accion)
    {
        logger('recibido', ['id' => $id, 'accion' => $accion]);
        switch ($accion) {
            case 'eliminar':
                $this->eliminar($id);
                break;
            case 'editar':
                $this->editar($id);
                break;
            case 'agregar':
                $this->agregar($id);
                break;
        }
    }
    public function mount()
    {
        $this->loadData();
    }

    private function loadData()
    {
        $this->datos = CtlAlergia::withTrashed()->orderBy('id')->get();
    }

    public function eliminar($id)
    {
        $alergia = CtlAlergia::withTrashed()->find($id);
        if ($alergia->deleted_at) {
            $alergia->deleted_at = null;
            $alergia->save();
            $this->render();
        } else {
            $alergia->delete();
            $this->render();
        }
    }

    public function render()
    {
        return view('livewire.alergia.index');
    }
}
