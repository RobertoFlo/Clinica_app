<?php

namespace App\Livewire\Alergia;

use App\Models\CtlAlergia;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Attributes\On;

#[Title('Catálogo de Alergias')]
class Index extends Component
{
    public $id;
    public $accion;

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
    public function eliminar($id)
    {

        $alergia = CtlAlergia::find($id);

        if ($alergia->deleted_at !== null) {
            $alergia->deleted_at = null; // Restaurar el registro
            $alergia->save();
        } else {
            $alergia->delete();
        }
    }


    public function render()
    {
        // Usamos withTrashed() para obtener todos los registros, incluyendo los eliminados
        $datos = CtlAlergia::withTrashed()->get();
        return view('livewire.alergia.index', [
            'datos' => $datos
        ]);
    }
}
