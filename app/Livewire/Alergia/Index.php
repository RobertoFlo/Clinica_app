<?php

namespace App\Livewire\Alergia;

use App\Models\CtlAlergia;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Attributes\On;
#[Title('Catálogo de Alergias')]
class Index extends Component
{
    public $datos;
    public $item;
    public $seleccion = null;
    public $showModal = false;

    #[On('item_tabla')]
    public function seleccion_tabla($item, $accion)
    {
        $this->item = $item;
        $this->seleccion = $accion;
        $this->showModal = true;
    }
    public function mount()
    {
        $this->loadData();
    }
    public function closeModal()
    {
        $this->showModal = false;
    }
    public function aceptarModal()
    {
        $this->showModal = false;
        switch ($this->seleccion) {
            case 'eliminar':
                $this->eliminar($this->item['id']);
                break;
            case 'editar':
                $this->editar($this->item['id']);
                break;
            case 'agregar':
                $this->agregar($this->item['id']);
                break;
        }
    }

    private function loadData()
    {
        $this->datos = CtlAlergia::withTrashed()->orderBy('id')->get();
    }

    public function eliminar($item)
    {
        $alergia = CtlAlergia::withTrashed()->find($item);
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
