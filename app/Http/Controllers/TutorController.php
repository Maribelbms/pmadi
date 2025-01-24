<?php

namespace App\Http\Controllers;
use App\Models\Estudiante;
use Illuminate\Http\Request;

class TutorController extends Controller
{

    public function asignarTutor($estudianteId)
    {
        $estudiante = Estudiante::findOrFail($estudianteId);

        return view('asignar-tutor', compact('estudiante'));
    }
}
