<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lycée Twendeleye - Administration</title>
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
            url("{{ asset('image/pexels_steve.jpg') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar personnalisée */
        .navbar-custom {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Bannière de bienvenue */
        .welcome-card {
            background-color: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(5px);
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            text-align: center;
        }

        .welcome-card i {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #2c3e50;
        }

        .btn-custom {
            padding: 0.5rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        footer {
            margin-top: auto;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            text-align: center;
            padding: 1rem;
            backdrop-filter: blur(5px);
        }
    </style>
</head>

<body>

    <!-- Navigation -->
    @if (Route::has('login'))
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="{{ url('/') }}">
                <img src="{{ asset('image/twendeleye_logo.png') }}" alt="Logo Lycée Twendeleye" width="70px" height="70px">
                Lycée Twendeleye
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    @auth
                    <li class="nav-item">
                        <a href="{{ url('/dashboard') }}" class="btn btn-success btn-custom">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    @else
                    <li class="nav-item me-2">
                        <a href="{{ route('login') }}" class="btn btn-outline-success btn-custom">
                            <i class="fas fa-sign-in-alt me-2"></i>Connexion
                        </a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-success btn-custom">
                            <i class="fas fa-user-plus me-2"></i>Inscription
                        </a>
                    </li>
                    @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    @endif

    <!-- Contenu principal -->
    <main class="container d-flex align-items-center justify-content-center flex-grow-1">
        <div class="welcome-card">
            <h1 class="display-5 fw-bold text-success mb-4">
                <i class="fas fa-graduation-cap me-3"></i>LYCÉE TWENDELEYE
            </h1>
            <p class="lead">
                <i class="fas fa-quote-left text-success me-2 opacity-50"></i>
                Bienvenue sur le portail d'administration du Lycée Twendeleye. Connectez-vous pour gérer les ressources,
                les utilisateurs et les données de l'école de manière efficace et sécurisée.
                <i class="fas fa-quote-right text-success ms-2 opacity-50"></i>
            </p>
            <hr class="my-4 w-50 mx-auto">
            <p class="text-muted small">
                <i class="fas fa-lock me-1"></i>Accès réservé au personnel autorisé
            </p>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p class="mb-0">&copy; {{ date('Y') }} Lycée Twendeleye. Tous droits réservés.</p>
    </footer>

</body>

</html>