@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

    @section('content')
    <main class="site-main">

    <section aria-labelledby="welcome" class="section">
        <header>
        <h2 id="welcome">Bienvenue 👋</h2>
        </header>

        <p>
        Bienvenue dans votre espace patient.  
        Vous pouvez ici gérer vos demandes de rendez-vous.
        </p>
    </section>

    <section aria-labelledby="appointment" class="section">
        <header>
        <h2 id="appointment">📅 Demande de rendez-vous</h2>
        </header>

        <p>
        Cliquez ci-dessous pour envoyer une demande à un dentiste.
        </p>

        <a href="#" class="btn btn-primary">
        Demander un rendez-vous
        </a>
    </section>

    <section aria-labelledby="history" class="section">
        <header>
        <h2 id="history">📝 Mes demandes</h2>
        </header>

        <p class="empty-state">
        Aucune demande pour le moment.
        </p>
    </section>

    </main>

    @endsection
