<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MntClinico extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "mnt_clinico";
    protected $fillable = ["fecha_consulta", "expediente_id", "estado_id", "total_pagar"];


    public function Expediente()
    {
        return $this->belongsTo(MntExpediente::class, 'expediente_id')->withTrashed();
    }
    public function estadoClinico()
    {
        return $this->belongsTo(CtlEstado::class, 'estado_id');
    }
    public function examenes()
    {
        return $this->hasMany(MntExamen::class, 'clinico_id');
    }
}
