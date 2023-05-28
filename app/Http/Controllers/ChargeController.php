<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use Illuminate\Http\Request;

class ChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    $query = Charge::query();
    $current_year = date('Y'); // Année en cours
    $current_month = date('n'); // Mois actuel (1-12)
    $current_day = date('j'); // Jour actuel (1-31)

    if ($current_month >= 1 && $current_month <= 7 && $current_day <= 31) {
        $current_year--; // Si la date est entre le 1er janvier et le 31 juillet, réduire l'année en cours de 1
    }

    // Récupérer les valeurs sélectionnées depuis la requête
    $selectedType = $request->input('type');
    $selectedRubrique = $request->input('rubrique');
    $selectedYear = $request->input('year');

    // Faire les opérations de filtrage en fonction des valeurs sélectionnées
    if ($selectedType) {
        $query->where('type', $selectedType);
    }

    if ($selectedRubrique) {
        $query->where('rubrique', $selectedRubrique);
    }

    if ($selectedYear) {
        $query->where('annee', $selectedYear);
    }

    // Exécuter la requête
    $charges = $query->get();

    // Passer les variables à la vue
    return view('charges.index', compact('charges', 'selectedType', 'selectedRubrique', 'selectedYear', 'current_year'));
}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('charges.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // Valider les données soumises par le formulaire
    $validatedData = $request->validate([
        'rubrique' => 'required',
        'description' => 'required',
        'montant' => 'required|numeric',
        'type' => 'required',
        'date' => 'required|date',
        'status' => 'required',
        'annee' => 'required',
    ]);

    // Stocker les données dans la base de données
    $charge = new Charge();
    $charge->rubrique = $validatedData['rubrique'];
    $charge->description = $validatedData['description'];
    $charge->montant = $validatedData['montant'];
    $charge->type = $validatedData['type'];
    $charge->date = $validatedData['date'];
    $charge->status = $validatedData['status'];

    // Obtenir la première année à partir de la valeur de l'input "annee"
    $annee = $validatedData['annee'];
    $premiereAnnee = substr($annee, 0, 4);
    $charge->annee = $premiereAnnee;

    if ($request->hasFile('recus')) {
        $file = $request->file('recus');
        $fileName = time() . '_' . $file->getClientOriginalName();
        // Enregistrer le fichier dans le stockage public
        $file->move('uploads/charges/', $fileName);
        // Enregistrer le chemin d'accès au fichier dans la base de données
        $charge->recus = $fileName;
    }

    $charge->save();

    return back()->with('success', 'La charge a été ajoutée avec succès.');
}



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Charge  $charge
     * @return \Illuminate\Http\Response
     */
    public function show(Charge $charge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Charge  $charge
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $charge = Charge::findOrFail($id);
        return view('charges.edit', compact('charge'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Charge  $charge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Valider les données soumises par le formulaire
        $validatedData = $request->validate([
            'rubrique' => 'required',
            'description' => 'required',
            'montant' => 'required|numeric',
            'type' => 'required',
            'date' => 'required|date',
            'status' => 'required',
            'annee' => 'required',
        ]);

        // Récupérer la charge à mettre à jour depuis la base de données
        $charge = Charge::findOrFail($id);

        // Mettre à jour les données de la charge
        $charge->rubrique = $validatedData['rubrique'];
        $charge->description = $validatedData['description'];
        $charge->montant = $validatedData['montant'];
        $charge->type = $validatedData['type'];
        $charge->date = $validatedData['date'];
        $charge->status = $validatedData['status'];

        // Obtenir la première année à partir de la valeur de l'input "annee"
        $annee = $validatedData['annee'];
        $premiereAnnee = substr($annee, 0, 4);
        $charge->annee = $premiereAnnee;

        if ($request->hasFile('recus')) {
            $file = $request->file('recus');
            $fileName = time() . '_' . $file->getClientOriginalName();
            // Enregistrer le fichier dans le stockage public
            $file->move('uploads/charges/', $fileName);
            // Enregistrer le chemin d'accès au fichier dans la base de données
            $charge->recus = $fileName;
        }

        $charge->save();

        return redirect()->route('charges.index')->with('successedit', 'La charge a été mise à jour avec succès.');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Charge  $charge
     * @return \Illuminate\Http\Response
     */
    public function destroy(Charge $charge)
{
    $charge->delete();

    return redirect()->route('charges.index')->with('successdelete', 'Charge supprimée avec succès.');
}
}
