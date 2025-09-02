<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CtlTipoConsulta extends Model
{
    /** @use HasFactory<\Database\Factories\CtlTipoConsultaFactory> */
    use HasFactory,SoftDeletes;
    protected $table = "ctl_tipo_consulta";
    protected $fillable = ['nombre', 'precio'];
    protected $hidden = ['created_at', 'updated_at'];

}

