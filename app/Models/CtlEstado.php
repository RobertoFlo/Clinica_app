<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CtlEstado extends Model
{
    protected $table = "ctl_estado";
    protected $fillable = ["nombre"];

    public function clinicos(){
        return $this->hasMany(MntClinico::class, 'estado_id');
    }
    public function examenes()
    {
        return $this->hasMany(MntExamen::class, 'estado_id');
    }
    public function consulta()
    {
        return $this->hasMany(MntConsulta::class, 'estado_id');
    }
    
}
