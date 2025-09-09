<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Paciente extends Model
{
    use SoftDeletes;

    protected $table = 'mnt_paciente';

    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'direccion',
        'documento_identidad',
        'fecha_nacimiento',
        'sexo',
    ];

    public function expediente()
    {
        return $this->hasOne(MntExpediente::class, 'paciente_id');
    }

    public function alergias()
    {
        return $this->hasMany(MntPacienteAlergia::class, 'paciente_id');
    }
    public function citas()
    {
        return $this->hasMany(Cita::class, 'paciente_id');
    }
}
