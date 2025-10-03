<?php

namespace App\Livewire\Clinica;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use App\Models\MntClinico;
use App\Models\MntExpediente;
use App\Models\CtlTipoExamen;
use App\Models\CtlEstado;
use App\Models\MntExamen;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Exception;

#[Title('Examen')]
class Examenes extends Component
{

    use WithFileUploads;

    public $errorMessage = '';
    public $id = null;
    public $modo_edicion = false;
    public $search_expediente = [];
    public $persona_registo_examen = [];
    public $detallesExamenes = [];  //los examenes que se van a registrar
    public $search = '';
    public $modo_lectura = false;
    public $fileInputDragDrop;

    //tipos de examenes a realizar
    public $tipos_examenes = [];
    public $estados_examenes = [];
    public $select_estado_examen;
    public $select_estado_examen_id;
    public $tipo_examen_id;

    ///tabla al crear el examen
    public $tabla_examenes = [];
    //
    public $showModal = false;
    public $showModalExamen = false;
    public $foto = false;
    public function mount($id = null)
    {
        if ($id) {
            $this->id = $id;
            $this->modo_edicion = session('clinica_examen_modo_edicion');
            $this->modo_lectura = session('clinica_examen_modo_ver');
            session(['clinica_examen_id' => $id]);
        } else {
            $this->modo_edicion = session('clinica_examen_modo_edicion');
            $this->modo_lectura = session('clinica_examen_modo_ver');
            $this->id = session('clinica_examen_id');
        }
    }

