<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstudianteTutor extends Model
{
    use HasFactory;

    protected $table = 'estudiante_tutor';

    protected $fillable = [
        'estudiante_id',
        'tutor_id',
        'gestion_id',
        'activo',
    ];
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'tutor_id', 'id_tutor');
    }
    

    public function gestion()
    {
        return $this->belongsTo(Gestion::class, 'gestion_id');
    }
}
