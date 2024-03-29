<?php

use App\Http\Controllers\PointageController;
use Illuminate\Support\Facades\Route;


/*Route::get('/', function () {
    return view('welcome');
});*/

//Groupement des routes dont il faut se connecter pour y avoir accès
Route::prefix('Gestion de pointage')->middleware('auth')->group(function (){
//Route de déconnexion
    Route::delete('logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

//Utilisateur ou employé
    Route::resource('User', \App\Http\Controllers\Usercontroller::class);

//Page de scanner
    Route::get('Presencedujour', [PointageController::class, 'index'])->name('AffichagePresence');
    Route::get('Pointage', [PointageController::class, 'create'])->name('Pointage');
    Route::post('Pointage/post', [PointageController::class, 'store'])->name('recupQrcode');
    Route::delete('Pointage/{id}', [PointageController::class, 'destroy'])->name('Suppresion');
    Route::get('Pointage/{id}', [PointageController::class, 'show'])->name('Details');

//Route des avances
    Route::resource('Avance', \App\Http\Controllers\AvanceController::class);

//Routes des paiements
    Route::resource('Paiements', \App\Http\Controllers\Paiementcontroller::class);
    Route::post('Paiements/{id}', [\App\Http\Controllers\Paiementcontroller::class, 'store'])->name('generatebulletin');
    Route::get('BulletinPaie/{id}', [\App\Http\Controllers\Paiementcontroller::class, 'generateBulletin'])->name('BulletinPaie');

});

//Login
Route::get('/', [\App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::post('connect', [\App\Http\Controllers\LoginController::class, 'connect'])->name('connect');

