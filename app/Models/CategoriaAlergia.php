<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaAlergia extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "ctl_categoria_alergia";
    protected $fillable = ['nombre'];
    protected $hidden = ['created_at', 'updated_at'];

    public function alergias()
{
    return $this->hasMany(CtlAlergia::class, 'categoria_id');
}
}
