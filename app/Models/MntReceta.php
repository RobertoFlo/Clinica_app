<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MntReceta extends Model
{
    //
    protected $table = "mnt_receta";
    protected $fillable = ["consulta_id", "fecha_receta", "indicaciones"];
    protected $hidden = [
        "created_at", "updated_at"
    ];

}
