<?php

namespace App\Livewire\Consultas;

use App\Models\CtlTipoConsulta;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
class Consulta extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $item = []; //Ítem seleccionado de la tabla 
    public $seleccion = null; //Acción seleccionada (eliminar, editar, agregar)
    public $modalText;  //Texto dinámico para el modal de confirmación 
    public $showConsultas = false; //Controla modal de agregar/editar 
    public $showModal = false; //Controla modal de confirmación Desactivar/Activar 
    #[Validate('required|numeric|min:1.00|max:99999999.99|decimal:0,2')]
    public $precio;
    #[Validate('required|string|min:4|max:50|regex:/^[\p{L} @#$%&!()\/]+$/u')]
    public $nombre;


    #[On('item_tabla')]
    public function seleccion_tabla($itemId, $accion)
    {
        $this->item = CtlTipoConsulta::withTrashed()->find($itemId);
        if ($this->item) {
            $this->seleccion = $accion;
            $this->modalText = $this->item['deleted_at'] ? "restaurar" : "eliminar";
            $this->gestionModal();
        } else {
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
    }  public function modalConsulta()
    {
        $this->showConsultas = true;
    }
    public function modalExamenClose()
    {
        $this->showConsultas = false;
        $this->reset('nombre', 'precio');
        $this->resetErrorBag(); // Limpia los mensajes de error
    }
    public function editarModal()
    {
        $this->nombre = $this->item['nombre'];
        $this->precio = $this->item['precio'];
        $this->modalConsulta();
    }
    public function gestionModal()
    {
        switch ($this->seleccion) {
            case 'eliminar':
                $this->openModal();
                break;
            case 'editar':
                $this->editarModal();
                break;
        }
    }
    public function save()
    {
        $this->validate();
        $this->dispatch('show-loader');
        try {
            if ($this->item['id']) {
                $registro = CtlTipoConsulta::withTrashed()->find($this->item['id']);
                $registro->nombre = $this->nombre;
                $registro->precio = $this->precio;
                $registro->save();
                $this->dispatch('notify', [
                    'variant' => 'success',
                    'title' => '¡Éxito!',
                    'message' => 'Registro editado correctamente.'
                ]);
                $this->reset('precio', 'nombre');
                $this->showConsultas = false;
            } else {
                CtlTipoConsulta::create([
                    'nombre' => $this->nombre,
                    'precio' => $this->precio
                ]);
                $this->dispatch('notify', [
                    'variant' => 'success',
                    'title' => '¡Éxito!',
                    'message' => 'Examen agregado correctamente.'
                ]);
                $this->reset('precio', 'nombre');
                $this->showConsultas = false;
            }
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'variant' => 'danger',
                'title' => 'Error',
                'message' => 'Hubo un error al guardar. Inténtalo de nuevo.'
            ]);
        }
    }
    public function eliminar()
    {
        $this->dispatch('show-loader');
        $registro = CtlTipoConsulta::withTrashed()->find($this->item['id']);
        if ($registro->deleted_at) {
            $registro->deleted_at = null;
            $registro->save();
        } else {
            $registro->delete();
        }
        $this->closeModal();
    }
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos 4 caracteres.',
            'nombre.max' => 'El nombre no puede tener más de 50 caracteres.',
            'nombre.unique' => 'Este nombre ya está registrado.',
            'nombre.regex' => 'El nombre solo puede contener letras, espacios y los caracteres @ # $ % & !.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio mínimo debe ser de 0.01.',
            'precio.max' => 'El precio máximo permitido es de 99,999,999.99.',
            'precio.decimal' => 'El precio solo puede tener un máximo de 2 decimales.',
        ];
    }
    
    public function render()
    {
        $paginator = CtlTipoConsulta::withTrashed()->orderBy('id')->paginate($this->perPage);
        return view('livewire.consultas.consulta',[
            'paginator'=> $paginator,
            'datos' => $paginator->items(),
        ]);
    }
}
