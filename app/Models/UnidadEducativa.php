<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnidadEducativa extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'unidades_educativas';
    protected $primaryKey = 'id_unidad_educativa';
    protected $fillable = [
        'nombre_unidad',
        'codigo_sie',
        'turno',
        'distrital_educacion',
        'distrito',
        'direccion',
        'estado',
    ];
    protected $dates = ['deleted_at'];

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'tutor_id');
    }
    public function directores()
    {
        return $this->hasMany(User::class, 'unidad_educativa_id', 'id_unidad_educativa')
            ->where('role_id', 4);
    }

    public function profesores()
    {
        return $this->belongsToMany(User::class, 'profesor_unidad', 'unidad_educativa_id', 'user_id', 'profesor_id')
            ->where('role_id', 4);
    }
    // Relación con el director (uno a uno)
    public function director()
    {
        return $this->hasOne(Director::class, 'unidad_educativa_id', 'id_unidad_educativa');
    }

    // Relación con la tabla intermedia `profesor_unidad`
    public function asignaciones()
    {
        return $this->hasMany(ProfesorUnidad::class, 'unidad_educativa_id');
    }
    public function profesoresUnidades()
    {
        return $this->hasMany(ProfesorUnidad::class, 'unidad_educativa_id');
    }
    public function estudiantesGestiones()
    {
        return $this->hasMany(EstudianteGestion::class, 'unidad_educativa_id');
    }
    

    


}
