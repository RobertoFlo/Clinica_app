<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
class MntExamen extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'mnt_examen';
    protected $fillable = [
        'clinico_id',
        'tipo_examen_id',
        'estado_id',
        'url_documento',
        'observacion'
    ];

    public function clinico()
    {
        return $this->belongsTo(MntClinico::class, 'clinico_id');
    }

    public function tipoexamen()
    {
        return $this->belongsTo(CtlTipoExamen::class, 'tipo_examen_id');
    }

    public function estado()
    {
        return $this->belongsTo(CtlEstado::class, 'estado_id');
    }
    protected function urlDocumento(): Attribute
    {
       return Attribute::make(
            get: function (?string $value) {
                if (!$value) {
                    return null;
                }
                $relative = 'examenes/' . $value;
                return Storage::disk('public')->exists($relative)
                    ? asset('storage/' . $relative)
                    : null;
            },
        );
    }
    
}
