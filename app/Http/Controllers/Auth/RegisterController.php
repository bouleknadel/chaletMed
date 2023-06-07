<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'numero_devilla' => ['required', 'string', 'max:255', 'unique:users'],
            'numero_de_telephone' => ['required', 'string', 'max:255', 'unique:users'],
            'numero_de_telephone2' => ['required', 'nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Le champ Prenom est obligatoire.',
            'name.string' => 'Le champ Prenom doit contenir des caractères valides.',
            'name.max' => 'Le champ Prenom ne doit pas dépasser 255 caractères.',

            'lastname.required' => 'Le champ nom est obligatoire.',
            'lastname.string' => 'Le champ nom doit contenir des caractères valides.',
            'lastname.max' => 'Le champ nom ne doit pas dépasser 255 caractères.',

            'numero_devilla.required' => 'Le champ Numéro de villa est obligatoire.',
            'numero_devilla.string' => 'Le champ Numéro de villa doit contenir des caractères valides.',
            'numero_devilla.max' => 'Le champ Numéro de villa ne doit pas dépasser 255 caractères.',
            'numero_devilla.unique' => 'Le numéro de villa existe déjà dans notre base de données.',

            'numero_de_telephone.required' => 'Le champ Numéro de téléphone est obligatoire.',
            'numero_de_telephone.string' => 'Le champ Numéro de téléphone doit contenir des caractères valides.',
            'numero_de_telephone.max' => 'Le champ Numéro de téléphone ne doit pas dépasser 255 caractères.',
            'numero_de_telephone.unique' => 'Le numéro de téléphone existe déjà dans notre base de données.',

            'numero_de_telephone2.string' => 'Le champ Numéro de téléphone 2 doit contenir des caractères valides.',
            'numero_de_telephone2.max' => 'Le champ Numéro de téléphone 2 ne doit pas dépasser 255 caractères.',
            'numero_de_telephone2.required' => 'Le champ Numéro de téléphone 2 est obligatoire.',

            'email.required' => 'Le champ email est obligatoire.',
            'email.string' => 'Le champ email doit être une chaîne de caractères.',
            'email.email' => 'Le champ email doit être une adresse email valide.',
            'email.max' => 'Le champ email ne doit pas dépasser :max caractères.',
            'email.unique' => 'Cet email existe déjà dans notre base de données.',

            'password.required' => 'Le champ mot de passe est obligatoire.',
            'password.string' => 'Le champ mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le champ mot de passe doit contenir au moins :min caractères.',
            'password.confirmed' => 'Le champ mot de passe et sa confirmation ne correspondent pas.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'numero_devilla' => $data['numero_devilla'],
            'numero_de_telephone' => $data['numero_de_telephone'],
            'numero_de_telephone2' => $data['numero_de_telephone2'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
