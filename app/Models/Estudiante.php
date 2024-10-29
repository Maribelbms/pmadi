<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estudiante extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'estudiantes';
    protected $primaryKey = 'id_estudiante';

    protected $fillable = [
        // Datos del estudiante
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'ci',
        'expedido',
        'sexo',
        'rude',
        'nivel',
        'curso',
        'paralelo',
        'porcentaje_asistencia',
        'habilitado',
        'tutor_id',
        'gestion_id',
        
    ];

    protected $dates = ['deleted_at'];
    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'tutor_id');
    }
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'estudiante_id');
    }
    public function gestion()
    {
        return $this->belongsTo(Gestion::class, 'gestion_id');
    }

    public function reviciones()
    {
        return $this->hasMany(Revicion::class, 'estudiante_id');
    }
}
