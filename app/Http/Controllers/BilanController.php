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
    public function calculateTotals(Request $request)
    {
        $current_year = date('Y'); // Année en cours
        $current_month = date('n'); // Mois actuel (1-12)
        $current_day = date('j'); // Jour actuel (1-31)
    
    if ($current_month >= 1 && $current_month <= 7 && $current_day <= 31) {
        $current_year--; // Si la date est entre le 1er janvier et le 31 juillet, réduire l'année en cours de 1
    }

    $anneeSelectionnee = substr($request->input('annee', $current_year), 0, 4);
        // Total des cotisations payées dans l'année selectionnee
        $cotisationsPayeesAnneeEnCours = Cotisation::where('status', 'payé')
            ->where('annee', $anneeSelectionnee)
            ->sum('montant');
    
        // Total des cotisations non payées dans l'année selectionnee
        $cotisationsNonPayeesAnneeEnCours = Cotisation::where('status', 'non payé')
            ->where('annee', $anneeSelectionnee)
            ->sum('montant');
    
        // Obtenez l'année précédente à partir de la date actuelle
        $anneePrecedente = ($anneeSelectionnee - 1);
        // Obtenez l'année minimale à partir des enregistrements de la table Cotisation
        $anneeMin = Cotisation::min('annee');
    
        if (!$anneeMin) {
            $anneeMin = $current_year;
        }
    
        // Tableau pour stocker les montants non payés par année
        $montantsNonPayesParAnnee = [];
        // Calcul du montant non payé pour chaque année précédente
        while ($anneePrecedente >= $anneeMin && $anneePrecedente >= $anneeSelectionnee) {
            $nombreCotisationsNonPayees = Cotisation::where('status', 'non payé')
                ->where('annee', $anneePrecedente)
                ->count();
            $prixLocationPrecedent = Annee::where('annee', $anneePrecedente)->value('prix_location');
            $montantNonPaye = $prixLocationPrecedent * $nombreCotisationsNonPayees;
            $montantsNonPayesParAnnee[$anneePrecedente] = $montantNonPaye;
            $anneePrecedente--;
        }
    
        // Total des cotisations partielles dans lannee selectionner
        $cotisationsPartiellesAnneeEnCours = Cotisation::where('status', 'partiellement payé')
            ->where('annee',  $anneeSelectionnee)
            ->sum('montant');
    
        // Total des cotisations en cours de validation dans l'année selectionne
        $cotisationsEnCoursValidationAnneeEnCours = Cotisation::where('statuValidation', 'en attente')
            ->where('annee',  $anneeSelectionnee)
            ->sum('montant');
    
        // Calculer la somme des montants de chaque charge dans l'année selectionner
        $chargesRubriquesMontants = Charge::where('annee',  $anneeSelectionnee)
            ->select('rubrique', DB::raw('SUM(montant) as total'))
            ->groupBy('rubrique')
            ->get();
    
            return view('bilan', compact(
                'cotisationsPayeesAnneeEnCours',
                'cotisationsNonPayeesAnneeEnCours',
                'montantsNonPayesParAnnee',
                'cotisationsPartiellesAnneeEnCours',
                'cotisationsEnCoursValidationAnneeEnCours',
                'chargesRubriquesMontants',
                'current_year',
                'anneeSelectionnee'
            ));
            
    }
}
    
