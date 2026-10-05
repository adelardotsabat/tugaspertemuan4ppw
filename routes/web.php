<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/education', function () {
    return view('education');
})->name('education');

Route::resource('projects', ProjectController::class);


Route::resource('projects', ProjectController::class);

// Route tugas praktikum (Trash, Restore, Force Delete)
Route::get('projects-trash', [ProjectController::class, 'trash'])->name('projects.trash');
Route::post('projects/{id}/restore', [ProjectController::class, 'restore'])->name('projects.restore');
Route::delete('projects/{id}/force-delete', [ProjectController::class, 'forceDelete'])->name('projects.forceDelete');