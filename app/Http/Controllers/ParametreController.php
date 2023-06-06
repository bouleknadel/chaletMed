<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bureau;
use App\Models\CoordoneeBanque;




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

public function listeMembres()
{
    // Récupérer la liste des membres du bureau exécutif depuis une source de données (par exemple, une base de données)
    $membres = Bureau::all();

    // Retourner la vue avec la liste des membres
    return view('parametre.listeMembres', compact('membres'));
}



public function autre()
{
    return view('parametre.Autre');
}




public function storeCoordonee(Request $request)
{
   // Valider les données du formulaire
   $validatedData = $request->validate([
    'numero_compte' => 'required',
    'raison_sociale' => 'required',
    'ville' => 'required',
    'banque' => 'required',
    'status' => 'boolean',
]);

// Création d'une nouvelle coordonnée bancaire
$coordoneeBanque = new CoordoneeBanque();
$coordoneeBanque->numero_compte = $validatedData['numero_compte'];
$coordoneeBanque->raison_sociale = $validatedData['raison_sociale'];
$coordoneeBanque->ville = $validatedData['ville'];
$coordoneeBanque->banque = $validatedData['banque'];
$coordoneeBanque->status = $validatedData['status'];

// Traitement du fichier logo
if ($request->hasFile('logo')) {
    $logo = $request->file('logo');
    $logoName = time() . '_' . $logo->getClientOriginalName();
    // Enregistrer le fichier dans le stockage public
    $logo->move('uploads/photos', $logoName);
    // Enregistrer le chemin d'accès au fichier dans la base de données
    $coordoneeBanque->logo = $logoName;
}
$coordoneeBanque->save();

    // Effectuez d'autres opérations si nécessaire
    return redirect()->back()->with('success', 'Coordonnées bancaires enregistrées avec succès.');
}
public function coordoneeBanqueUpdate(Request $request, $id)
{
    // Validation des données du formulaire
    $validatedData = $request->validate([
        'numero_compte' => 'required',
        'raison_sociale' => 'required',
        'ville' => 'required',
        'banque' => 'required',
        'status' => 'boolean',
    ]);

    // Recherche de la coordonnée bancaire à mettre à jour
    $coordoneeBanque = CoordoneeBanque::findOrFail($id);

    // Mise à jour des champs de la coordonnée bancaire
    $coordoneeBanque->numero_compte = $validatedData['numero_compte'];
    $coordoneeBanque->raison_sociale = $validatedData['raison_sociale'];
    $coordoneeBanque->ville = $validatedData['ville'];
    $coordoneeBanque->banque = $validatedData['banque'];
    $coordoneeBanque->status = $validatedData['status'];

    if ($request->hasFile('logo')) {
        $logo = $request->file('logo');
        $logoName = time() . '_' . $logo->getClientOriginalName();
        // Enregistrer le fichier dans le stockage public
        $logo->move('uploads/photos', $logoName);
        // Enregistrer le chemin d'accès au fichier dans la base de données
        $coordoneeBanque->logo = $logoName;
    }

    // Enregistrement des modifications
    $coordoneeBanque->save();

    // Redirection vers la page appropriée avec un message de succès
    return redirect()->route('parametre.autre')->with('successedit', 'Coordonnée bancaire mise à jour avec succès.');
}


public function coordoneeBanqueDestroy($id)
{
    $coordoneeBanque = CoordoneeBanque::findOrFail($id);
    $coordoneeBanque->delete();

    return redirect()->route('parametre.autre')->with('success', 'Coordonnée bancaire supprimée avec succès');
}







public function storeBureau(Request $request)
{
    // Valider les données du formulaire
    $validatedData = $request->validate([
        'photo' => 'image|max:2048',
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

    // Traitement du fichier carte d'identité
    if ($request->hasFile('carte_identite')) {
        $carteIdentite = $request->file('carte_identite');
        $carteIdentiteName = time() . '_' . $carteIdentite->getClientOriginalName();
        // Enregistrer le fichier dans le stockage public
        $carteIdentite->move('uploads/carte_identite', $carteIdentiteName);
        // Enregistrer le chemin d'accès au fichier dans la base de données
        $membre->carte_identite = $carteIdentiteName;
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
    if ($request->hasFile('carte_identite')) {
        $carteIdentite = $request->file('carte_identite');
        $carteIdentiteName = time() . '_' . $carteIdentite->getClientOriginalName();
        // Enregistrer le fichier dans le stockage public
        $carteIdentite->move('uploads/carte_identite', $carteIdentiteName);
        // Enregistrer le chemin d'accès au fichier dans la base de données
        $membre->carte_identite = $carteIdentiteName;
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
