<?php

namespace App\Http\Controllers;

use App\Models\Cotisation;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Support\Str;




class CotisationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function index(Request $request)
     {
         $users = User::where('role', 'user')->get();
         $cotisations = Cotisation::with('user');
     
         // Récupérer les valeurs des filtres
         $selectedYear = $request->input('year');
         $selectedLetter = $request->input('letter');
         $selectedStatus = $request->input('status');
         $selectedValidationStatus = $request->input('validation_status');
     
         // Appliquer les conditions de filtrage
         if ($selectedYear) {
             $cotisations->whereYear('date', $selectedYear);
         }
     
         if ($selectedLetter) {
             $cotisations->whereHas('user', function ($query) use ($selectedLetter) {
                 $query->where('numero_devilla', 'like', $selectedLetter . '%');
             });
         }
     
         if ($selectedStatus) {
             $cotisations->where('status', $selectedStatus);
         }
         
         if ($selectedValidationStatus) {
             $cotisations->where('statuValidation', $selectedValidationStatus);
         }
     
         $cotisations = $cotisations->get();
     
         // Récupérer toutes les années disponibles pour le filtre par année
         $years = Cotisation::distinct()->selectRaw('YEAR(date) AS year')->pluck('year');
     
         return view('cotisations.index', compact('users', 'cotisations', 'years', 'selectedYear', 'selectedLetter', 'selectedStatus', 'selectedValidationStatus'));
     }
     


 
//--------------------------------------------------------------------------------------------------------------------------------------
//recouvrement------------------------------------------------------------------------------------------------------------------------
public function recouvrement()
{
    $cotisations = Cotisation::selectRaw('cotisations.user_id, users.numero_devilla, users.name, users.lastname, YEAR(cotisations.date) AS annee, cotisations.status, SUM(annees.prix_location - cotisations.montant) AS total_impaye, SUM(CASE WHEN cotisations.status = "non payé" THEN annees.prix_location ELSE 0 END) AS total_prix_location, SUM(CASE WHEN cotisations.status = "payé" THEN cotisations.montant ELSE 0 END) AS total_paye')
        ->join('users', 'cotisations.user_id', '=', 'users.id')
        ->join('annees', 'annees.annee', '=', DB::raw('YEAR(cotisations.date)'))
        ->groupBy('cotisations.user_id', 'annee', 'status', 'numero_devilla', 'users.name', 'users.lastname', 'cotisations.date')
        ->get();

    // Récupérer la liste des utilisateurs pour lesquels des cotisations ont été effectuées
    $users = User::whereIn('id', $cotisations->pluck('user_id')->unique())->get();

    // Récupérer la liste des années pour lesquelles des cotisations ont été effectuées
    $annees = $cotisations->pluck('annee')->unique()->sort();

    return view('cotisations.recouvrement', compact('users', 'cotisations', 'annees'));
}


//_---------------

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('role', 'user')->get();
        return view('cotisations.create', compact('users'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $user = \App\Models\User::find($request->input('user_id'));

    $validatedData = $request->validate([
        'user_id' => 'required|exists:users,id',
        'montant' => 'required|numeric|min:0',
        'date' => 'required|date',
        'recu_paiement' => 'nullable|file',
        'status' => 'required|in:payé,non payé,partiellement payé',
    ]);



     // Extraire l'année de la date entrée par l'utilisateur
     $annee = \Carbon\Carbon::parse($validatedData['date'])->year;

     // Vérifier si une cotisation a déjà été créée pour l'utilisateur dans cette année
     $cotisationExistante = Cotisation::where('user_id', $user->id)
         ->whereYear('date', $annee)
         ->exists();

         if ($cotisationExistante) {
            return back()->with('error', '  Une cotisation pour cet utilisateur a déjà été créée pour l\'année ' . $annee);
        }


    $cotisation = new Cotisation;
    $cotisation->user_id = $validatedData['user_id'];
    $cotisation->montant = $validatedData['montant'];
    $cotisation->date = $validatedData['date'];
    $cotisation->status = $validatedData['status'];

    if ($request->hasFile('recu_paiement')) {
        $file = $request->file('recu_paiement');
        $fileName = time() . '_' . $file->getClientOriginalName();
        // Enregistrer le fichier dans le stockage public
        $file->move('uploads/recus/',$fileName) ;
        // Enregistrer le chemin d'accès au fichier dans la base de données
        $cotisation->recu_paiement = $fileName;
    }


    $cotisation->save();

    return back()->with('success', '   Cotisation ajoutée avec succès.');
}


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cotisation  $cotisation
     * @return \Illuminate\Http\Response
     */
    public function show(Cotisation $cotisation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cotisation  $cotisation
     * @return \Illuminate\Http\Response
     */
    public function edit(Cotisation $cotisation)
{
    $users = User::where('role', 'user')->get();
    return view('cotisations.edit', compact('cotisation', 'users'));
}


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cotisation  $cotisation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cotisation = Cotisation::findOrFail($id);

        $cotisation->user_id = $request->input('user_id');
        $cotisation->montant = $request->input('montant');
        $cotisation->date = $request->input('date');
        $cotisation->status = $request->input('status');
        $cotisation->statuValidation = $request->input('statuValidation');

        if ($request->hasFile('recu_paiement')) {
            $file = $request->file('recu_paiement');
            $fileName = time() . '_' . $file->getClientOriginalName();
            // Enregistrer le fichier dans le stockage public
            $file->move('uploads/recus/',$fileName) ;
            // Enregistrer le chemin d'accès au fichier dans la base de données
            $cotisation->recu_paiement = $fileName;
        }

        $cotisation->save();

        return redirect()->route('cotisations.index')->with('successedit', '   Cotisation modifiée avec succès.');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cotisation  $cotisation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $cotisation = Cotisation::findOrFail($id);
    $cotisation->delete();

    return redirect()->route('cotisations.index')->with('successdelete', '   Cotisation supprimée avec succès.');
}

}
