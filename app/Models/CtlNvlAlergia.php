<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CtlNvlAlergia extends Model
{
    /** @use HasFactory<\Database\Factories\CtlNvlAlergiaFactory> */
    use HasFactory;
    protected $table = "ctl_nvl_alergia";
    protected $fillable = ['nombre'];
}
