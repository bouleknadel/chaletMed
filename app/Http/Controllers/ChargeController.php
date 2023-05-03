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
    public function index()
{
    $charges = Charge::all();
    return view('charges.index', compact('charges'));
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
        ]);

        // Stocker les données dans la base de données
        $charge = new Charge();
        $charge->rubrique = $validatedData['rubrique'];
        $charge->description = $validatedData['description'];
        $charge->montant = $validatedData['montant'];
        $charge->type = $validatedData['type'];
        $charge->date = $validatedData['date'];
        $charge->status = $validatedData['status'];

        if ($request->hasFile('recus')) {
            $file = $request->file('recus');
            $fileName = time() . '_' . $file->getClientOriginalName();
            // Enregistrer le fichier dans le stockage public
            $file->move('uploads/charges/',$fileName) ;
            // Enregistrer le chemin d'accès au fichier dans la base de données
            $charge->recus = $fileName;
        }

        $charge->save();

        return back()->with('success', '  La charge a été ajoutée avec succès.');
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

    if ($request->hasFile('recus')) {
        $file = $request->file('recus');
        $fileName = time() . '_' . $file->getClientOriginalName();
        // Enregistrer le fichier dans le stockage public
        $file->move('uploads/charges/',$fileName) ;
        // Enregistrer le chemin d'accès au fichier dans la base de données
        $charge->recus = $fileName;
    }

    $charge->save();

    return redirect()->route('charges.index')->with('successedit', '  La charge a été mise à jour avec succès.');
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
