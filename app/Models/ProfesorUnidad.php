<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfesorUnidad extends Model
{
    use HasFactory;
    protected $table = 'profesor_unidad'; 
    protected $fillable = [
        
        'profesor_id',
        'unidad_educativa_id',
        'nivel',
        'curso',
        'paralelo',
        'activo',
    ];

    // Relación con la tabla `profesores`
    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }

    // Relación con la tabla `unidades_educativas`
    // public function unidadEducativa()
    // {
    //     return $this->belongsTo(UnidadEducativa::class, 'unidad_educativa_id', 'id_unidad_educativa');
    // }
    public function unidadesEducativas()
    {
        return $this->belongsToMany(

            UnidadEducativa::class,
            'profesor_unidad_educativa',
            'profesor_unidad_id', // Nombre de la clave foránea en la tabla intermedia que apunta a `profesor_unidad`
            'unidad_educativa_id', // Nombre de la clave foránea en la tabla intermedia que apunta a `unidades_educativas`
            'id', // Clave primaria de la tabla actual
            'id_unidad_educativa' // Clave primaria de la tabla `unidades_educativas`
        );
    }
    public function unidadEducativa()
    {
        return $this->belongsTo(UnidadEducativa::class, 'unidad_educativa_id', 'id_unidad_educativa');
    }

}
