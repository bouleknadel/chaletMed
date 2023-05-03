<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // ajout de l'importation de la classe User

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('listeAdherent', compact('users'));
    }
}
