<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Revicion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reviciones'; // Nombre de la tabla
    protected $primaryKey = 'id_revicion'; // Clave primaria

    protected $fillable = [
        'estudiante_id',        // Relación con estudiante
        'tutor_id',             // Relación con tutor
        'estado_registro',      // Estado del flujo (inicializacion, en revision, aprobado)
        'observaciones',        // Observaciones sobre la revisión
        'fecha_revicion',       // Fecha de la última revisión
    ];

    protected $dates = ['deleted_at', 'fecha_revicion']; // Fechas gestionadas por Laravel

    /**
     * Relación con el modelo Estudiante.
     */
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id', 'id_estudiante');
    }

    /**
     * Relación con el modelo Tutor.
     */
    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'tutor_id', 'id_tutor');
    }

    /**
     * Cambiar el estado a "en revision".
     */
    public function marcarEnRevision()
    {
        $this->update([
            'estado_registro' => 'en revision',
            'fecha_revicion' => now(),
        ]);
    }

    /**
     * Cambiar el estado a "aprobado".
     */
    public function marcarAprobado()
    {
        $this->update([
            'estado_registro' => 'aprobado',
            'fecha_revicion' => now(),
        ]);
    }

    /**
     * Comprobar si está en estado "aprobado".
     */
    public function esAprobado()
    {
        return $this->estado_registro === 'aprobado';
    }

    /**
     * Comprobar si está en estado "en revision".
     */
    public function estaEnRevision()
    {
        return $this->estado_registro === 'en revision';
    }

    /**
     * Comprobar si está en estado "inicializacion".
     */
    public function estaEnInicializacion()
    {
        return $this->estado_registro === 'inicializacion';
    }
}
