<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AnneeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $annees = Annee::all();
        return view('annees.index', compact('annees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('annees.create');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'annee' => 'required|digits:4|unique:annees,annee',
            'prix_location' => 'required|numeric|min:0',
        ]);

        $annee = new Annee();
        $annee->annee = $request->annee;
        $annee->prix_location = $request->prix_location;
        $annee->save();

        return redirect()->route('annees.index')->with('success', 'Année ajoutée avec succès.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Annee  $annee
     * @return \Illuminate\Http\Response
     */
    public function show(Annee $annee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Annee  $annee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $annee = Annee::findOrFail($id); // Récupérer l'année correspondant à l'id fourni
        return view('annees.edit', compact('annee')); // Retourner la vue "edit" avec l'année récupérée
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Annee  $annee
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, $id)
{
    $annee = Annee::findOrFail($id);
    $annee->annee = $request->input('annee');
    $annee->prix_location = $request->input('prix_location');
    $annee->save();

    return redirect()->route('annees.index')->with('success', 'Année modifiée avec succès');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Annee  $annee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $annee = Annee::findOrFail($id);
    $annee->delete();

    return redirect()->route('annees.index')->with('successdelete', 'Année supprimée avec succès');
}

}
