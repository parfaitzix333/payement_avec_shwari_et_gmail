<?php

use App\Http\Controllers\AlertController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\FraisController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UtilisateurController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    return view('dashboard', compact('user'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //les profiles
    route::get('/profile_admin', [ProfileController::class, 'profile_admin'])->name('profile_admin');
    route::get('/profile_parent', [ProfileController::class, 'profile_parent'])->name('profile_parent');

    //les route shwary pour le paiement
    Route::get('/form_payement/{id}', [App\Http\Controllers\PaymentController::class, 'form_payement'])->name('form_payement');

    //RESSOURCES
    route::resource('eleves',EleveController::class);
    route::resource('les_frais',FraisController::class);
    route::resource('classes', ClasseController::class);

    //affichage des listes
    route::get('/rechercher_eleve/{id?}', [EleveController::class, 'rechercher_eleve'])->name('rechercher_eleve');
    Route::get('/les_alerts', [AlertController::class, 'les_alerts'])->name('les_alerts');
    route::get('/edit_profile_admin', [UtilisateurController::class, 'edit_profile_admin'])->name('edit_profile_admin');
    route::get('/edit_profile_parent', [UtilisateurController::class, 'edit_profile_parent'])->name('edit_profile_parent');
    route::get('/les_users', [UtilisateurController::class,'les_users'])->name('les_users');
    route::get('/mes_payements', [PaymentController::class, 'mes_payements'])->name('mes_payements');
    route::get('/les_payements', [PaymentController::class, 'les_payements'])->name('les_payements');

    //les ajouts
    Route::post('/ajouter_alert', [AlertController::class, 'ajouter_alert'])->name('ajouter_alert');
    Route::post('/sendSelected', [AlertController::class, 'sendSelected'])->name('sendSelected');
    Route::post('/diffuser', [AlertController::class, 'diffuser'])->name('diffuser');
    Route::post('/payer/shwary',[PaymentController::class, 'pay'])->name('payer.shwary');

    //les formulaire
    route::get('/form_payement/{id}',[PaymentController::class, 'form_payement'])->name('form_payement');

    //les modifications
    route::put('/modifier_utilisateur/{id}',[UtilisateurController::class, 'modifier_utilisateur'])->name('modifier_utilisateur');
    route::put('/modifier_alert/{id}',[AlertController::class, 'modifier_alert'])->name('modifier_alert');
    
    //les suppressions
    route::delete('/supprimer_alert/{id}',[AlertController::class, 'supprimer_alert'])->name('supprimer_alert');
    route::delete('/supprimer_payement/{id}',[PaymentController::class, 'supprimer_payement'])->name('supprimer_payement'); 

});

require __DIR__ . '/auth.php';
