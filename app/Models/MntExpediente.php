<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class MntExpediente extends Model
{
    use SoftDeletes;

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
}
