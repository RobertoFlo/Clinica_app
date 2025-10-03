<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CtlTipoExamen extends Model
{
    /** @use HasFactory<\Database\Factories\CtlTipoExamenFactory> */
    use HasFactory,SoftDeletes;
    protected $table = "ctl_tipo_examen";
    protected $fillable = ['nombre', 'precio'];
    protected $hidden = ['created_at', 'updated_at'];

    public function examenes()
    {
        return $this->hasMany(MntExamen::class, 'tipo_examen_id');
    }

}
