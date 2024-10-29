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

}
