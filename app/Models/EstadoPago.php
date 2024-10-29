<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoPago extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'estados_pago';
    protected $primaryKey = 'id_estado';
    protected $fillable = [
        'nombre_estado',
    ];
    protected $dates = ['deleted_at'];
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'estado_id');
    }


}
