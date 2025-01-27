<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;
    protected $table = 'profesores';

    protected $fillable = [
        'user_id',
        'ci',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'email',
        'telefono',
        'activo',
    ];

    // Relación con la tabla `users`
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con la tabla intermedia `profesor_unidad`
    // public function asignaciones()
    // {
    //     return $this->hasMany(ProfesorUnidad::class, 'profesor_id');
    // }
    // public function unidades()
    // {
    //     return $this->hasMany(ProfesorUnidad::class);
    // }
    // Relación con la tabla profesor_unidad
    public function profesorUnidad()
    {
        return $this->hasMany(ProfesorUnidad::class);
    }
    public function unidadEducativa()
    {
        return $this->belongsTo(UnidadEducativa::class, 'unidad_educativa_id', 'id_unidad_educativa');
    }


}
