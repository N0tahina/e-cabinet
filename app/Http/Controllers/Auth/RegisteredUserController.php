<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Affiche la vue d'inscription.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Gère la soumission du formulaire d'inscription.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation des données reçues
        $request->validate([
            'nom' => ['required', 'string', 'max:255', 'unique:users,nom'],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'mot_de_passe' => ['required', 'confirmed', 'min:8'], // minimum 8 caractères
        ]);

        // Création de l'utilisateur
        $user = User::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'mot_de_passe' => Hash::make($request->mot_de_passe),
        ]);

        // Déclenchement de l'événement "Registered" (utile si tu veux envoyer un email de bienvenue)
        event(new Registered($user));

        // Connexion automatique de l'utilisateur après inscription
        Auth::login($user);

        // Redirection vers le tableau de bord
        return redirect()->route('dashboard');
    }
}