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
        
    ];

    protected $dates = ['deleted_at'];
    public function tutores()
{
    return $this->belongsToMany(Tutor::class, 'estudiante_tutor', 'estudiante_id', 'tutor_id')
                ->withPivot('gestion_id', 'activo')
                ->withTimestamps();
}
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'estudiante_id');
    }
    public function tutorActivo()
    {
        return $this->hasOne(EstudianteTutor::class, 'estudiante_id')->where('activo', true)->with('tutor');
    }

    public function reviciones()
    {
        return $this->hasMany(Revicion::class, 'estudiante_id');
    }
}
