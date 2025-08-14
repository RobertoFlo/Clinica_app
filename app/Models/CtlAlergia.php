<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CtlAlergia extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "ctl_alergia";
    protected $fillable = ['nombre'];
    protected $hidden = ['created_at', 'updated_at'];

}
