<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('page.index');
})->name('index');
Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');
