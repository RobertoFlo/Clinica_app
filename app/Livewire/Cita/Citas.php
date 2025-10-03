<?php

namespace App\Livewire\Cita;

use Livewire\Component;
use App\Models\Paciente;
use App\Models\Medicos;
use App\Models\Cita;
use App\Models\CtlTipoConsulta;
use App\Models\CtlTipoExamen;
use App\Models\MntConsulta;
use App\Models\MntExpediente;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Title;

#[Title('Citas Médicas')]
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
    public $medicos_planta = [];
    #[Validate('required|exists:mnt_medicos,id')]
    public $medico_selected = null;
    public $tipos_consulta = [];
    public $tipo_consulta_selected = null;

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
                $this->medico_selected = $this->seleccionado['medico_id'];
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
            $this->dispatch('show-loader');
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
        $p = MntExpediente::with("paciente")->withTrashed()->find($id);
        if ($p) {
            $this->seleccionado = $p->paciente;
            $this->nombre_paciente = $p->paciente->nombre;
            $this->LimpiarPaciente();
        } else {
            $this->dispatch('notify', [
                'variant' => 'danger',
                'title' => 'Error',
                'message' => 'Error al seleccionar usuario. Inténtalo de nuevo.'
            ]);
        }
    }
    public function crearConsulta(){
        $this->validate(
            [
                'tipo_consulta_selected' => 'required|exists:ctl_tipo_consulta,id',
            ],
            [
                'tipo_consulta_selected.required' => 'El tipo de consulta es obligatorio.',
                'tipo_consulta_selected.exists' => 'El tipo de consulta seleccionado no es válido.',
            ]
        );
        $tipo_cita = CtlTipoConsulta::where('id', '=', $this->tipo_consulta_selected)->first();
        MntConsulta::create([
            'cita_id' => $this->seleccionado['id'],
            'expediente_id' => $this->seleccionado['expediente_id'] ?? null,
            'medico_id' => $this->seleccionado['medico_id'] ?? null,
            'fecha_consulta' => now(),
            'tipo_consulta_id' => $tipo_cita['id'] ?? null,
            'descripcion_consulta' => '',
            'estado_id' => 1,
            'subtotal_final' => $tipo_cita['precio'] ?? 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $this->reset('tipo_consulta_selected');
    }
    public function agendarCita()
    {
        $this->validate();
        $this->dispatch('show-loader');
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
                            'medico_id' => $this->medico_selected,
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
                            'expediente_id' => $this->seleccionado['id'] ?? null,
                            'fecha_cita' => $this->fecha_cita,
                            'hora_cita' => $this->hora_cita,
                            'nombre_paciente' => $this->nombre_paciente,
                            'medico_id' => $this->medico_selected,
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
                $this->reset('hora_cita', 'nombre_paciente', 'fecha_cita', 'seleccionado', 'modo_edicion', 'medico_selected','tipo_consulta_selected');
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
                'message' => 'Hubo un error al agendar la cita. Inténtalo de nuevo.',
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
        $this->reset('hora_cita', 'nombre_paciente', 'fecha_cita', 'seleccionado', 'modo_edicion','medico_selected','tipo_consulta_selected');
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
            'medico_selected.required' => 'Debe seleccionar un médico de la lista.',
            'medico_selected.exists' => 'El médico seleccionado no es válido.',
        ];
    }
    public function render()
    {
        $query = Cita::withTrashed()->with('medico')->orderBy('fecha_cita', 'desc')->orderBy('hora_cita', 'desc');
        if ($this->search_cita) {
            $query->where('nombre_paciente', 'like', '%' . $this->search_cita . '%');
        }
        if ($this->fecha_cita_search) {
            $query->where('fecha_cita', $this->fecha_cita_search);
        }

        $this->medicos_planta = Medicos::whereNull('deleted_at')->orderBy('id','asc')->get();
        $this->tipos_consulta = DB::table('ctl_tipo_consulta')->whereNull('deleted_at')->orderBy('id','asc')->get();
        $paginator = $query->paginate(6);
        return view('livewire.cita.citas', [
            'pacientes' => $this->pacientes,
            'paginator' => $paginator,
            'datos' => $paginator->items(),
            'medicos_planta' => $this->medicos_planta,
            'tipos_consulta' => $this->tipos_consulta,
        ]);
    }
}
