<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Cabi-net | Accueil</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            color: #2e3b4e;
            background-color: #f7f9fb;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #0077b6, #0096c7);
            color: white;
            padding: 2rem 0 6rem;
            text-align: center;
            position: relative;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 1.5rem;
            margin: 0;
            padding: 0;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.3s ease;
        }

        .nav-links a:hover {
            opacity: 0.8;
        }

        /* Hero section */
        .hero {
            margin-top: 2rem;
        }

        .hero h1 {
            font-size: 2.8rem;
            margin-bottom: 1rem;
        }

        .hero span {
            color: #caf0f8;
        }

        .hero p {
            max-width: 600px;
            margin: 0 auto 2rem;
            line-height: 1.6;
            font-weight: 300;
        }

        .btn {
            background-color: #00b4d8;
            color: white;
            padding: 0.8rem 1.8rem;
            border: none;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #0096c7;
        }

        /* Features */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            max-width: 1100px;
            margin: -3rem auto 5rem;
            padding: 0 1.5rem;
        }

        .feature-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            transition: all 0.3s ease;
            cursor: pointer;
            text-align: center;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
        }

        .feature-card h2 {
            margin-bottom: 0.8rem;
            color: #0077b6;
        }

        .feature-card p {
            color: #4a5568;
            font-size: 0.95rem;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(30, 30, 30, 0.55);
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(4px);
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            width: 90%;
            max-width: 400px;
            position: relative;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .close {
            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 1.2rem;
            cursor: pointer;
            color: #777;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.3rem;
        }

        .input-field {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 0.95rem;
        }

        .input-field:focus {
            border-color: #0096c7;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 150, 199, 0.2);
        }

        .footer {
            text-align: center;
            padding: 2rem 0;
            background-color: #f1f5f9;
            color: #555;
            font-size: 0.9rem;
            border-top: 1px solid #e5e7eb;
        }

        .error {
            color: red;
            font-size: 0.85rem;
        }
    </style>
</head>
<body data-auth="{{ auth()->check() ? 'true' : 'false' }}">
    <header class="header">
        <nav class="navbar">
            <div class="logo">🦷 <span style="color:#caf0f8;">E-Cabi-net</span></div>
            <ul class="nav-links">
                @auth
                    <li><a href="{{ route('dashboard') }}">Mon compte</a></li>
                    <li><a href="{{ route('logout') }}">Déconnexion</a></li>
                @else
                    <li><a href="{{ route('login') }}">Connexion</a></li>
                    <li><a href="{{ route('register') }}">Inscription</a></li>
                @endauth
            </ul>
        </nav>
        <div class="hero">
            <h1>Bienvenue sur <span>E-Cabi-net</span></h1>
            <p>Votre cabinet dentaire en ligne : réservez vos rendez-vous en toute simplicité et en toute sécurité.</p>
            <a href="{{ route('register') }}" class="btn">Prendre rendez-vous</a>
        </div>
    </header>

    <section class="features">
        <div class="feature-card clickable-card" data-href="{{ route('rendez-vous.index') }}">
            <h2>📅 Rendez-vous en ligne</h2>
            <p>Réservez un créneau selon vos disponibilités, en quelques clics.</p>
        </div>
        <div class="feature-card">
            <h2>👨‍⚕️ Suivi personnalisé</h2>
            <p>Chaque patient bénéficie d’un suivi complet et professionnel.</p>
        </div>
        <div class="feature-card">
            <h2>🔒 Sécurité & Confiance</h2>
            <p>Vos données sont protégées avec un haut niveau de confidentialité.</p>
        </div>
    </section>

    <!-- Modal -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Connexion requise</h2>
            <p>Veuillez vous connecter pour continuer.</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="hidden" name="after_login_redirect" id="after_login_redirect">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input id="nom" type="text" name="nom" required class="input-field">
                    @error('nom') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="mot_de_passe">Mot de passe</label>
                    <input id="mot_de_passe" type="password" name="mot_de_passe" required class="input-field">
                    @error('mot_de_passe') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label><input type="checkbox" name="remember"> Se souvenir de moi</label>
                </div>
                <button type="submit" class="btn">Se connecter</button>
            </form>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} E-Cabi-net. Tous droits réservés.</p>
    </footer>

    <script>
        window.isAuthenticated = @json(Auth::check());

        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('loginModal');
            const closeModal = modal.querySelector('.close');
            const form = modal.querySelector('form');
            const redirectInput = document.getElementById('after_login_redirect');

            document.querySelectorAll('.clickable-card').forEach(card => {
                card.addEventListener('click', function() {
                    const destination = this.dataset.href;

                    // ✅ Si déjà connecté → redirection directe
                    if (window.isAuthenticated) {
                        window.location.href = destination;
                        return;
                    }

                    // 🚪 Sinon → ouvre le modal et prépare la redirection
                    localStorage.setItem('after_login_redirect', destination);
                    redirectInput.value = destination;
                    modal.style.display = 'flex';
                });
            });

            closeModal.addEventListener('click', () => modal.style.display = 'none');
            window.addEventListener('click', (e) => {
                if (e.target === modal) modal.style.display = 'none';
            });

            // Soumission du login via fetch
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': formData.get('_token')
                    },
                    body: formData
                })
                .then(async res => {
                    if (res.ok) {
                        const redirect = localStorage.getItem('after_login_redirect') || "{{ route('dashboard') }}";
                        localStorage.removeItem('after_login_redirect');
                        window.location.href = redirect;
                    } else {
                        const data = await res.json();
                        alert(data.message || "Identifiants incorrects. Veuillez réessayer.");
                    }
                })
                .catch(err => {
                    console.error("Erreur login:", err);
                    alert("Une erreur est survenue. Veuillez réessayer.");
                });
            });
        });
    </script>
</body>
</html>