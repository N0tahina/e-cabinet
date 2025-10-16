<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Models\Dentiste;
use App\Models\RendezVous;


class RendezVousController extends Controller
{
    public function index(Request $request)
    {
        $dentistes = Dentiste::all(); // liste des dentistes

        // Si un dentiste est choisi, sinon on prend le premier
        $selectedDentisteId = $request->dentiste_id ?? ($dentistes->first()->id ?? null);

        $rendezvous = [];

        if ($selectedDentisteId) {
            $rendezvous = RendezVous::where('dentiste_id', $selectedDentisteId)
                ->get()
                ->map(function($r) {
                    $color = match($r->statut) {
                        0 => '#facc15', // Jaune (en attente)
                        1 => '#22c55e', // Vert (validé)
                        2 => '#ef4444', // Rouge (refusé)
                        default => '#3b82f6',
                    };

                    return [
                        'title' => match($r->statut) {
                            0 => 'En attente',
                            1 => 'Validé',
                            2 => 'Refusé',
                            default => 'Rendez-vous'
                        },
                        'start' => $r->date_heure,
                        'color' => $color,
                    ];
                });
        }

        return view('rendez_vous.index', compact('dentistes', 'rendezvous', 'selectedDentisteId'));
    }

    public function store(Request $request)
    {
        
        // Log initial
        \Log::debug('🟢 [RendezVousController@store] Début du traitement', [
            'ip' => $request->ip(),
            'input' => $request->all()
        ]);

        // Vérifie l'authentification
        if (!auth()->check()) {
            \Log::warning('🔒 Utilisateur non authentifié');
            return back()->withErrors(['auth' => 'Veuillez vous connecter pour réserver.'])->withInput();
        }

        // Récupérer le fuseau horaire client (par défaut : UTC)
        $clientTz = $request->input('timezone', 'UTC');

        // Normaliser la date reçue (datetime-local → string)
        $rawDate = str_replace('T', ' ', $request->input('date_heure'));
        \Log::debug('🕓 Valeur brute normalisée', ['raw' => $rawDate, 'tz_client' => $clientTz]);

        try {
            // Convertir la date locale vers UTC
            $localDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $rawDate, $clientTz);
            $utcDate = $localDate->clone()->setTimezone('UTC');

            \Log::debug('🌍 Conversion fuseau horaire', [
                'local_date' => $localDate->toDateTimeString(),
                'utc_date' => $utcDate->toDateTimeString(),
                'client_tz' => $clientTz,
                'server_tz' => date_default_timezone_get()
            ]);
        } catch (\Exception $e) {
            \Log::error('❌ Erreur de conversion fuseau', ['message' => $e->getMessage()]);
            return back()->withErrors(['date_heure' => 'Format de date invalide.'])->withInput();
        }

        // Validation
        $validator = \Validator::make([
            'dentiste_id' => $request->dentiste_id,
            'date_heure' => $utcDate, // On valide directement en UTC
            'commentaire' => $request->commentaire,
        ], [
            'dentiste_id' => 'required|exists:dentiste,id',
            'date_heure' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $nowUtc = \Carbon\Carbon::now('UTC');
                    if (\Carbon\Carbon::parse($value)->lte($nowUtc)) {
                        $fail('La date et l’heure doivent être ultérieures à maintenant.');
                    }
                }
            ],
            'commentaire' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            \Log::warning('⚠️ Erreur validation', ['errors' => $validator->errors()->toArray()]);
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        \Log::info('✅ Validation réussie', ['validated' => $validated]);

        // Création du rendez-vous
        try {
            $rdv = \App\Models\RendezVous::create([
                'user_id' => auth()->user()?->id,
                'dentiste_id' => $validated['dentiste_id'],
                'date_heure' => $validated['date_heure'], // en UTC
                'statut' => 0,
                'commentaire' => $validated['commentaire'] ?? null,
            ]);

            \Log::info('📅 Rendez-vous créé', [
                'user' => auth()->user()->name ?? auth()->id(),
                'dentiste_id' => $validated['dentiste_id'],
                'stored_utc' => $validated['date_heure']
            ]);

            return redirect()->route('rendez-vous.index')->with('success', 'Demande de Rendez-vous soumis !');
        } catch (\Exception $e) {
            \Log::error('💥 Erreur lors de la création de la demande', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['store' => 'Erreur interne : '.$e->getMessage()])->withInput();
        }
    }

}