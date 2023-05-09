<?php

use Illuminate\Support\Facades\Route;


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
