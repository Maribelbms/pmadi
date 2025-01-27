<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gestiones';
    protected $primaryKey = 'id_gestion';

    protected $fillable = [
        'nombre_gestion',
        'fecha_inicio',
        'fecha_fin',
        'estado',

    ];
    protected $dates = ['fecha_inicio', 'fecha_fin', 'deleted_at'];
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'gestion_id');
    }
      
    public function reportes_bancarios()
    {
        return $this->hasMany(ReporteBancario::class, 'gestion_id');
    }
    public function observaciones()
    {
        return $this->hasMany(Observacion::class, 'gestion_id');
    }
    public function estudiantesGestiones()
    {
        return $this->hasMany(EstudianteGestion::class, 'gestion_id');
    }


}
