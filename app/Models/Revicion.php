<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Revicion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reviciones';
    protected $primaryKey = 'id_revicion';

    protected $fillable = [
        'tipo_entidad',
        'estudiante_id',
        'tutor_id',
        'estado_revicion',
        'descripcion',
        'usuario_id',
        'fecha_revicion',
    ];
    protected $dates = [
        'deleted_at', 'fecha_revicion',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id', 'id_estudiante');
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'tutor_id', 'id_tutor');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
