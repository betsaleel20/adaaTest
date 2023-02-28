<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/guest-list',[UserController::class , 'index'])->name('user.guestList'); // Afficher la liste des utilisateurs

Route::post('/test',[UserController::class , 'store'])->name('api.user.store'); // Enregistrer un nouveau user en BD

Route::post('/login',[UserController::class , 'login'])->name('api.user.login'); // Connexion

Route::post('/edit/{idUser}',[UserController::class , 'update'])->name('user.update'); // Sauvegarde des modifications

Route::post('/destroy/{idUser}',[UserController::class , 'destroy'])->name('user.destroy'); // Details d'un utilisateur

