<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CtlAlergia extends Model
{
    use HasFactory;
    protected $table = "ctl_alergia";
    protected $fillable = ['nombre'];
}
