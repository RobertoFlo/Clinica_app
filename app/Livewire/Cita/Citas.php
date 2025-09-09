<?php

namespace App\Livewire\Cita;

use Livewire\Component;
use App\Models\Paciente;
use App\Models\Cita;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class Citas extends Component
{
    use WithPagination;
    public $paciente = '';
    public $pacientes = [];
    //formulario
    public $hora_cita = '';
    public $nombre_paciente = '';
    public $fecha_cita = '';
    public $seleccionado = '';
    public $modeedicion = false;
    public $modalText = '';
    public $showModal = false;
    public $modalForce = false;



    #[On('item_tabla')]
    public function citasgestion($itemId, $accion)
    {
        switch ($accion) {
            case 'eliminar':
                $this->showModal = true;
                $this->seleccionado = Cita::withTrashed()->find($itemId);
            9
                if ($this->seleccionado['deleted_at']) {
                    $this->modalText = 'Pasara como aun no finalizada(Activa). ¿Desea continuar?';
                } else {
                    $this->modalText = 'Se dara como finalizada la cita. ¿Desea continuar?';
                }
                break;
            case 'editar':
                $this->modeedicion = true;
                $this->seleccionado = Cita::withTrashed()->find($itemId);
                $this->fecha_cita = $this->seleccionado['fecha_cita'];
                $this->hora_cita = $this->seleccionado['hora_cita'];
                $this->nombre_paciente = $this->seleccionado['nombre_paciente'];
                break;
            case 'destroy':
                // Cita::where('id', $itemId)->forceDelete();
                break;
            default:
                // Acción no reconocida
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
            if ($this->seleccionado['deleted_at'] ) {
                // Finalizar la cita (soft delete)
               $item = Cita::withTrashed()->find( $this->seleccionado['id']);
               $item->delete();
                // dd($item);

            } else {
                // Reactivar la cita
                $item = Cita::withTrashed()->find( $this->seleccionado['id']);
                // dd($item);
                $item->restore();
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
        $this->validate([
            'fecha_cita' => 'required|date|after_or_equal:today',
            'hora_cita' => 'required|date_format:H:i',
            'nombre_paciente' => 'required|string|max:100,min:5',
        ], [
            'fecha_cita.required' => 'La fecha de la cita es obligatoria.',
            'fecha_cita.date' => 'La fecha de la cita debe ser una fecha válida.',
            'fecha_cita.after_or_equal' => 'La fecha de la cita no puede ser anterior a hoy.',
            'hora_cita.required' => 'La hora de la cita es obligatoria.',
            'hora_cita.date_format' => 'La hora de la cita debe tener el formato HH:MM.',
            'nombre_paciente.required' => 'El nombre del paciente es obligatorio.',
            'nombre_paciente.string' => 'El nombre del paciente debe ser una cadena de texto.',
            'nombre_paciente.max' => 'El nombre del paciente no puede tener más de 100 caracteres.',
            'nombre_paciente.min' => 'El nombre del paciente debe tener al menos 5 caracteres.',

        ]);
        try {
            $citaExistente = DB::table('mnt_cita')
                ->where('fecha_cita', $this->fecha_cita)
                ->where('hora_cita', $this->hora_cita)
                ->exists();
            if ($citaExistente) {
                if ($this->modeedicion) {
                    DB::transaction(function () {
                        DB::table('mnt_cita')->where('id', $this->seleccionado['id'])->update([
                            'paciente_id' => $this->seleccionado['id'],
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
                            'paciente_id' => $this->seleccionado['id'],
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

                $this->reset('hora_cita', 'nombre_paciente', 'fecha_cita', 'seleccionado');
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
                'message' => 'Hubo un error al agendar la cita. Inténtalo de nuevo.'
            ]);
        }
    }
    public function render()
    {
        $paginator = Cita::withTrashed()->orderBy('id')->paginate(10);
        return view('livewire.cita.citas', [
            'pacientes' => $this->pacientes,
            'paginator' => $paginator,
            'datos' => $paginator->items(),
        ]);
    }
}
