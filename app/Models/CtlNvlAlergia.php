<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CtlNvlAlergia extends Model
{
    /** @use HasFactory<\Database\Factories\CtlNvlAlergiaFactory> */
    use HasFactory,SoftDeletes;
    protected $table = "ctl_nvl_alergia";
    protected $fillable = ['nombre'];
    protected $hidden = ['created_at', 'updated_at'];

}
