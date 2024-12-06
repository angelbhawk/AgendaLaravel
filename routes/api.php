<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\AuthController;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('auth.logout');
});

use App\Http\Controllers\NoteController;

Route::middleware('auth:sanctum')->prefix('notes')->group(function () {
    Route::get('/', [NoteController::class, 'index'])->name('notes.index');          // Listar todas las notas
    //Route::get('/', [NoteController::class, 'index'])->name('notes.index');          // Listar todas las notas
    Route::post('/', [NoteController::class, 'store'])->name('notes.store');         // Crear una nueva nota
    Route::get('/{note}', [NoteController::class, 'show'])->name('notes.show');      // Mostrar una nota específica
    Route::put('/{note}', [NoteController::class, 'update'])->name('notes.update');  // Actualizar una nota específica
    Route::delete('/{note}', [NoteController::class, 'destroy'])->name('notes.destroy'); // Eliminar una nota específica
});
