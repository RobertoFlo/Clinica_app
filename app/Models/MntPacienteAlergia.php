<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;   

class MntPacienteAlergia extends Model
{
    use SoftDeletes;

    protected $table = 'mnt_persona_alergia';

    protected $fillable = [
        'paciente_id',
        'alergia_id',
        // 'nvl_alergia_id',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function alergia()
    {
        return $this->belongsTo(CtlAlergia::class, 'alergia_id');
    }

}
