<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Pago extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pagos';
    protected $primaryKey = 'id_pago';
    protected $fillable = [
        'estudiante_id',
        'tutor_id',
        'unidad_educativa_id',
        'gestion_id',
        'monto_bono',
        'fecha',
        'estado_id',
    ];
    protected $dates = ['fecha', 'deleted_at'];
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'tutor_id');
    }
    public function unidad_educativa()
    {
        return $this->belongsTo(UnidadEducativa::class, 'unidad_educativa_id');
    }

    public function gestion()
    {
        return $this->belongsTo(Gestion::class, 'gestion_id');
    }

    public function estados_pago()
    {
        return $this->belongsTo(EstadoPago::class, 'estado_id');
    }
}
