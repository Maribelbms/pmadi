<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraAuditoria extends Model
{
    use HasFactory;
    protected $table = 'bitacora_auditoria';
    protected $primaryKey = 'id_bitacora';

    protected $fillable = [
        'usuario_id',
        'tabla_afectada',
        'id_registro_afectado',
        'accion_realizada',
        'fecha',
        'datos_anteriores',
        'datos_nuevos',
        'ip',
        'navegador',
    ];
    
    protected $dates = [
        'fecha',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }


}
