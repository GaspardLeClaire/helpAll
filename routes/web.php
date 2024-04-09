<?php

use App\Http\Controllers\FormulaireController;
use App\Http\Controllers\MessagerieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServicesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[ServicesController::class, 'index'])->name('public.index');
Route::post('/',[ServicesController::class, 'filtreDemande'])->name('service.filtre');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile/25',[ProfileController::class, 'credit25'])->name('profile.credit.25');
    Route::get('/profile/50',[ProfileController::class, 'credit50'])->name('profile.credit.50');
    Route::get('/profile/75',[ProfileController::class, 'credit75'])->name('profile.credit.75');

    Route::get('/dashboard',[ProfileController::class, 'dashboard'])->middleware(['verified'])->name('dashboard');

    Route::get('/messagerie',[MessagerieController::class, 'index'])->name('message.index');
    Route::post('/message/{IDUTILISATEUR_2}/{IDSERVICE}/{IDUTILISATEUR_1}', [MessagerieController::class, 'store'])->name('message.store');

    Route::get('/formulaireAnnonce',[FormulaireController::class,'index'])->name('formulaire.index');
    Route::post('/formulaireAnnonce',[FormulaireController::class,'store'])->name('formulaire.store');

    Route::get('/portailFormulaire/{IDSERVICE}/{IDUTILISATEUR}',[FormulaireController::class,'indexPortail'])->name('formulaire.portail');

    Route::get('/covoiturage/{IDSERVICE}/{IDUTILISATEUR}',[FormulaireController::class,'indexCovoiturage'])->name('formulaire.index.covoiturage');
    Route::post('/covoiturage/{IDSERVICE}/{IDUTILISATEUR}',[FormulaireController::class,'storeCovoiturage'])->name('formulaire.store.covoiturage');

    Route::get('/competence/{IDSERVICE}/{IDUTILISATEUR}',[FormulaireController::class,'indexCompetence'])->name('formulaire.index.competence');
    Route::post('/competence/{IDSERVICE}/{IDUTILISATEUR}',[FormulaireController::class,'storeCompetence'])->name('formulaire.store.competence');


    Route::get('/detail/{IDSERVICE}/{IDUTILISATEUR}',[ServicesController::class,'detail'])->name('service.detail');
    Route::post('/detail/{IDSERVICE}/{IDUTILISATEUR}',[ServicesController::class,'offre'])->name('service.offre');
});

require __DIR__.'/auth.php';
