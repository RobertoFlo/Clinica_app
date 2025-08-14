<?php

namespace App\Livewire\Alergia;

use App\Models\CtlAlergia;
use Livewire\Component;
use Livewire\Attributes\On;
class Index extends Component
{
    #[On('tabla')]
    public function tabla($id, $accion)
    {
        logger('Evento tabla-accion recibido', ['id' => $id, 'accion' => $accion]);
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
        try {
            $alergia = CtlAlergia::find($id);
            if ($alergia) {
                $alergia->delete();
                // Opcionalmente mostrar mensaje de éxito
                session()->flash('message', 'Alergia eliminada correctamente.');
            }
        } catch (\Exception $e) {
            // Manejar errores
            session()->flash('error', 'Error al eliminar la alergia.');
        }
    }


    public function render()
    {
        $datos = CtlAlergia::whereNull('deleted_at')->get();
        return view('livewire.alergia.index', [
        'datos' => $datos
    ]);
    }
}
