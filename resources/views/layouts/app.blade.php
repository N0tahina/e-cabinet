<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E-Cabi-net') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col">

        <!-- Navigation -->
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between h-16 items-center">
                <div class="flex items-center space-x-2">
                    <span class="text-2xl font-bold text-blue-600">🦷 E-Cabi-net</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('rendez-vous.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Rendez-vous</a>
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium">Connexion</a>
                        <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600 font-medium">Inscription</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium">Dashboard</a>
                        <span class="text-gray-700">Bonjour, {{ Auth::user()->nom }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Déconnexion</button>
                        </form>
                    @endguest
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="flex-grow">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-blue-600 text-white py-4 mt-12 text-center">
            &copy; {{ date('Y') }} E-Cabi-net. Tous droits réservés.
        </footer>
    </div>

    @yield('scripts')
</body>
</html>