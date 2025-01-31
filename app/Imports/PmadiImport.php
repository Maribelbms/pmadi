<?php

namespace App\Imports;

use App\Models\Estudiante;
use App\Models\Tutor;
use App\Models\UnidadEducativa;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PmadiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        try {
            // Buscar o crear la unidad educativa
            $unidadEducativa = UnidadEducativa::firstOrCreate(
                ['nombre_unidad' => $row['unidad_educativa']],
                ['codigo_sie' => $row['codigo_sie'] ?? null]
            );

            // Buscar o crear el tutor
            $tutor = Tutor::firstOrCreate(
                ['ci_tutor' => $row['ci_tutor']],
                [
                    'primer_nombre_tutor' => $row['primer_nombre_tutor'],
                    'primer_apellido_tutor' => $row['primer_apellido_tutor'],
                    'expedido_tutor' => $row['expedido_tutor'],
                ]
            );

            // Crear el estudiante
            return new Estudiante([
                'primer_nombre' => $row['primer_nombre'],
                'segundo_nombre' => $row['segundo_nombre'] ?? null,
                'primer_apellido' => $row['primer_apellido'],
                'segundo_apellido' => $row['segundo_apellido'] ?? null,
                'ci' => $row['ci'],
                'expedido' => $row['expedido'],
                'sexo' => $row['sexo'],
                'rude' => $row['rude'],
                'nivel' => $row['nivel'],
                'curso' => $row['curso'],
                'paralelo' => $row['paralelo'],
                'porcentaje_asistencia' => $row['porcentaje_asistencia'],
                'habilitado' => $row['habilitado'] ?? 'no',
                'tutor_id' => $tutor->id_tutor,
                'unidad_educativa_id' => $unidadEducativa->id_unidad_educativa,
            ]);
        } catch (\Exception $e) {
            Log::error('Error al importar fila: ' . json_encode($row) . ' | ' . $e->getMessage());
            return null;
        }
    }
}
