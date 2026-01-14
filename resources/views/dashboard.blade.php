@extends('layouts.app')

    @section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Message de bienvenue -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2">Bienvenue 👋</h3>
                <p class="text-gray-700">
                    Vous êtes connecté à votre espace patient.  
                    Ici, vous pourrez bientôt :
                </p>

                <ul class="list-disc list-inside mt-3 text-gray-700">
                    <li>Demander un rendez-vous</li>
                    <li>Voir vos rendez-vous</li>
                    <li>Consulter l’historique</li>
                </ul>
            </div>

            <!-- Demande de rendez-vous -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-3">📅 Demande de rendez-vous</h3>

                <p class="text-gray-700 mb-4">
                    Cliquez ci-dessous pour envoyer une demande de rendez-vous à un dentiste.
                </p>

                <a href="#" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Demander un rendez-vous
                </a>
            </div>

            <!-- Mes demandes -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-3">📝 Mes demandes</h3>

                <p class="text-gray-500 italic">
                    Aucune demande pour le moment.
                </p>
            </div>

            <!-- Déconnexion -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline">
                        Se déconnecter
                    </button>
                </form>
            </div>

        </div>
    </div>
    @endsection
