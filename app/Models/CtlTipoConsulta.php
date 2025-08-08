<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CtlTipoConsulta extends Model
{
    /** @use HasFactory<\Database\Factories\CtlTipoConsultaFactory> */
    use HasFactory;
    protected $table = "ctl_tipo_consulta";
    protected $fillable = ['nombre', 'precio'];
}

