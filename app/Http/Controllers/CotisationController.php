<?php

namespace App\Http\Controllers;

use App\Models\Cotisation;
use Illuminate\Http\Request;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;



class CotisationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    $users = User::where('role', 'user')->get();
    $cotisations = Cotisation::with('user')->get();
    return view('cotisations.index', compact('users', 'cotisations'));
}

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
        'status' => 'required|in:payé,non payé',
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
