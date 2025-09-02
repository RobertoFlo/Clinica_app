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
    // public $datos;//Datos de la tabla
    public $item = []; //Ítem seleccionado de la tabla 
    public $seleccion = null; //Acción seleccionada (eliminar, editar, agregar)
    public $showModal = false; //Controla modal de confirmación Desactivar/Activar 
    public $showAlergia = false; //Controla modal de agregar/editar alergia
    public $modalText;  //Texto dinámico para el modal de confirmación 
    public $id_alergia; //identificador de la alergia
    #[Validate('required|string|min:4|max:50|regex:/^[\p{L} @#$%&!()]+$/u')]
    public $nombre = ''; //Nombre de la alergia
    public $categorias =[];
    #[Validate('required')]
    public $categoria_seleccionada;
    public $perPage = 5;// registros por página


    #[On('item_tabla')]
    public function seleccion_tabla($itemId, $accion)
    {
        $this->item = CtlAlergia::with(['categoria'])->withTrashed()->find($itemId);
        if ($this->item) {
        $this->seleccion = $accion;
        $this->modalText = $this->item['deleted_at'] ? "restaurar" : "eliminar";
        $this->aceptarModal();
        }else{
            $this->dispatch('notify', [
                'variant' => 'danger',
                'title' => 'Error',
                'message' => 'No se encontró el ítem seleccionado. Inténtalo de nuevo.'
            ]);
        }
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
        $this->showAlergia = true;
    }
    public function modalAlergiaClose()
    {
        $this->showAlergia = false;
        $this->reset('nombre','categoria_seleccionada','categorias');
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
                $alergia->categoria_id = $this->categoria_seleccionada;
                $alergia->save();
                $this->dispatch('notify', [
                    'variant' => 'success',
                    'title' => '¡Éxito!',
                    'message' => 'Alergia editada correctamente.'
                ]);
                $this->reset('id_alergia','nombre');
                $this->showAlergia = false;
            } else {
                CtlAlergia::create([
                    'nombre' => $this->nombre,
                    'categoria_id' => $this->categoria_seleccionada
                ]);
                $this->dispatch('notify', [
                    'variant' => 'success',
                    'title' => '¡Éxito!',
                    'message' => 'Alergia agregada correctamente.'
                ]);
                $this->reset('id_alergia','nombre');
                $this->showAlergia = false;
            }
        } catch (\Exception $e) {
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
                $this->editar();
                break;
        }
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
    }
    public function editar()
    {
        $this->nombre = $this->item['nombre'];
        $this->categoria_seleccionada = $this->item['categoria_id'];
        $this->id_alergia = $this->item['id'];
        $this->modalAlergia();
    }
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre de la alergia es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
            'nombre.max' => 'El nombre no puede tener más de 50 caracteres.',
            'nombre.unique' => 'Este nombre ya está registrado.',
            'nombre.regex' => 'El nombre solo puede contener letras, espacios y los caracteres @ # $ % & !.',
            'categoria_seleccionada.required' => 'La categoria de la alergia es obligatorio.',

        ];
    }
    public function render()
    {
        $paginator = CtlAlergia::with(['categoria'])->withTrashed()->orderBy('id')->paginate($this->perPage);
        return view('livewire.alergia.index', [
            'paginator' => $paginator,
            'datos' => $paginator->items(),
        ]);
    }
}
