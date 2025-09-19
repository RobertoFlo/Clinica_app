<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medicos extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $table = "mnt_medicos";
    protected $fillable = [
        'nombre',
        'apellido',
        'especialidad',
    ];
    public function citas()
    {
        return $this->hasMany(Cita::class, 'medico_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
    
}
