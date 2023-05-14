<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cotisation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class AdherentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Récupérer toutes les cotisations de l'utilisateur connecté
        $cotisations = Cotisation::where('user_id', $user->id)->get();

        // Retourner la vue avec les cotisations de l'utilisateur connecté
        return view('adherent.listeCotisation', ['cotisations' => $cotisations]);
    }


public function dashboard()
{
       // Récupérer tous les utilisateurs qui ont le rôle "user"
       $users = User::where('role', 'user')->get();

       // Récupérer toutes les cotisations avec les informations utilisateur correspondantes
       $cotisations = Cotisation::with('user')->get();

       return view('adherent.dashboard', compact('users', 'cotisations'));
}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'montant' => 'required|numeric',
            'date' => 'nullable|date',
            'recu_paiement' => 'nullable|file',
        ]);


        // Vérifier si une cotisation pour cette année existe déjà
    $year = Carbon::parse($validatedData['date'])->year;
    if (Cotisation::where('user_id', Auth::user()->id)->whereYear('date', $year)->exists()) {
        return redirect()->back()->with('error', 'Une cotisation pour cette année existe déjà.');
    }

        $cotisation = new Cotisation;

        $cotisation->montant = $validatedData['montant'];
        $cotisation->date = $validatedData['date'];
        $cotisation->user_id = Auth::user()->id;
        if ($request->hasFile('recu_paiement')) {
            $file = $request->file('recu_paiement');
            $fileName = time() . '_' . $file->getClientOriginalName();
            // Enregistrer le fichier dans le stockage public
            $file->move('uploads/recus/',$fileName) ;
            // Enregistrer le chemin d'accès au fichier dans la base de données
            $cotisation->recu_paiement = $fileName;
        }

        // Enregistrement de la cotisation dans la base de données
       $cotisation->save();

       return redirect()->back()->with('success', 'La cotisation a été ajoutée avec succès.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


public function update(Request $request, $id)
{
    $cotisation = Cotisation::findOrFail($id);

    // Vérifier si la cotisation est en attente de validation
    if ($cotisation->statuValidation !== 'en attente') {
        return redirect()->back()->with('error', 'Vous ne pouvez pas modifier une cotisation validée.');
    }


    $validatedData = $request->validate([
        'montant' => 'required|numeric',
        'date' => 'nullable|date',
        'recu_paiement' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:2048',
    ]);
    // Vérifier si une cotisation pour cette année existe déjà


    $cotisation->montant = $validatedData['montant'];
    $cotisation->date = $validatedData['date'];

    if ($request->hasFile('recu_paiement')) {
        $file = $request->file('recu_paiement');
        $fileName = time() . '_' . $file->getClientOriginalName();
        // Enregistrer le fichier dans le stockage public
        $file->move('uploads/recus/',$fileName) ;
        // Enregistrer le chemin d'accès au fichier dans la base de données
        $cotisation->recu_paiement = $fileName;
    }

    $cotisation->save();

    return redirect()->back()->with('successedit', 'Cotisation mise à jour avec succès.');
}



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $cotisation = Cotisation::findOrFail($id);
     // Vérifier si l'utilisateur est l'auteur de la cotisation et si le statut est "en attente"
     if ($cotisation->statuValidation !== 'en attente') {
        return redirect()->back()->with('errordelete', 'Vous ne pouvez pas supprimer une cotisation validée.');
    }

    $cotisation->delete();

    return redirect()->back()->with('successdelete', 'La cotisation a été supprimée avec succès.');
}

}
