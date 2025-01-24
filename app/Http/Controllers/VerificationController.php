<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutor;

class VerificationController extends Controller
{
    public function verificarDatos(Request $request)
    {
        $ci = $request->input('ci');
        $tutor = Tutor::with('estudiantes')->where('ci_tutor', $ci)->first();

        if ($tutor) {
            return response()->json([
                'success' => true,
                'tutor' => $tutor,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No se encontraron datos con el CI proporcionado.',
        ]);
    }
}
