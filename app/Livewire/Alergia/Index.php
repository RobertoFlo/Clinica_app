<?php

namespace App\Livewire\Alergia;

use App\Models\CtlAlergia;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Reactive;

#[Title('Catálogo de Alergias')]
class Index extends Component
{
    public $datos;
    public $item = [];
    public $seleccion = null;
    public $showModal = false;
    public $showAlergia = false;
    public $modalText;
    #[Validate('required|string|min:4|max:25|regex:/^[\p{L}]+$/u')]
    public $nombre = '';
    #[On('item_tabla')]
    public function seleccion_tabla($item, $accion)
    {
        // dd();
        $this->showModal = false;
        $this->item = $item;
        $this->seleccion = $accion;
        $this->modalText=$item['deleted_at']?"restaurar":"eliminar";
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
    public function modalAlergia()
    {
        $this->showAlergia = true;
    }
    public function modalAlergiaClose()
    {
        $this->showAlergia = false;
    }
    public function saveAlergia()
    {
        $this->validate();
        $this->dispatch('show-loader');
        try {
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
                $this->eliminar($this->item['id']);
                break;
            case 'editar':
                $this->editar($this->item['id']);
                break;
            case 'agregar':
                $this->agregar($this->item['id']);
                break;
        }
        $this->showModal = false;

    }

    private function loadData()
    {
        $this->datos = CtlAlergia::withTrashed()->orderBy('id')->get();
        // $this->dispatch('$refresh');
    }

    public function eliminar($item)
    {
        $alergia = CtlAlergia::withTrashed()->find($item);
        if ($alergia->deleted_at) {
            $alergia->deleted_at = null;
            $alergia->save();
        } else {

            $alergia->delete();
        }
        $this->loadData();
        // $this->reset(['showModal', 'item', 'seleccion','modalText']);
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
       // Usar nextTick para asegurar el render
       