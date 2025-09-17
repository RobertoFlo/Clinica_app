<?php

namespace App\Livewire\Cita;

use Livewire\Component;
use App\Models\Paciente;
use App\Models\Cita;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Carbon\Carbon;
use Livewire\Attributes\Validate;

class Citas extends Component
{
    use WithPagination;
    public $paciente = '';
    public $pacientes = [];
    //formulario
    #[Validate('required|date_format:H:i')]
    public $hora_cita = '';
    #[Validate('required|string|max:100|min:5')]
    public $nombre_paciente = '';
    #[Validate('required|date|after_or_equal:today')]
    public $fecha_cita = '';
    public $seleccionado = [];
    public $modo_edicion = false;
    public $modal_text = '';
    public $showModal = false;
    public $modalForce = false;
    public $search_cita;
    public $fecha_cita_search = '';



    #[On('item_tabla')]
    public function citasgestion($itemId, $accion)
    {
        switch ($accion) {
            case 'eliminar':
                $this->showModal = true;
                $this->seleccionado = Cita::withTrashed()->find($itemId);
                if ($this->seleccionado['deleted_at']) {
                    $this->modal_text = 'Pasara como aun no finalizada(Activa). ¿Desea continuar?';
                } else {
                    $this->modal_text = 'Se dara como finalizada la cita. ¿Desea continuar?';
                }
                break;
            case 'editar':
                $this->modo_edicion = true;
                $this->seleccionado = Cita::withTrashed()->find($itemId);
                $this->fecha_cita = $this->seleccionado['fecha_cita'];
                $this->hora_cita = Carbon::parse($this->seleccionado['hora_cita'])->format('H:i');
                $this->nombre_paciente = $this->seleccionado['nombre_paciente'];
                break;
            case 'destroy':
                // Cita::where('id', $itemId)->forceDelete();
                break;
            default:
                $this->dispatch('notify', [
                    'variant' => 'danger',
                    'title' => 'Error',
                    'message' => 'Acción no reconocida.'
                ]);
                return;
        }
    }
    public function closeModal()
    {
        $this->showModal = false;
        $this->reset('seleccionado');
    }
    public function savemodalcita()
    {
        $this->showModal = false;
        try {
            if ($this->seleccionado['deleted_at']) {

                $item = Cita::withTrashed()->find($this->seleccionado['id']);
                $item->restore();
            } else {
                $item = Cita::withTrashed()->find($this->seleccionado['id']);
                $item->delete();
            }
            $this->dispatch('notify', [
                'variant' => 'success',
                'title' => '¡Éxito!',
                'message' => 'Cita reactivada correctamente.'
            ]);
            $this->reset('seleccionado');
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'variant' => 'danger',
                'title' => 'Error',
                'message' => 'Hubo un error al procesar la solicitud. Inténtalo de nuevo.'
            ]);
        }
    }
    public function buscarPaciente()
    {
        $busqueda = trim($this->paciente);
        $this->pacientes = Paciente::whereRaw(
            "CONCAT(nombre, ' ', apellido) ILIKE ? OR documento_identidad ILIKE ?",
            ["%{$busqueda}%", "%{$busqueda}%"]
        )->get();
    }
    public function LimpiarPaciente()
    {
        $this->paciente = '';
        $this->pacientes = [];
    }
    public function selectPaciente($id)
    {
        $p = Paciente::withTrashed()->find($id);
        if ($p) {
            $this->seleccionado = $p;
            $this->nombre_paciente = $p->nombre;
            $this->LimpiarPaciente();
        } else {
            $this->dispatch('notify', [
                'variant' => 'danger',
                'title' => 'Error',
                'message' => 'Error al seleccionar usuario. Inténtalo de nuevo.'
            ]);
        }
    }
    
    public function agendarCita()
    {
        $this->validate();
        try {
            $citaExistente = DB::table('mnt_cita')
                ->where('fecha_cita', $this->fecha_cita)
                ->where('hora_cita', $this->hora_cita)
                ->exists();
            if ($citaExistente == false) {
                if ($this->modo_edicion) {

                    DB::transaction(function () {
                        DB::table('mnt_cita')->where('id', $this->seleccionado['id'])->update([
                            'fecha_cita' => $this->fecha_cita,
                            'hora_cita' => $this->hora_cita,
                            'nombre_paciente' => $this->nombre_paciente,
                            'updated_at' => now(),
                        ]);
                    });
                    $this->dispatch('notify', [
                        'variant' => 'success',
                        'title' => '¡Éxito!',
                        'message' => 'Cita actualizada correctamente.'
                    ]);
                } else {
                    DB::transaction(function () {
                        DB::table('mnt_cita')->insert([
                            'paciente_id' => $this->seleccionado['id'] ?? null,
                            'fecha_cita' => $this->fecha_cita,
                            'hora_cita' => $this->hora_cita,
                            'nombre_paciente' => $this->nombre_paciente,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    });
                    $this->dispatch('notify', [
                        'variant' => 'success',
                        'title' => '¡Éxito!',
                        'message' => 'Cita agendada correctamente.'
                    ]);
                }
                $this->dispatch('show-loader');
                $this->reset('hora_cita', 'nombre_paciente', 'fecha_cita', 'seleccionado', 'modo_edicion');
            } else {
                $this->dispatch('notify', [
                    'variant' => 'danger',
                    'title' => 'Error',
                    'message' => 'Ya existe una cita agendada para esta fecha y hora.'
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'variant' => 'danger',
                'title' => 'Error',
                'message' => 'Hubo un error al agendar la cita. Inténtalo de nuevo.'.$e,
            ]);
        }
    }
    public function buscarCitas()
    {
        $this->dispatch('show-loader');
        $this->validate([
            'fecha_cita_search' => 'nullable|date:regex:/^[\p{L}]+$/u',
            'search_cita' => 'nullable|string|max:100',
        ], [
            'search_cita.string' => 'La búsqueda debe ser un texto.',
            'search_cita.max' => 'La búsqueda no puede tener más de 100 caracteres.',
            'fecha_cita_search.date' => 'La fecha de la cita debe ser una fecha válida.',
        ]);
    }
    public function Paciente(){
        session(['previous_url' => url()->previous()]);
        $this->redirect('registro-expediente');
    }
    public function limpiarBusqueda()
    {
        $this->dispatch('show-loader');
        $this->reset('search_cita', 'fecha_cita_search');
    }
    public function LimpiarFormulario()
    {
        $this->resetErrorBag();
        $this->reset('hora_cita', 'nombre_paciente', 'fecha_cita', 'seleccionado', 'modo_edicion');
    }
    public function messages(){
        return [
            'fecha_cita.required' => 'La fecha de la cita es obligatoria.',
            'fecha_cita.date' => 'La fecha de la cita debe ser una fecha válida.',
            'fecha_cita.after_or_equal' => 'La fecha de la cita no puede ser anterior a hoy.',
            'hora_cita.required' => 'La hora de la cita es obligatoria.',
            'hora_cita.date_format' => 'La hora de la cita debe tener el formato HH:MM.',
            'nombre_paciente.string' => 'El nombre del paciente debe ser una cadena de texto.',
            'nombre_paciente.max' => 'El nombre del paciente no puede tener más de 100 caracteres.',
            'nombre_paciente.min' => 'El nombre del paciente debe tener al menos 5 caracteres.',
            'nombre_paciente.required' => 'Debe seleccionar un paciente de la lista o crear su registro.',
        ] ;
    }
    public function render()
    {
        $query = Cita::withTrashed()->orderBy('fecha_cita', 'desc')->orderBy('hora_cita', 'desc');

        if ($this->search_cita) {
            $query->where('nombre_paciente', 'like', '%' . $this->search_cita . '%');
        }
        if ($this->fecha_cita_search) {
            $query->where('fecha_cita', $this->fecha_cita_search);
        }

        $paginator = $query->paginate(6);
        return view('livewire.cita.citas', [
            'pacientes' => $this->pacientes,
            'paginator' => $paginator,
            'datos' => $paginator->items(),
        ]);
    }
}
