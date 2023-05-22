<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bureau;



class ParametreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function bureau()
{
    return view('parametre.bureau');
}


public function storeBureau(Request $request)
{
    // Valider les données du formulaire
    $validatedData = $request->validate([
        'nom' => 'required|string',
        'fonction' => 'required|string',
    ]);

     // Création d'un nouveau membre du bureau exécutif
     $membre = new Bureau();
     $membre->nom = $validatedData['nom'];
     $membre->fonction = $validatedData['fonction'];

    // Traitement du fichier photo
    if ($request->hasFile('photo')) {
        $photo = $request->file('photo');
        $photoName = time() . '_' . $photo->getClientOriginalName();
        // Enregistrer le fichier dans le stockage public
        $photo->move('uploads/photos', $photoName);
        // Enregistrer le chemin d'accès au fichier dans la base de données
        $membre->photo = $photoName;
    }


    $membre->save();

    // Redirection vers une autre page avec un message de succès
    return redirect()->back()->with('success', 'Membre du bureau exécutif ajouté avec succès.');
}


public function updateBureau(Request $request, $id)
{
    // Validation des données entrées par l'utilisateur
    $validatedData = $request->validate([
        'photo' => 'image|max:2048', // Validation pour les images (optionnel)
        'nom' => 'required|string',
        'fonction' => 'required|string',
    ]);
    // Récupérer le membre du bureau à mettre à jour
    $membre = Bureau::findOrFail($id);

    // Mettre à jour les attributs du membre du bureau
    if ($request->hasFile('photo')) {
        // Gérer le téléchargement de la nouvelle photo
        $photo = $request->file('photo');
        $photoName = time() . '_' . $photo->getClientOriginalName();
        $photo->move(public_path('uploads/photos'), $photoName);
        // Supprimer l'ancienne photo s'il y en a une
        if ($membre->photo) {
            unlink(public_path('uploads/photos/' . $membre->photo));
        }
        $membre->photo = $photoName;
    }
    $membre->nom = $request->input('nom');
    $membre->fonction = $request->input('fonction');
    // Sauvegarder les modifications du membre du bureau
    $membre->save();
    // Rediriger l'utilisateur ou effectuer d'autres actions selon vos besoins
    return redirect()->back()->with('successedit', 'Les informations ont été mises à jour avec succès.');
}

public function destroyBureau($id)
{
    try {
        $membre = Bureau::findOrFail($id);
        $membre->delete();
        return redirect()->back()->with('success', 'Le membre a été supprimé avec succès.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Une erreur s\'est produite lors de la suppression du membre.');
    }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
