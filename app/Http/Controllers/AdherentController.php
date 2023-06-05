<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cotisation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\NotificationMsj;



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
    $current_year = date('Y'); // Année en cours
    $current_month = date('n'); // Mois actuel (1-12)
    $current_day = date('j'); // Jour actuel (1-31)

    if ($current_month >= 1 && $current_month <= 7 && $current_day <= 31) {
        $current_year--; // Si la date est entre le 1er janvier et le 31 juillet, réduire l'année en cours de 1
    }

    // Récupérer tous les utilisateurs qui ont le rôle "user"
    $users = User::where('role', 'user')->get();

    // Récupérer toutes les cotisations avec les informations utilisateur correspondantes
    $cotisations = Cotisation::with('user');

    // Appliquer les filtres si des valeurs sont présentes dans la requête
    $selectedYear = request('year');
    $selectedLetter = request('letter');
    $selectedStatus = request('status');

    if ($selectedYear) {
        $cotisations->where('annee', $selectedYear);
    }

    if ($selectedLetter) {
        $cotisations->whereHas('user', function ($query) use ($selectedLetter) {
            $query->where('numero_devilla', 'like', $selectedLetter . '%');
        });
    }

    if ($selectedStatus) {
        $cotisations->where('status', $selectedStatus);
    }

    $cotisations = $cotisations->get();

    return view('adherent.dashboard', compact('users', 'cotisations', 'current_year', 'selectedYear', 'selectedLetter', 'selectedStatus'));
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
            'annee' => 'required',
            'date' => 'nullable|date',
            'recu_paiement' => 'nullable|file',
        ]);

        $annee = substr($validatedData['annee'], 0, 4); // Extrait les 4 premiers caractères (l'année) du format '2018/2019'

        // Vérifier si une cotisation pour cette année existe déjà
        if (Cotisation::where('user_id', Auth::user()->id)->where('annee', $annee)->exists()) {
            return redirect()->back()->with('error', 'Une cotisation pour cette année existe déjà.');
        }

        $cotisation = new Cotisation;
        $cotisation->montant = $validatedData['montant'];
        $cotisation->date = $validatedData['date'];
        $cotisation->annee = $annee;
        $cotisation->user_id = Auth::user()->id;

        if ($request->hasFile('recu_paiement')) {
            $file = $request->file('recu_paiement');
            $fileName = time() . '_' . $file->getClientOriginalName();
            // Enregistrer le fichier dans le stockage public
            $file->move('uploads/recus/', $fileName);
            // Enregistrer le chemin d'accès au fichier dans la base de données
            $cotisation->recu_paiement = $fileName;
        }

        // Enregistrement de la cotisation dans la base de données
        $cotisation->save();


            $notification = new NotificationMsj;
            $notification->cotisation_id = $cotisation->id;
            $notification->user_id = Auth::user()->id;
            $notification->content = 'Nouvelle cotisation ajoutée par ' . Auth::user()->lastname . ' ' . Auth::user()->name;
            $notification->save();


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
            'annee' => 'required',
            'recu_paiement' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:2048',
        ]);

        // Vérifier si une cotisation pour cette année existe déjà
        $annee = substr($validatedData['annee'], 0, 4); // Extrait les 4 premiers caractères (l'année) du format '2018/2019'
        if (Cotisation::where('user_id', Auth::user()->id)->where('annee', $annee)->exists()) {
            return redirect()->back()->with('error', 'Une cotisation pour cette année existe déjà.');
        }

        $cotisation->montant = $validatedData['montant'];
        $cotisation->annee = $annee;

        if ($request->hasFile('recu_paiement')) {
            $file = $request->file('recu_paiement');
            $fileName = time() . '_' . $file->getClientOriginalName();
            // Enregistrer le fichier dans le stockage public
            $file->move('uploads/recus/', $fileName);
            // Enregistrer le chemin d'accès au fichier dans la base de données
            $cotisation->recu_paiement = $fileName;
        }

        $cotisation->save();




        return redirect()->back()->with('successedit', 'Cotisation mise à jour avec succès.');
    }


public function markAsRead(Request $request, $id)
{
    // Récupérer la notification correspondante
    $notification = NotificationMsj::findOrFail($id);

    // Mettre à jour la colonne "read" de la notification à true
    $notification->read = true;
    $notification->save();
    return redirect()->back() ;
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
