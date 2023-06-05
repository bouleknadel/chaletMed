<?php

namespace App\Http\Controllers;

use App\Models\Cotisation;
use App\Models\User;
use App\Models\Annee;
use App\Models\Bureau;
use App\Models\Charge;
use App\Models\CoordoneeBanque;
use App\Models\Notification;


use Illuminate\Http\Request;

class DashboardController extends Controller
{


    public function __construct()
{
    $this->middleware('auth');
}

public function index()
{
    $current_year = date('Y'); // Année en cours
    $current_month = date('n'); // Mois actuel (1-12)
    $current_day = date('j'); // Jour actuel (1-31)

if ($current_month >= 1 && $current_month <= 7 && $current_day <= 31) {
    $current_year--; // Si la date est entre le 1er janvier et le 31 juillet, réduire l'année en cours de 1
}

// Reste du code inchangé...

$coordoneeBanque = CoordoneeBanque::all();

    $total_users = User::count();
    $total_adherents = User::where('role', 'user')->count();

    // Récupérer les cotisations de l'année en cours
    $total_cotisations = Cotisation::where('annee', $current_year)->count();
    // Nombre de cotisations payées dans l'année en cours
    $cotisations_payees = Cotisation::where('status', 'payé')->where('annee', $current_year)->count();
    // Nombre de cotisations partiellement payées dans l'année en cours
    $cotisations_partiellement_payees = Cotisation::where('status', 'partiellement payé')->where('annee', $current_year)->count();
    // Le chiffre d'affaires payé dans cette année
    $chiffre_affaire_payé = Cotisation::where('status', 'payé')->where('annee', $current_year)->sum('montant');

    // Prix de location de cette année
    $prix_location = Annee::where('annee', $current_year)->pluck('prix_location')->first();

    $somme_cotisations_impayees = Cotisation::where('status', 'partiellement payé')->where('annee', $current_year)->sum('montant');
    $chiffre_affaire_non_payé = ($prix_location * Cotisation::where('status', 'partiellement payé')->where('annee', $current_year)->count()) - $somme_cotisations_impayees;

    // Liste des charges disponibles
$charges_disponibles = [
    'Sécurité',
    'Jardinage',
    'Charges annexes',
    'Divers',
    'Salaire',
    'Plomberie'
];

// Récupération des charges de l'année actuelle depuis la base de données
$charges_base = Charge::where('annee', $current_year)->get()->groupBy('rubrique')->map(function ($charges) {
    return $charges->sum('montant');
});

// Initialisation des montants de chaque rubrique de charge avec la valeur 0
$rubriques_charges = collect([]);

// Attribution des montants des charges existantes dans la base de données
foreach ($charges_disponibles as $charge) {
    $rubriques_charges[$charge] = $charges_base->has($charge) ? $charges_base[$charge] : 0;
}


    // Calcul pourcentage payé, partiellement payé et non payé
    $pourcentage_paye = $total_cotisations > 0 ? round(($cotisations_payees / $total_cotisations) * 100, 2) : 0;
    $pourcentage_partiellement_paye = $total_cotisations > 0 ? round(($cotisations_partiellement_payees / $total_cotisations) * 100, 2) : 0;
    $pourcentage_non_paye = 100 - $pourcentage_paye - $pourcentage_partiellement_paye;

    $membres = Bureau::whereIn('fonction', ['Président', 'Premier vice président exécutif', 'Trésorier', 'Responsable juridique'])->get();
    $agentsSecurite = Bureau::whereIn('fonction', ['Chef de sécurité', 'Agent jadinier', 'Agent de sécurité'])->get();


    // notifications 

    // Passage des variables à la vue
    return view('dashboard', compact('total_users', 'total_adherents', 'pourcentage_paye', 'pourcentage_non_paye',
    'pourcentage_partiellement_paye', 'chiffre_affaire_payé', 'chiffre_affaire_non_payé', 'membres', 'agentsSecurite', 'rubriques_charges','coordoneeBanque'));
}

}
