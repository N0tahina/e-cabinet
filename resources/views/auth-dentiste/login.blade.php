<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion Dentiste</title>
  <link rel="stylesheet" href="/css/dentiste-login.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

  <main class="login-container">

    <section class="login-card" aria-labelledby="login-title">
      <h1 id="login-title">Espace Dentiste</h1>

      <form method="POST" action="/dentiste/login">
        @csrf

        <div class="form-group">
          <label for="email">Email professionnel</label>
          <input 
            type="email" 
            id="email" 
            name="email" 
            required 
            placeholder="dentiste@cabinet.com">
        </div>

        <div class="form-group">
          <label for="password">Mot de passe</label>
          <input 
            type="password" 
            id="password" 
            name="password" 
            required 
            placeholder="••••••••">
        </div>

        <button type="submit" class="btn-login">
          Se connecter
        </button>

      </form>
    </section>

  </main>

</body>
</html>