<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerificationController;
use App\Filament\Resources\TutorResource;
use App\Http\Controllers\TutorController;

Route::get('/', function () {
    return view('page.index');
})->name('index');
Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');
Route::post('/verificar-datos', [VerificationController::class, 'verificarDatos'])->name('verificar.datos');
// Route::get('/asignar-tutor/{estudiante}', [TutorController::class, 'show'])->name('asignar-tutor');
// Route::get('/admin/tutors/create/{estudiante}', [TutorResource::class, 'createWithEstudiante'])
//     ->name('filament.resources.tutors.create');

