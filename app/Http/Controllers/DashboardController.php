<?php

namespace App\Http\Controllers;

use App\Models\Cotisation;
use App\Models\User;

use Illuminate\Http\Request;

class DashboardController extends Controller
{


    public function __construct()
{
    $this->middleware('auth');
}

public function index()
{
    $total_users = User::where('role', 'user')->count();
    $total_cotisations = Cotisation::count();
    $cotisations_payees = Cotisation::where('status', 'payé')->count();

    // Calculs pourcentage payé et non payé
    $pourcentage_paye = $total_cotisations > 0 ? round(($cotisations_payees / $total_cotisations) * 100, 2) : 0;
    $pourcentage_non_paye = 100 - $pourcentage_paye;

    // Passage des variables à la vue
    return view('dashboard', compact('total_users', 'pourcentage_paye', 'pourcentage_non_paye'));
}


}

