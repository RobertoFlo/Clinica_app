<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class MntExpediente extends Model
{
    use HasFactory,SoftDeletes;


    protected $table = 'mnt_expediente';

    protected $fillable = [
        'paciente_id',
        'fecha_creacion',
        'numero_expediente',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
    public function citas()
    {
        return $this->hasMany(Cita::class, 'expediente_id');
    }
     public function consultas()
    {
        return $this->hasMany(MntConsulta::class, 'expediente_id');
    }
}
