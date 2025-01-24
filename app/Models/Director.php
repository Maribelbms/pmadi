<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Director extends Model
{
    protected $table = 'directores';

    protected $fillable = [
        'user_id',
        'ci',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'email',
        'telefono',
        'unidad_educativa_id',
        'activo',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function unidadEducativa()
    {
        return $this->belongsTo(UnidadEducativa::class, 'unidad_educativa_id', );
    }
    
    // public static function rules()
    // {
    //     return [
    //         'unidad_educativa_id' => [
    //         'required',
    //         'exists:unidades_educativas,id_unidad_educativa',
    //         function ($attribute, $value, $fail) {
    //             if (Director::where('unidad_educativa_id', $value)->exists()) {
    //                 $fail('Esta unidad educativa ya tiene un director asignado.');
    //             }
    //         },
    //     ],
            
    //         'user_id' => 'required|exists:users,id',
    //         'ci' => 'required|unique:directores,ci',
    //         'primer_nombre' => 'required|string|max:255',
    //         'primer_apellido' => 'required|string|max:255',
    //         'email' => 'required|email|unique:directores,email',
    //         'telefono' => 'nullable|string|max:15',
    //                 ];
    // }
    
    public static function rules()
    {
        return [
            'unidad_educativa_id' => [
                'required',
                Rule::unique('directores')->where(function ($query) {
                    return $query->where('activo', true);
                }),            ],
            'user_id' => 'required|exists:users,id',
            'ci' => 'required|unique:directores,ci',
            'primer_nombre' => 'required|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:directores,email',
            'telefono' => 'nullable|string|max:15',
        ];
    }
}