    #[On('item_tabla')]
    public function tabla($itemId, $accion)
    {
        $item = MntExamen::find($itemId);
        $seleccion = $accion;
        switch ($seleccion) {
            case 'destroy':
                if ($item) {
                    $item->forceDelete();
                    // Actualizar el total a pagar en mnt_clinico
                    $total = DB::table('mnt_examen')
                        ->join('ctl_tipo_examen', 'mnt_examen.tipo_examen_id', '=', 'ctl_tipo_examen.id')
                        ->where('mnt_examen.clinico_id', $this->persona_registo_examen['id']) //  del registro de mnt_clinico
                        ->sum('ctl_tipo_examen.precio');

                    MntClinico::where('id', $this->persona_registo_examen['id'])->update([
                        'total_pagar' => $total
                    ]);

                    $this->dispatch('notify', [
                        'variant' => 'success',
                        'title' => 'Éxito',
                        'message' => 'El examen ha sido eliminado correctamente.'
                    ]);
                } else {
                    $this->dispatch('notify', [
                        'variant' => 'warning',
                        'title' => 'Atención',
                        'message' => 'error al eliminar el examen, inténtalo de nuevo.'
                    ]);
                }
                break;
            case 'editar':
                if ($this->modo_edicion) {
                    $this->select_estado_examen = MntExamen::with('estado', 'tipoexamen')->find($itemId);
                    $this->select_estado_examen_id = $this->select_estado_examen['estado']['id'];
                    if ($this->select_estado_examen['url_documento'] == null) {
                        $this->foto = true;
                    }

                    $this->showModal = true;
                } else {
                    $this->dispatch('notify', [
                        'variant' => 'info',
                        'title' => 'Editar',
                        'message' => 'Funcionalidad de edición solo esta disponible luego de registro.'
                    ]);
                }
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
    public function editEstadoClinico()
    {
        $this->select_estado_examen_id = $this->persona_registo_examen['estado_id'];
        $this->showModal = true;
    }
    public function closeModal()
    {
        $this->reset('select_estado_examen', 'select_estado_examen_id', 'foto', 'fileInputDragDrop');
        $this->resetErrorBag();
        $this->showModal = false;
    }
    public function closeModalExamen()
    {
        $this->resetErrorBag();
        $this->showModalExamen = false;
        $this->reset('tipo_examen_id');
    }
    public function saveexcepcional()
    {
        $this->validate([
            'tipo_examen_id' => 'required|exists:ctl_tipo_examen,id',
        ], [
            'tipo_examen_id.required' => 'El tipo de examen es obligatorio.',
            'tipo_examen_id.exists' => 'El tipo de examen seleccionado no es válido.',
        ]);
        $existeExamen = MntExamen::where('clinico_id', $this->persona_registo_examen['id'])
            ->where('tipo_examen_id', $this->tipo_examen_id)
            ->first();
        if ($existeExamen) {
            $this->dispatch('notify', [
                'variant' => 'warning',
                'title' => 'Atención',
                'message' => 'El examen ya ha sido agregado previamente.'
            ]);
        } else {
            MntExamen::create([
                'clinico_id' => $this->persona_registo_examen['id'],
                'tipo_examen_id' => $this->tipo_examen_id,
                'estado_id' => 1,
            ]);
            $total = DB::table('mnt_examen')
                ->join('ctl_tipo_examen', 'mnt_examen.tipo_examen_id', '=', 'ctl_tipo_examen.id')
                ->where('mnt_examen.clinico_id', $this->persona_registo_examen['id']) //  del registro de mnt_clinico
                ->sum('ctl_tipo_examen.precio');

            MntClinico::where('id', $this->persona_registo_examen['id'])->update([
                'total_pagar' => $total
            ]);
            $this->dispatch('notify', [
                'variant' => 'success',
                'title' => 'Éxito',
                'message' => 'El examen se ha agregado correctamente.'
            ]);
        }
        // Limpiar los campos después de agregar
        $this->reset(['tipo_examen_id', 'fileInputDragDrop', 'foto']);
        $this->closeModalExamen();
    }
    public function capturarFoto()
    {
        $this->foto = true;
    }
    public function saveestado()
    {
        if ($this->fileInputDragDrop) {
            try {
                $filename = Carbon::now()->format('Ymd_His') . $this->select_estado_examen['id'] . $this->select_estado_examen['clinico_id'] . $this->fileInputDragDrop->getClientOriginalName(); //solo el nombre del archivo

                if ($this->select_estado_examen['url_documento']) {
                    $path = 'examenes/' . $this->select_estado_examen['url_documento'];
                    $disk = Storage::disk('public');
                    if ($disk->exists($path)) {
                        return $disk->delete($path);
                    }
                }

                $this->fileInputDragDrop->storeAs('examenes', $filename, 'public'); //solo el guardado del nombre del archivo

                MntExamen::where('id', $this->select_estado_examen['id'])->update([
                    'estado_id' => $this->select_estado_examen_id,
                    'url_documento' => $filename,
                ]);
            } catch (Exception $e) {

                $this->dispatch('notify', [
                    'variant' => 'danger',
                    'title' => 'Error',
                    'message' => 'Error al subir el archivo. Inténtalo de nuevo.'
                ]);
                return;
            }
        } else {
            $this->validate([
                'select_estado_examen_id' => 'required',
            ], [
                'select_estado_examen_id.required' => 'El estado es obligatorio.',
                'select_estado_examen_id.exists' => 'El estado seleccionado no es válido.',
            ]);
            MntExamen::where('id', $this->select_estado_examen['id'])->update([
                'estado_id' => $this->select_estado_examen_id,
            ]);
        }

        $this->dispatch('notify', [
            'variant' => 'success',
            'title' => 'Éxito',
            'message' => 'El estado del examen ha sido actualizado correctamente.'
        ]);

        $this->closeModal();
    }
    public function goBack()
    {
        return redirect()->to(session('previous_url'));
    }
    public function searchExpediente()
    {
        if ($this->search) {
            $query = MntExpediente::with('paciente')->orderBy('id');
            $query->whereHas('paciente', function ($q) {
                $q->whereRaw("concat(nombre, ' ', apellido) ilike ?", ['%' . $this->search . '%'])
                    ->orWhere('nombre', 'ilike', '%' . $this->search . '%')
                    ->orWhere('apellido', 'ilike', '%' . $this->search . '%');
            });
            $this->search_expediente = $query->get();
        } else {
            $this->search_expediente = [];
        }
    }
    public function examenexcepcional()
    {
        $this->showModalExamen = true;
    }
    public function selectExpediente($id)
    {
        MntClinico::where('id', $this->persona_registo_examen['id'])->update([
            'expediente_id' => $id,
        ]);
        $this->reset('search_expediente', 'search');
    }
    public function agregarExamen()
    {
        $this->validate([
            'tipo_examen_id' => 'required|exists:ctl_tipo_examen,id',
        ], [
            'tipo_examen_id.required' => 'El tipo de examen es obligatorio.',
            'tipo_examen_id.exists' => 'El tipo de examen seleccionado no es válido.',
        ]);
        $existeExamen = MntExamen::where('clinico_id', $this->persona_registo_examen['id'])
            ->where('tipo_examen_id', $this->tipo_examen_id)
            ->first();
        if ($existeExamen) {
            $this->dispatch('notify', [
                'variant' => 'warning',
                'title' => 'Atención',
                'message' => 'El examen ya ha sido agregado previamente.'
            ]);
        } else {
            MntExamen::create([
                'clinico_id' => $this->persona_registo_examen['id'],
                'tipo_examen_id' => $this->tipo_examen_id,
                'estado_id' => 1,
            ]);
            $total = DB::table('mnt_examen')
                ->join('ctl_tipo_examen', 'mnt_examen.tipo_examen_id', '=', 'ctl_tipo_examen.id')
                ->where('mnt_examen.clinico_id', $this->persona_registo_examen['id']) //  del registro de mnt_clinico
                ->sum('ctl_tipo_examen.precio');

            MntClinico::where('id', $this->persona_registo_examen['id'])->update([
                'total_pagar' => $total
            ]);
            $this->dispatch('notify', [
                'variant' => 'success',
                'title' => 'Éxito',
                'message' => 'El examen se ha agregado correctamente.'
            ]);
        }
        // Limpiar los campos después de agregar
        $this->reset(['tipo_examen_id']);
    }
    public function finalizarExamenes()
    {

        MntClinico::where('id', $this->persona_registo_examen['id'])->update([
            'deleted_at' => null,
        ]);
        return redirect()->to(session('previous_url'));
    }
    public function render()
    {
        $this->tipos_examenes = CtlTipoExamen::all();
        $this->estados_examenes = CtlEstado::all();
        $tabla = MntExamen::with('estado', 'tipoexamen')->where('clinico_id', $this->id)->orderBy('id', 'asc')->get();
        $this->tabla_examenes  = collect($tabla)->map->toArray()->all();
        $this->persona_registo_examen = MntClinico::withTrashed()->with('estadoClinico', 'Expediente.paciente', 'examenes')->find($this->id);
        return view('livewire.clinica.examenes', [
            'persona_registo_examen' => $this->persona_registo_examen,
            'modo_edicion' => $this->modo_edicion,
            'search_expediente' => $this->search_expediente,
            'estados_examenes' => $this->estados_examenes,
            'tipos_examenes' => $this->tipos_examenes,
            'tabla_examenes' => $this->tabla_examenes,
        ]);
    }
}
