<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Cotisation;
use Illuminate\Support\Facades\DB;
use App\Models\Annee;
use App\Models\Charge;


class BilanController extends Controller
{
    public function calculateTotals()
    {
        // Total des cotisations payées dans l'année en cours
        $cotisationsPayeesAnneeEnCours = Cotisation::where('status', 'payé')
            ->whereYear('date', date('Y'))
            ->sum('montant');

        // Total des cotisations non payées dans l'année en cours
        $cotisationsNonPayeesAnneeEnCours = Cotisation::where('status', 'non payé')
            ->whereYear('date', date('Y'))
            ->sum('montant');



// Obtenez l'année précédente à partir de la date actuelle
$anneePrecedente = Carbon::now()->subYear()->format('Y');
// Obtenez l'année minimale à partir des enregistrements de la table Cotisation
$anneeMin = Cotisation::min(DB::raw('YEAR(date)'));
// Tableau pour stocker les montants non payés par année
$montantsNonPayesParAnnee = [];
// Calcul du montant non payé pour chaque année précédente
while ($anneePrecedente >= $anneeMin) {
    $nombreCotisationsNonPayees = Cotisation::where('status', 'non payé')
        ->whereYear('date', $anneePrecedente)
        ->count();
    $prixLocationPrecedent = Annee::where('annee', $anneePrecedente)->value('prix_location');
    $montantNonPaye = $prixLocationPrecedent * $nombreCotisationsNonPayees;
    $montantsNonPayesParAnnee[$anneePrecedente] = $montantNonPaye;
    $anneePrecedente--;
}


        // Total des cotisations partielles dans l'année en cours
        $cotisationsPartiellesAnneeEnCours = Cotisation::where('status', 'partiellement payé')
            ->whereYear('date', date('Y'))
            ->sum('montant');

        // Total des cotisations en cours de validation dans l'année en cours
        $cotisationsEnCoursValidationAnneeEnCours = Cotisation::where('statuValidation', 'en attente')
            ->whereYear('date', date('Y'))
            ->sum('montant');

            // Calculer la somme des montants de chaque charge dans l'année en cours par rubrique
    $chargesRubriquesMontants = Charge::whereYear('date', date('Y'))
    ->select('rubrique', DB::raw('SUM(montant) as total'))
    ->groupBy('rubrique')
    ->get();



        return view('bilan', compact(
            'cotisationsPayeesAnneeEnCours',
            'cotisationsNonPayeesAnneeEnCours',
            'montantsNonPayesParAnnee',
            'cotisationsPartiellesAnneeEnCours',
            'cotisationsEnCoursValidationAnneeEnCours',
            'chargesRubriquesMontants'
        ));
    }
}
