<?php

namespace App\Filament\Resources\DirectorResource\Pages;

use App\Filament\Resources\DirectorResource;
use Filament\Actions;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Models\Director;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Filament\Resources\Pages\CreateRecord;

class CreateDirector extends CreateRecord
{
    protected static string $resource = DirectorResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Verificar si ya existe un director asignado a la unidad educativa
        $existingDirector = Director::where('unidad_educativa_id', $data['unidad_educativa_id'])->first();

        if ($existingDirector) {
             throw ValidationException::withMessages([
                 'date.unidad_educativa_id' => 'Esta unidad educativa ya tiene un director asignado.',
             ]);
            // Log::error('Unidad Educativa ya tiene un director asignado: ' . $data['unidad_educativa_id']);
            // throw ValidationException::withMessages([
            //     'unidad_educativa_id' => 'Esta unidad educativa ya tiene un director asignado.',
            // ]);
        }



        // Verificar y crear el usuario
        $user = User::create([
            'name' => $data['primer_nombre'] . ' ' . $data['primer_apellido'],
            'email' => $data['user']['email'],
            'password' => bcrypt($data['user']['password']),
        ]);

        $user->assignRole('director');
        $data['user_id'] = $user->id;
        $data['email'] = $data['user']['email'];


        return $data;


    }


}
