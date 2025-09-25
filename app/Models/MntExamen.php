<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MntExamen extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'mnt_examen';
    protected $fillable = [
        'clinico_id',
        'tipo_examen_id',
        'estado_id',
        'observacion'
    ];

    public function clinico()
    {
        return $this->belongsTo(MntClinico::class, 'clinico_id');
    }

    public function tipoExamen()
    {
        return $this->belongsTo(CtlTipoExamen::class, 'tipo_examen_id');
    }

    public function estado()
    {
        return $this->belongsTo(CtlEstado::class, 'estado_id');
    }
    
}
