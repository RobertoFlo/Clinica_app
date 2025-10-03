<?php

namespace App\Livewire\Consulta;

use App\Models\Medicos;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Consulta;
use App\Models\CtlTipoConsulta;
use App\Models\MntConsulta;
use App\Models\Paciente;
use App\Models\MntExpediente;
use App\Models\User;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('Mantenimiento de Consultas')]
class Mantenimiento extends Component
{
    use WithPagination;
    ///modo creacion 

    public $expedientes = [];
    public $search_expediente = '';
    public $paciente_selected;
    public $tipo_consulta_selected = null;
    public $medico_selected = null;
    public $tipo_consulta = [];
    public $medicos = [];
    ///modo edicion
    public $modo_edicion = false;


    public function mount()
    {
        $this->modo_edicion = session()->get('modo_edicion');
        if ($this->modo_edicion) {
            $id = session()->get('consulta');
            $this->paciente_selected = MntConsulta::with('expediente.paciente','medico','clinico.examenes','cita', 'estado', 'receta')->where('id', $id)->first();
        } else {
            $usuario = Auth::user();
            $medico = $usuario->medico;
            if ($medico) {
                $this->medico_selected = $medico->id;
            }

            $id = session()->get('expediente');
            $this->paciente_selected = Paciente::with('expediente')->where('id', $id)->first();
        }
    }
    public function buscarPaciente()
    {
        $busqueda = trim($this->search_expediente);
        $this->expedientes = Paciente::with('expediente')->whereRaw(
            "CONCAT(nombre, ' ', apellido) ILIKE ? OR documento_identidad ILIKE ?",
            ["%{$busqueda}%", "%{$busqueda}%"]
        )->get();
    }
    public function limpiarPaciente()
    {
        session()->forget('expediente');
        $this->reset('search_expediente', 'expedientes');
    }
    public function cambiarPaciente()
    {
        $this->reset('paciente_selected');
        $this->limpiarPaciente();
    }
    public function seleccionarPaciente($expediente)
    {
        session()->put(['expediente' => $expediente['expediente']['id']]);
        $this->paciente_selected = $expediente;
        $this->limpiarPaciente();
    }
    public function crearConsulta()
    {
        $this->validate(['tipo_consulta_selected' => 'required|exists:ctl_tipo_consultas,id', 'paciente_selected' => 'required', 'medico_selected' => 'required'],        [
            'tipo_consulta_selected.required' => 'El tipo de consulta es obligatorio.',
            'tipo_consulta_selected.exists' => 'El tipo de consulta seleccionado no es válido.',
            'paciente_selected.required' => 'Debe seleccionar un paciente para crear la consulta.',
            'medico_selected.required' => 'Debe seleccionar un médico para crear la consulta.',
        ]);
        try {
            $consulta = MntConsulta::create([
                'expediente_id' => $this->paciente_selected->expediente['id'],
                'medico_id' => $this->medico_selected,
                'tipoconsulta_id' => $this->tipo_consulta_selected,
                'clinico_id' => null,
                'estado_id' => 1, // Estado Pendiente
                'fecha_consulta' => now(),
                'descripcion_consulta' => null,
            ]);
            session()->put('modo_edicion', true);
            session()->put('Consulta', $consulta->id);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'variant' => 'danger',
                'title' => 'Error',
                'message' => 'Hubo un error al guardar la alergia. Inténtalo de nuevo.'
            ]);
        }
    }
    public function regresar()
    {
        session()->forget('modo_edicion');
        session()->forget('consulta');
        session()->forget('expediente');
        $this->reset('paciente_selected', 'tipo_consulta_selected', 'medico_selected','search_expediente','expedientes','tipo_consulta','medicos');
        $ruta =  session()->get('previous_url');
        return redirect()->to($ruta);
    }

    public function render()
    {
        $this->tipo_consulta = CtlTipoConsulta::all();
        $this->medicos = Medicos::all();
        return view('livewire.consulta.mantenimiento', ['expedientes' => $this->expedientes, 'paciente_selected' => $this->paciente_selected, 'tipo_consulta' => $this->tipo_consulta, 'medicos' => $this->medicos]);
    }
}
