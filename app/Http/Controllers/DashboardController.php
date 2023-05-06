<?php

namespace App\Http\Controllers;

use App\Models\Cotisation;
use App\Models\User;
use App\Models\Annee;


use Illuminate\Http\Request;

class DashboardController extends Controller
{


    public function __construct()
{
    $this->middleware('auth');
}

public function index()
{
    $current_year = date('Y'); // année en cours
    $total_users = User::count();
    $total_adherents = User::where('role', 'user')->count();
    $total_cotisations = Cotisation::whereYear('date', $current_year)->count();
    $cotisations_payees = Cotisation::where('status', 'payé')->whereYear('date', $current_year)->count();
    $chiffre_affaire_payé = Cotisation::where('status', 'payé')->whereYear('date', $current_year)->sum('montant');

    //chifrre afaire impaye

    $prix_location = Annee::where('annee', $current_year)->pluck('prix_location')->first();
    $somme_cotisations_impayees = Cotisation::where('status', 'non payé')->whereYear('date', $current_year)->sum('montant');
    $chiffre_affaire_non_payé = ($prix_location * Cotisation::where('status', 'non payé')->whereYear('date', $current_year)->count()) - $somme_cotisations_impayees;




    // Calculs pourcentage payé et non payé
    $pourcentage_paye = $total_cotisations > 0 ? round(($cotisations_payees / $total_cotisations) * 100, 2) : 0;
    $pourcentage_non_paye = 100 - $pourcentage_paye;

    // Passage des variables à la vue
    return view('dashboard', compact('total_users', 'total_adherents' , 'pourcentage_paye', 'pourcentage_non_paye','chiffre_affaire_payé','chiffre_affaire_non_payé'));
}

}

