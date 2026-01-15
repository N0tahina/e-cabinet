<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Espace Dentiste')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS spécifique dentiste -->
    <link rel="stylesheet" href="{{ asset('css/dentiste-layout.css') }}">
</head>
<body class="dentiste-layout">

<div class="layout-container">

    <!-- Sidebar -->
    <aside class="sidebar">
        <h2 class="logo">Cabinet</h2>

        <nav class="menu">
            <a href="{{ route('dentiste.dashboard') }}" class="{{ request()->routeIs('dentiste.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('dentiste.rendezvous') ?? '#' }}">
                Rendez-vous
            </a>
            <a href="#">
                Patients
            </a>
            <a href="#">
                Horaires
            </a>
            <a href="#">
                Profil
            </a>
        </nav>

        <form method="POST" action="{{ route('dentiste.logout') }}">
            @csrf
            <button class="logout-btn">Déconnexion</button>
        </form>
    </aside>

    <!-- Main Content -->
    <main class="main-content">

        <header class="top-bar">
            <h1>@yield('page-title', 'Espace Dentiste')</h1>
            <p>@yield('page-subtitle', 'Bienvenue dans votre tableau de bord')</p>
        </header>

        <!-- Page Content -->
        <section class="page-content">
            @yield('content')
        </section>

    </main>

</div>

</body>
</html>