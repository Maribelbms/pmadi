<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReporteBancario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reporte_bancario';
    protected $primaryKey = 'id_reporte';

    protected $fillable = [
        'fecha_carga',
        'descripcion',
        'usuario_id',
        'gestion_id',
    ];
    protected $dates = ['fecha_carga', 'deleted_at'];
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function gestion()
    {
        return $this->belongsTo(Gestion::class, 'gestion_id');
    }

}
