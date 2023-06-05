<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BilanController;

Route::get('/', function () {
    return view('bienvenue');
});





Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'admin']);
Route::resource('users', App\Http\Controllers\UserController::class)->middleware(['auth', 'admin']);
Route::get('cotisations/download/{id}', [App\Http\Controllers\CotisationController::class, 'downloadReceipt'])->name('cotisations.download')->middleware(['auth', 'admin']);
Route::get('/cotisations/recouvrement', [App\Http\Controllers\CotisationController::class, 'recouvrement'])->name('cotisations.recouvrement');
Route::get('/cotisations/current-year/{status}', [App\Http\Controllers\CotisationController::class, 'showCurrentYearCotisations'])->name('cotisations.showCurrentYearCotisations');
Route::resource('cotisations', App\Http\Controllers\CotisationController::class)->middleware(['auth', 'admin']);
Route::resource('charges',App\Http\Controllers\ChargeController::class)->middleware(['auth', 'admin']);
Route::resource('annees', App\Http\Controllers\AnneeController::class)->middleware(['auth', 'admin']);

Route::get('/parametre/bureau', [App\Http\Controllers\ParametreController::class, 'bureau'])->name('parametre.bureau')->middleware(['auth', 'admin']);

Route::post('/mark-as-read/{id}', [App\Http\Controllers\AdherentController::class, 'markAsRead'])->name('mark-as-read')->middleware(['auth', 'admin']);


Route::get('/parametre/listeMembres', [App\Http\Controllers\ParametreController::class, 'listeMembres'])
    ->name('parametre.listeMembres')
    ->middleware(['auth', 'admin']);


Route::post('/parametre/bureau', [App\Http\Controllers\ParametreController::class, 'storeBureau'])
    ->name('parametre.storeBureau')
    ->middleware(['auth', 'admin']);


Route::get('/parametre/autre', [App\Http\Controllers\ParametreController::class, 'autre'])
    ->name('parametre.autre')
    ->middleware(['auth', 'admin']);

Route::post('/parametre/storeCoordonee', [App\Http\Controllers\ParametreController::class, 'storeCoordonee'])
    ->name('parametre.storeCoordonee')
    ->middleware(['auth', 'admin']);




Route::put('/bureau/{id}', [App\Http\Controllers\ParametreController::class, 'updateBureau'])
->name('parametre.updateBureau')
->middleware(['auth', 'admin']);



Route::delete('/bureau/{id}', [App\Http\Controllers\ParametreController::class, 'destroyBureau'])->name('parametre.destroyBureau');





Route::get('/bilan', [BilanController::class, 'calculateTotals'])->name('bilan.calculate')->middleware(['auth', 'admin']);


Route::post('importer-excel', [App\Http\Controllers\ImporterExel::class, 'import'])->name('importer-excel.import')->middleware(['auth', 'admin']);

Route::get('/dashboard-u', [App\Http\Controllers\AdherentController::class, 'dashboard'])->name('adherent.dashboard')->middleware('auth');




Route::get('/userPage', function () {
    return view('userPage');
})->middleware('auth');

Route::get('/syndicPage', function () {
    return view('syndicPage');
})->middleware(['auth']);

Route::get('/dashboard-user', function () {
    return view('adherent.dashboard-user');
})->name('dashboard-user')->middleware(['auth']);


Route::resource('adherent', App\Http\Controllers\AdherentController::class)->middleware(['auth']);





Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['auth', 'admin']);
