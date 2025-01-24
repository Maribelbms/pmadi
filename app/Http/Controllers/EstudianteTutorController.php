<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Tutor;

class EstudianteTutorController extends Controller
{
    public function show($estudianteId)
    {
        $estudiante = Estudiante::findOrFail($estudianteId);
        $tutores = Tutor::all();
        return view('asignar-tutor', compact('estudiante', 'tutores'));
    }
}
