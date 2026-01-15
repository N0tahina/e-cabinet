<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Afficher la vue de connexion
     */
    public function create(): View
    {
        return view('auth.login');
    }

    public function createDentiste(): View
    {
        return view('auth-dentiste.login');
    }

    /**
     * Gérer une tentative de connexion.
     */
    public function store(LoginRequest $request)
    {
        // 🔍 Debug initial
        Log::info('Tentative de connexion détectée', [
            'nom' => $request->nom,
            'has_redirect' => $request->filled('after_login_redirect'),
        ]);

        // Sauvegarde la redirection demandée (si elle existe)
        if ($request->filled('after_login_redirect')) {
            $request->session()->put('after_login_redirect', $request->input('after_login_redirect'));
            Log::info('Redirection post-login sauvegardée', [
                'redirect' => $request->input('after_login_redirect')
            ]);
        }

        // Authentification
        $typedNom = $request->nom;
        $typedPassword = $request->mot_de_passe;

        $user = User::where('nom', $typedNom)->first();

        if (!$user) {
            Log::warning('Échec de connexion : utilisateur introuvable', ['nom' => $typedNom]);
            return $this->failedResponse($request, 'Nom d’utilisateur introuvable.');
        }

        if (!Hash::check($typedPassword, $user->mot_de_passe)) {
            Log::warning('Échec de connexion : mot de passe incorrect', ['nom' => $typedNom]);
            return $this->failedResponse($request, 'Mot de passe incorrect.');
        }

        if (Auth::attempt(['nom' => $typedNom, 'password' => $typedPassword], $request->filled('remember'))) {
            $request->session()->regenerate();

            // ✅ Journalisation de la connexion
            Log::info('Connexion réussie', ['user_id' => $user->id, 'nom' => $user->nom]);

            // 🔁 Si redirection personnalisée
            if ($redirect = $request->session()->pull('after_login_redirect')) {
                Log::info('Redirection post-login appliquée', ['redirect' => $redirect]);
                return $this->successfulResponse($request, $redirect);
            }

            // ✅ Redirection par défaut
            return $this->successfulResponse($request, '/dashboard');
        }

        Log::warning('Échec de connexion : tentative échouée sans raison claire', ['nom' => $typedNom]);
        return $this->failedResponse($request, 'Les identifiants sont incorrects.');
    }

    /**
     * Réponse réussie (HTML ou JSON)
     */
    private function successfulResponse(Request $request, string $redirect)
    {
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'redirect' => $redirect]);
        }
        return redirect()->intended($redirect);
    }

    /**
     * Réponse échouée (HTML ou JSON)
     */
    private function failedResponse(Request $request, string $message)
    {
        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'message' => $message], 401);
        }
        return back()->withErrors(['nom' => $message]);
    }

    /**
     * Déconnecter l'utilisateur.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();
        Log::info('Déconnexion utilisateur', ['user_id' => $user?->id, 'nom' => $user?->nom]);

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}