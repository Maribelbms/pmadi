<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Observacion extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'observaciones';
    protected $primaryKey = 'id_observacion';
    protected $fillable = [
        'tipo_observacion',
        'descripcion',
        'fecha_observacion',
        'persona_id',
        'usuario_id',
        'gestion_id',
    ];
    protected $dates = ['fecha_observacion', 'deleted_at'];
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }   

    public function gestion()
    {
        return $this->belongsTo(Gestion::class, 'gestion_id', 'id_gestion');
    }
}
