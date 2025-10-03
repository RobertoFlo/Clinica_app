<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MntConsulta extends Model
{
    use SoftDeletes;

    protected $table = 'mnt_consulta';

    protected $fillable = [
        'expediente_id',
        'cita_id',
        'clinico_id',
        'fecha_consulta',
        'tipo_consulta_id',
        'descripcion_consulta',
        'medico_id',
        'estado_id',
        'subtotal_final',
    ];

    // Relaciones

    public function expediente()
    {
        return $this->belongsTo(MntExpediente::class, 'expediente_id');
    }

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'cita_id');
    }

    public function clinico()
    {
        return $this->belongsTo(MntClinico::class, 'clinico_id');
    }

    public function tipoconsulta()
    {
        return $this->belongsTo(CtlTipoConsulta::class, 'tipo_consulta_id');
    }

    public function medico()
    {
        return $this->belongsTo(Medicos::class, 'medico_id');
    }

    public function estado()
    {
        return $this->belongsTo(CtlEstado::class, 'estado_id');
    }

    public function receta()
    {
        return $this->hasOne(MntReceta::class, 'consulta_id');
    }
}
