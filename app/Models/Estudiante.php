<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        return $this->hasOne(EstudianteTutor::class, 'estudiante_id')
            ->where('activo', true)
            ->with('tutor');
    }

    public function unidadEducativa()
    {
        return $this->belongsTo(UnidadEducativa::class, 'unidad_educativa_id');
    }

    public function reviciones()
    {
        return $this->hasMany(Revicion::class, 'estudiante_id');
    }
    public function gestiones()
    {
        return $this->hasMany(EstudianteGestion::class, 'estudiante_id');
    }
    public function scopeWithNombreCompleto($query)
    {
        $query->select('*', DB::raw("CONCAT(primer_nombre, ' ', COALESCE(segundo_nombre, ''), ' ', primer_apellido, ' ', COALESCE(segundo_apellido, '')) AS nombre_completo"));
    }
    public function unidadEducativaEstudiante()
    {
        return $this->hasOneThrough(
            UnidadEducativa::class, // Modelo final
            EstudianteGestion::class, // Modelo intermedio
            'estudiante_id', // Foreign key en EstudianteGestion
            'id_unidad_educativa', // Foreign key en UnidadEducativa
            'id_estudiante', // Local key en Estudiante
            'unidad_educativa_id' // Local key en EstudianteGestion
        );
    }
    public function estudianteGestion()
    {
        return $this->hasOne(EstudianteGestion::class, 'estudiante_id', 'id_estudiante');
    }

}
