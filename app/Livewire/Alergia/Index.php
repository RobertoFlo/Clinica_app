<?php

namespace App\Livewire\Alergia;

use App\Models\CategoriaAlergia;
use App\Models\CtlAlergia;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\WithPagination;
#[Title('Catálogo de Alergias')]
class Index extends Component
{
    use WithPagination;
    public $datos;//Datos de la tabla
    public $item = []; //Ítem seleccionado de la tabla 
    public $seleccion = null; //Acción seleccionada (eliminar, editar, agregar)
    public $showModal = false; //Controla modal de confirmación Desactivar/Activar 
    public $showAlergia = false; //Controla modal de agregar/editar alergia
    public $modalText;  //Texto dinámico para el modal de confirmación 
    public $id_alergia; //identificador de la alergia
    #[Validate('required|string|min:4|max:25|regex:/^[\p{L}]+$/u')]
    public $nombre = ''; //Nombre de la alergia
    public $categorias =[];

    public $total =0;//total de registros
    public $currentPage = 1;//página actual
    public $lastPage;//última página
    public $perPage = 5;// registros por página

    

    #[On('item_tabla')]
    public function seleccion_tabla($item, $accion)
    {
        $this->item = $item;
        $this->seleccion = $accion;
        $this->modalText = $item['deleted_at'] ? "restaurar" : "eliminar";
        $this->aceptarModal();
    }
    public function mount()
    {
        $this->loadData();
    }
    public function openModal()
    {
        $this->showModal = true;
    }
    public function closeModal()
    {
        $this->showModal = false;
    }
    public function modalAlergia()
    {      
        $this->categorias = CategoriaAlergia::withTrashed()->get();
        // dd( $this->categorias
        $this->showAlergia = true;
    }
    public function modalAlergiaClose()
    {
        $this->showAlergia = false;
        $this->reset('nombre');
        $this->resetErrorBag(); // Limpia los mensajes de error
    }
    public function saveAlergia()
    {
        $this->validate();
        $this->dispatch('show-loader');
        try {
            if ($this->id_alergia) {
                $alergia = CtlAlergia::withTrashed()->find($this->id_alergia);
                $alergia->nombre = $this->nombre;
                $alergia->save();
                $this->dispatch('notify', [
                    'variant' => 'success',
                    'title' => '¡Éxito!',
                    'message' => 'Alergia editada correctamente.'
                ]);
                $this->reset('id_alergia','nombre');
                $this->showAlergia = false;
                $this->loadData();
            } else {
                CtlAlergia::create([
                    'nombre' => $this->nombre
                ]);
                $this->dispatch('notify', [
                    'variant' => 'success',
                    'title' => '¡Éxito!',
                    'message' => 'Alergia agregada correctamente.'
                ]);
                $this->reset('nombre');
                $this->showAlergia = false;
                $this->loadData();
            }
        } catch (\Exception $e) {
            $this->reset('nombre');
            $this->dispatch('notify', [
                'variant' => 'danger',
                'title' => 'Error',
                'message' => 'Hubo un error al guardar la alergia. Inténtalo de nuevo.'
            ]);
        }
    }
    public function aceptarModal()
    {
        switch ($this->seleccion) {
            case 'eliminar':
                $this->openModal();
                break;
            case 'editar':
                $this->editar($this->item['id']);
                break;
        }
    }

    private function loadData()
    {
        $alergia = CtlAlergia::with(['categoria'])->withTrashed()->orderBy('id')->paginate(perPage: $this->perPage);
        $this->datos = $alergia->items();
           $this->total = $alergia->total();
        $this->perPage = $alergia->perPage();
        $this->currentPage = $alergia->currentPage();
        $this->lastPage = $alergia->lastPage();
    }

    public function eliminar()
    {
        $alergia = CtlAlergia::withTrashed()->find($this->item['id']);
        if ($alergia->deleted_at) {
            $alergia->deleted_at = null;
            $alergia->save();
        } else {
            $alergia->delete();
        }
        $this->closeModal();
        $this->loadData();
    }
    public function editar($item)
    {
        $alergia = CtlAlergia::withTrashed()->find($item);
        $this->nombre = $alergia->nombre;
        $this->id_alergia = $alergia->id;
        $this->modalAlergia();
    }
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre de la alergia es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
            'nombre.max' => 'El nombre no puede tener más de 50 caracteres.',
            'nombre.unique' => 'Este nombre ya está registrado.',
            'nombre.regex' => 'El nombre solo puede contener letras, espacios y los caracteres @ # $ % & !.'
        ];
    }
    public function render()
    {
        return view('livewire.alergia.index');
    }
}
