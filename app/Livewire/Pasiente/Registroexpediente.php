<?php

namespace App\Livewire\Pasiente;

use App\Models\CtlAlergia;
use Livewire\Component;
use App\Models\Paciente;
use App\Models\MntExpediente;
use App\Models\MntPacienteAlergia;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class Registroexpediente extends Component
{
    public $id;
    public $nombre = '';
    public $apellido = '';
    public $telefono = '';
    public $direccion = '';
    public $documento_identidad = '';
    public $fecha_nacimiento = '';
    public $sexo = '';
    public $numero_expediente = '';
    public $fecha_creacion = '';
    //gestion de alergias
    public $alergias = [];
    public $alergia_selected = [];
    public $alergias_selected = [];

    protected function rules()
    {
        return [
            'nombre' => 'required|string|min:3|max:150',
            'apellido' => 'required|string|min:3|max:150',
            'telefono' => 'nullable|digits:8',
            'direccion' => 'required|string|min:5|max:250',
            'documento_identidad' => 'nullable|string|max:10',
            'fecha_nacimiento' => 'nullable|date',
            'sexo' => ['required', Rule::in(['M', 'F'])],
            'fecha_creacion' => 'required|date',
        ];
    }

    protected function messages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
            'nombre.max' => 'El nombre no puede tener más de 150 caracteres.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.min' => 'El apellido debe tener al menos 3 caracteres.',
            'apellido.max' => 'El apellido no puede tener más de 150 caracteres.',
            'telefono.digits' => 'El teléfono debe tener 8 dígitos.',
            'direccion.required' => 'La dirección es requerida.',
            'direccion.min' => 'La dirección debe tener al menos 5 caracteres.',
            'direccion.max' => 'La dirección no puede tener más de 250 caracteres.',
            'documento_identidad.max' => 'El documento no puede tener más de 10 caracteres.',
            'fecha_nacimiento.date' => 'La fecha de nacimiento no es válida.',
            'sexo.required' => 'El sexo es obligatorio.',
            'sexo.in' => 'El sexo debe ser M o F.',
            'fecha_creacion.required' => 'La fecha de creación es obligatoria.',
            'fecha_creacion.date' => 'La fecha de creación no es válida.',
        ];
    }

    #[On('item_tabla')]
    public function seleccion_tabla($itemId)
    {
        if ($itemId) {
            $this->alergias_selected = collect($this->alergias_selected)
                ->reject(function ($item) use ($itemId) {
                    // Si es modelo Eloquent
                    if (is_object($item)) {
                        return $item->id == $itemId;
                    }
                    // Si es array
                    return isset($item['id']) && $item['id'] == $itemId;
                })
                ->values()
                ->all();
            $this->resetErrorBag();
        } else {
            $this->dispatch('notify', [
                'variant' => 'danger',
                'title' => 'Error',
                'message' => 'No se encontró el ítem seleccionado. Inténtalo de nuevo.'
            ]);
        }
    }

    public function saveRegistro()
    {
        $this->validate();
        $this->dispatch('show-loader');
        try {
            $paciente = Paciente::create([
                'nombre' => $this->nombre,
                'apellido' => $this->apellido,
                'telefono' => $this->telefono,
                'direccion' => $this->direccion,
                'documento_identidad' => $this->documento_identidad,
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'sexo' => $this->sexo,
            ]);
            // 2. Generar el número de expediente
            $iniciales = strtoupper(substr($this->nombre, 0, 1) . substr($this->apellido, 0, 1));
            $anio = date('Y', strtotime($this->fecha_creacion));
            $numeroExpediente =  $paciente->id . $iniciales . '-' . $anio;
            MntExpediente::create([
                'paciente_id' => $paciente->id,
                'fecha_creacion' => $this->fecha_creacion,
                'numero_expediente' => $numeroExpediente,
            ]);
            if (!empty($this->alergias_selected)) {
                foreach ($this->alergias_selected as $item) {
                    MntPacienteAlergia::create([
                        'paciente_id' => $paciente->id,
                        'alergia_id' => $item->id,
                    ]);
                }
            }
            $this->reset(['nombre', 'apellido', 'telefono', 'direccion', 'documento_identidad', 'fecha_nacimiento', 'sexo', 'numero_expediente', 'fecha_creacion']);
            $this->dispatch('notify', [
                'variant' => 'success',
                'title' => '¡Éxito!',
                'message' => 'Expediente y paciente registrados correctamente.'
            ]);
            $this->dispatch('redirect-expediente');
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'variant' => 'danger',
                'title' => 'Error',
                'message' => 'Hubo un error al registrar el usuario. Inténtalo de nuevo.'
            ]);
        }
    }
    public function agregarAlergia()
    {
        $this->validate(
            [
                'alergia_selected' => 'required',
            ],
            [
                'alergia_selected.required' => 'Debe seleccionar una alergia.',
            ]
        );
        try {
            $alergia = collect($this->alergias)->firstWhere('id', $this->alergia_selected);
            if ($alergia && !collect($this->alergias_selected)->contains('id', $alergia->id)) {
                $this->alergias_selected[] = $alergia;
            }
            $this->reset('alergia_selected');
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'variant' => 'danger',
                'title' => 'Error',
                'message' => 'Hubo un error al agregar la alergia. Inténtalo de nuevo.'
            ]);
        }
    }

    public function mount($id = null)
    {
        $this->id = $id;
        if ($this->id) {
            $expediente = MntExpediente::withTrashed()->with('paciente')->find($this->id);
            $alergiasPaciente = DB::table('mnt_persona_alergia as pa')
                ->join('ctl_alergia as a', 'pa.alergia_id', '=', 'a.id')
                ->select('pa.id as paciente_alergia_id', 'pa.paciente_id', 'a.id as alergia_id', 'a.nombre as alergia_nombre', 'pa.deleted_at')
                ->where('pa.paciente_id', $expediente->paciente->id)
                ->get()
            ;
            if ($expediente && $expediente->paciente) {
                $this->nombre = $expediente->paciente->nombre;
                $this->apellido = $expediente->paciente->apellido;
                $this->telefono = $expediente->paciente->telefono;
                $this->direccion = $expediente->paciente->direccion;
                $this->documento_identidad = $expediente->paciente->documento_identidad;
                $this->fecha_nacimiento = $expediente->paciente->fecha_nacimiento;
                $this->sexo = $expediente->paciente->sexo;
                $this->numero_expediente = $expediente->numero_expediente;
                $this->fecha_creacion = $expediente->fecha_creacion;
                // dd($alergiasPaciente);
                $this->alergias_selected =collect($alergiasPaciente->map(function($item) {
                    return (object)[
                        'id' => $item->alergia_id,
                        'nombre' => $item->alergia_nombre,
                        'deleted_at' => $item->deleted_at,
                    ];
                }));
            }
        }
    }
    public function render()
    {
        //     if($this->id){
        //         $expediente = MntExpediente::withTrashed()->with('paciente')->find($this->id);
        //        // dd($expediente->paciente->id);

        //         $alergiasPaciente =MntPacienteAlergia::withTrashed()->with('alergia')->where('paciente_id',$expediente->paciente->id)->get();
        //         //dd($alergiasPaciente);
        //         if($expediente && $alergiasPaciente){
        //             $this->nombre = $expediente->paciente->nombre;
        //             $this->apellido = $expediente->paciente->apellido;
        //             $this->telefono = $expediente->paciente->telefono;
        //             $this->direccion = $expediente->paciente->direccion;
        //             $this->documento_identidad = $expediente->paciente->documento_identidad;
        //             $this->fecha_nacimiento = $expediente->paciente->fecha_nacimiento;
        //             $this->sexo = $expediente->paciente->sexo;
        //             $this->numero_expediente = $expediente->numero_expediente;
        //             $this->fecha_creacion = $expediente->fecha_creacion;
        //             $this->alergias_selected = $alergiasPaciente;
        //             //dd($alergiasPaciente);
        //         }
        //     }
        $this->alergias = CtlAlergia::withTrashed()->orderBy('id')->get();
        return view('livewire.pasiente.registroexpediente', [
            'alergias' => $this->alergias,
        ]);
    }
}
