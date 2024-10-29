<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GestionContenido extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gestion_contenido';
    protected $primaryKey = 'id_gestion_contenido';

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'url',
        'tipo',
    ];
    protected $dates = ['deleted_at'];

     

}
