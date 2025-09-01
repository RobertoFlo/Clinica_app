<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CategoriaAlergia;


class CtlAlergia extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "ctl_alergia";
    protected $fillable = ['nombre', 'categoria_id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function categoria()
    {
        return $this->belongsTo(CategoriaAlergia::class, 'categoria_id');
    }
}
