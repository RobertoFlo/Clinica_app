<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CtlTipoExamen extends Model
{
    /** @use HasFactory<\Database\Factories\CtlTipoExamenFactory> */
    use HasFactory;
    protected $table = "ctl_tipo_examen";
    protected $fillable = ['nombre', 'precio'];
}
