<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Lycée Twendeleye</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
            url("{{ asset('image/pexels_steve.jpg') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-brand {
            font-weight: 700;
            color: #fff !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .login-card {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 90%;
            margin: 0 auto;
        }

        .login-card .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 2rem 2rem 0.5rem 2rem;
        }

        .login-card .card-body {
            padding: 2rem;
        }

        .login-logo {
            width: 100px;
            height: auto;
            margin-bottom: 1rem;
            border-radius: 50%;
            border: 3px solid #198754;
            padding: 5px;
            background: white;
        }

        .form-floating label {
            color: #555;
        }

        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
        }

        .btn-success {
            background-color: #198754;
            border-color: #198754;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s;
        }

        .btn-success:hover {
            background-color: #146c43;
            border-color: #146c43;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .login-link {
            color: #198754;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .login-link:hover {
            color: #146c43;
            text-decoration: underline;
        }

        .error-feedback {
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }

        footer {
            margin-top: auto;
            background-color: rgba(0, 0, 0, 0.4);
            color: rgba(255, 255, 255, 0.8);
            text-align: center;
            padding: 1rem;
            backdrop-filter: blur(5px);
        }
    </style>
</head>

<body>

    <!-- Navigation simple avec logo et nom -->
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-school me-2"></i>Lycée Twendeleye
            </a>
        </div>
    </nav>

    <!-- Contenu principal : formulaire d'inscription -->
    <main class="container d-flex align-items-center justify-content-center flex-grow-1 my-4">
        <div class="login-card card">
            <div class="card-header">
                <img src="{{ asset('image/twendeleye_logo.png') }}" alt="Logo Lycée Twendeleye" class="login-logo">
                <h3 class="fw-bold text-success">Inscription</h3>
                <p class="text-muted small">Créez votre compte administrateur</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Nom -->
                    <div class="form-floating mb-3">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                            placeholder="Votre nom">
                        <label for="name"><i class="fas fa-user me-2 text-success"></i>Nom complet</label>
                        @error('name')
                        <div class="error-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-floating mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="username"
                            placeholder="nom@exemple.fr">
                        <label for="email"><i class="fas fa-envelope me-2 text-success"></i>Adresse e-mail</label>
                        @error('email')
                        <div class="error-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Mot de passe -->
                    <div class="form-floating mb-3">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password"
                            placeholder="Mot de passe">
                        <label for="password"><i class="fas fa-lock me-2 text-success"></i>Mot de passe</label>
                        @error('password')
                        <div class="error-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirmation du mot de passe -->
                    <div class="form-floating mb-3">
                        <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Confirmer le mot de passe">
                        <label for="password_confirmation"><i class="fas fa-check-circle me-2 text-success"></i>Confirmer le mot de passe</label>
                        @error('password_confirmation')
                        <div class="error-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Bouton d'inscription et lien vers connexion -->
                    <div class="d-flex align-items-center justify-content-between mt-4">
                        <a href="{{ route('login') }}" class="login-link">
                            <i class="fas fa-arrow-left me-1"></i>Déjà inscrit ? Connectez-vous
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-user-plus me-2"></i>S'inscrire
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p class="mb-0">&copy; {{ date('Y') }} Lycée Twendeleye. Tous droits réservés.</p>
    </footer>

</body>

</html>