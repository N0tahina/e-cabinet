<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login-store') }}">
        @csrf

        <!-- Nom -->
        <div>
            <x-input-label for="nom" :value="__('Nom')" />
            <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom"
                :value="old('nom')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('nom')" class="mt-2" />
        </div>

        <!-- Mot de passe -->
        <div class="mt-4">
            <x-input-label for="mot_de_passe" :value="__('Mot de passe')" />

            <x-text-input id="mot_de_passe" class="block mt-1 w-full"
                type="password"
                name="mot_de_passe"
                required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('mot_de_passe')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                   href="{{ route('password.request') }}">
                    {{ __('Mot de passe oublié ?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Se connecter') }}
            </x-primary-button>
        </div>

        {{-- Script de gestion de redirection après login --}}
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                try {
                    const redirect = localStorage.getItem('after_login_redirect');
                    if (redirect && redirect.startsWith('/')) { // sécurité : on accepte uniquement les chemins internes
                        const form = document.querySelector('form');
                        if (form) {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'after_login_redirect';
                            input.value = redirect;
                            form.appendChild(input);
                        }
                        console.log('✅ Redirection après login détectée :', redirect);
                        localStorage.removeItem('after_login_redirect');
                    } else if (redirect) {
                        console.warn('⚠️ Redirection ignorée (chemin invalide) :', redirect);
                        localStorage.removeItem('after_login_redirect');
                    }
                } catch (e) {
                    console.error('Erreur dans la gestion de redirection après login :', e);
                }
            });
        </script>

    </form>
</x-guest-layout>