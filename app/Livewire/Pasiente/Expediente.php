<?php

namespace App\Livewire\Pasiente;

use Livewire\Component;
use App\Models\MntExpediente;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

#[Title('Expedientes')]
class Expediente extends Component
{
    public $item = []; //Ítem seleccionado de la tabla 
    public $seleccion = null; //Acción seleccionada (eliminar, editar, agregar)
    public $modalText;  //Texto dinámico para el modal de confirmación 
    public $showModal = false; //Controla modal de confirmación Desactivar/Activar 
    public $identificador;

    #[On('item_tabla')]
    public function seleccion_tabla($itemId, $accion)
    {
        $this->item = MntExpediente::withTrashed()->with('paciente')->find($itemId);
        $this->seleccion = $accion;
        switch ($this->seleccion) {
            case 'eliminar':
                $this->modalText = $this->item['deleted_at'] ? "restaurar" : "desactivara";
                $this->openModal();
                break;
            case 'editar':
                session(['previous_url' => url()->previous()]);
                $this->redirect(route('registro.expediente', ['id' => $this->item['id']]), true);
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
    public function crear()
    {
        session(['previous_url' => url()->previous()]);
        $this->redirect('registro-expediente');
    }
    public function openModal()
    {
        $this->showModal = true;
    }
    public function closeModal()
    {
        $this->showModal = false;
    }


    public function eliminar()
    {
        $registro = MntExpediente::withTrashed()->find($this->item['id']);
        if ($registro->deleted_at) {
            $registro->deleted_at = null;
            $registro->save();
        } else {
            $registro->delete();
        }
        $this->dispatch('notify', [
            'variant' => $registro->deleted_at ? 'danger' : 'success',
            'title' => '¡Éxito!',
            'message' => $registro->deleted_at ? 'Expediente desactivado correctamente.' : 'Expediente restaurado correctamente.'
        ]);
        $this->closeModal();
    }
    public function render()
    {
        $paginator = MntExpediente::withTrashed()->orderBy('id')->with('paciente')->paginate(10);

        return view('livewire.pasiente.expediente', ['paginator' => $paginator, 'datos' => collect($paginator->items())->map->toArray()->all(),]);
    }
}
