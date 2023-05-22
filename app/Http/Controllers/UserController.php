<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // ajout de l'importation de la classe User
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('listeAdherent', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     return view('addUser');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    // Validation des champs du formulaire
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'numero_devilla' => 'required|string|max:255',
        'numero_de_telephone' => 'required|string|max:255',
        'numero_de_telephone2' => 'nullable|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'role' => 'string',
    ]);

    // Création d'un nouvel utilisateur avec les données du formulaire
    $user = User::create([
        'name' => $validatedData['name'],
        'lastname' => $validatedData['lastname'],
        'numero_devilla' => $validatedData['numero_devilla'],
        'numero_de_telephone' => $validatedData['numero_de_telephone'],
        'numero_de_telephone2' => $validatedData['numero_de_telephone2'],
        'email' => $validatedData['email'],
        'role' => $validatedData['role'],
        'password' => Hash::make($validatedData['password']),

    ]);

    // Redirection vers la page de l'utilisateur nouvellement créé
    return back()->with('success', 'Utilisateur ajouté avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return "added succecfuly" ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('editUser', compact('user'));
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
    $validatedData = $request->validate([
        'name' => 'required|max:255',
        'lastname' => 'required|max:255',
        'numero_devilla' => 'required|max:255',
        'numero_de_telephone' => 'required|max:255',
        'numero_de_telephone2' => 'max:255',
        'email' => 'required|email|max:255|unique:users,email,'.$id,
        'password' => 'nullable|min:8|max:255',
        'role' => 'string',
    ]);

    $user = User::findOrFail($id);

    $user->name = $validatedData['name'];
    $user->lastname = $validatedData['lastname'];
    $user->numero_devilla = $validatedData['numero_devilla'];
    $user->numero_de_telephone = $validatedData['numero_de_telephone'];
    $user->numero_de_telephone2 = $validatedData['numero_de_telephone2'];
    $user->email = $validatedData['email'];
    $user->role = $validatedData['role'];




    if (!empty($validatedData['password'])) {
        $user->password = Hash::make($validatedData['password']);
    }

    $user->save();

    return redirect()->route('users.index')->with('successedit', 'Utilisateur mis à jour avec succès.');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('users.index')->with('successdelete', 'Utilisateur supprimé avec succès.');
}
}
