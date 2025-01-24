<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tutor extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'tutores';
    protected $primaryKey = 'id_tutor';

    protected $fillable = [
        'primer_nombre_tutor',
        'segundo_nombre_tutor',
        'primer_apellido_tutor',
        'segundo_apellido_tutor',
        'tercer_apellido_tutor',
        'ci_tutor',
        'expedido_tutor',
    ];
    protected $dates = ['deleted_at'];
    // public function estudiantes()
    // {
    //     return $this->hasMany(EstudianteTutor::class, 'tutor_id');
    // }
    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'estudiante_tutor', 'tutor_id', 'estudiante_id')
            ->withPivot('gestion_id', 'activo')
            ->withTimestamps();
    }

    public function gestion()
    {
        return $this->belongsTo(Gestion::class, 'gestion_id');
    }
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'tutor_id');
    }
    public function reviciones()
    {
        return $this->hasMany(Revicion::class, 'tutor_id');
    }


}
