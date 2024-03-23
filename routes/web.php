<?php

use App\Http\Controllers\PointageController;
use Illuminate\Support\Facades\Route;


/*Route::get('/', function () {
    return view('welcome');
});*/

//Login
Route::get('/', [\App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::post('connect', [\App\Http\Controllers\LoginController::class, 'connect'])->name('connect');
Route::delete('logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

//Utilisateur ou employé
Route::resource('User', \App\Http\Controllers\Usercontroller::class);

//Page de scanner
Route::get('Presencedujour', [PointageController::class, 'index'])->name('AffichagePresence');
Route::get('Pointage', [PointageController::class, 'create'])->name('Pointage');
Route::post('Pointage/post', [PointageController::class, 'post'])->name('recupQrcode');
Route::delete('Pointage/{id}', [PointageController::class, 'destroy'])->name('Suppresion');
Route::get('Pointage/{id}', [PointageController::class, 'show'])->name('Details');
