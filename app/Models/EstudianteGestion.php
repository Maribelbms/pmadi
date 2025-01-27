<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstudianteGestion extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'estudiante_gestion';
    protected $primaryKey = 'id_estudiante_gestion';

    protected $fillable = [
        'estudiante_id',
        'unidad_educativa_id',
        'gestion_id',
        'nivel',
        'curso',
        'paralelo',
        'porcentaje_asistencia',
        'habilitado',
    ];
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }
    public function unidadEducativa()
    {
        return $this->belongsTo(UnidadEducativa::class, 'unidad_educativa_id');
    }
    public function gestion()
    {
        return $this->belongsTo(Gestion::class, 'gestion_id');
    }


}
