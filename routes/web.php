<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Pages\UploadExcelPmadi;
use App\Http\Controllers\VerificationController;
use App\Filament\Resources\TutorResource;
use App\Http\Controllers\TutorController;
use App\Livewire\Modales\AsignarTutorModal;

Route::get('/', function () {
    return view('page.index');
})->name('index');
Route::get('/login', function () {
    return redirect('inicio/login');
})->name('login');
Route::post('/verificar-datos', [VerificationController::class, 'verificarDatos'])->name('verificar.datos');
Route::post('/upload-excel', [UploadExcelPmadi::class, 'uploadFile'])->name('upload-excel');
// Route::get('/asignar-tutor/{estudiante}', [TutorController::class, 'show'])->name('asignar-tutor');
// Route::get('/admin/tutors/create/{estudiante}', [TutorResource::class, 'createWithEstudiante'])
//     ->name('filament.resources.tutors.create');


// Route::get('/asignar-tutor/{id}', AsignarTutorModal::class)
//     ->name('asignar-tutor');