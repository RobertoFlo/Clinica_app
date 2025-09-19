<?php

namespace App\Livewire\Medicos;

use App\Models\Medicos;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

class Doctores extends Component
{
    public $showModal = false;

    #[Validate('required|string|regex:/^[\p{L} ]+$/u|min:3')]
    public $nombre = '';
    #[Validate('required|string|regex:/^[\p{L} ]+$/u|min:3')]
    public $apellido = '';
    #[Validate('required|string|regex:/^[\p{L} ]+$/u|min:3')]
    public $especialidad = '';
    public $seleccionado;

    public function modalMedicoClose()
    {
        $this->showModal = false;
    }
    public function modalMedicoOpen()
    {
        $this->reset(['nombre', 'apellido', 'especialidad', 'seleccionado']);
        $this->showModal = true;
    }
    #[On('item_tabla')]
    public function seleccion_medico($itemId, $accion)
    {
        switch ($accion) {
            case 'editar':
                $this->seleccionado = Medicos::find($itemId);
                $this->nombre = $this->seleccionado->nombre;
                $this->apellido = $this->seleccionado->apellido;
                $this->especialidad = $this->seleccionado->especialidad;
                $this->showModal = true;
                break;
            case 'eliminar':
                $this->dispatch('notify', [
                    'variant' => 'warning',
                    'title' => 'Atención',
                    'message' => 'Funcionalidad de eliminar no implementada aún.'
                ]);
                break;
            default:
                $this->dispatch('notify', [
                    'variant' => 'error',
                    'title' => 'Error',
                    'message' => 'Acción no reconocida.'
                ]);
                break;
        }
    }
    public function saveMedico()
    {
        $this->validate();
        $this->dispatch('show-loader');
        try {
            if ($this->seleccionado) {
                Medicos::where('id', $this->seleccionado->id)->update([
                    'nombre' => $this->nombre,
                    'apellido' => $this->apellido,
                    'especialidad' => $this->especialidad,
                ]);
                $this->dispatch('notify', [
                    'variant' => 'success',
                    'title' => 'Éxito',
                    'message' => 'Médico actualizado correctamente.'
                ]);
            } else {
                Medicos::create([
                    'nombre' => $this->nombre,
                    'apellido' => $this->apellido,
                    'especialidad' => $this->especialidad,
                ]);
                $this->dispatch('notify', [
                    'variant' => 'success',
                    'title' => 'Éxito',
                    'message' => 'Médico agregado correctamente.'
                ]);
            }
            $this->reset(['nombre', 'apellido', 'especialidad', 'seleccionado']);
            $this->showModal = false;
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'variant' => 'error',
                'title' => 'Error',
                'message' => 'Error al agregar el médico: '
            ]);
        }
        $this->showModal = false;
    }
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.string' => 'El apellido debe ser una cadena de texto.',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios.',
            'apellido.min' => 'El apellido debe tener al menos 3 caracteres.',
            'especialidad.required' => 'La especialidad es obligatoria.',
            'especialidad.string' => 'La especialidad debe ser una cadena de texto.',
            'especialidad.regex' => 'La especialidad solo puede contener letras y espacios.',
            'especialidad.min' => 'La especialidad debe tener al menos 3 caracteres.',
        ];
    }
    public function render()
    {
        $query = Medicos::withTrashed()->orderBy('id', 'desc');
        $paginator = $query->paginate(10);
        return view('livewire.medicos.doctores', [
            'medicos' => $paginator->items(),
            'paginator' => $paginator,
        ]);
    }
}
