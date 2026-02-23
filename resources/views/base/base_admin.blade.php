<!DOCTYPE html>
<html lang="fr"> <!-- Changé à "fr" pour un site francophone -->

<head>
    <link rel="icon" type="image/x-icon" href="{{ asset('image/twendeleye_logo.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portail d'administration du Lycée Twendeleye">
    <title>Lycée Twendeleye - Administration</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Styles personnalisés -->
    <style>
        :root {
            --primary-color: #198754;
            /* Vert Bootstrap success */
            --secondary-color: #146c43;
            --text-light: #ffffff;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .main-header {
            background-color: var(--primary-color);
            color: var(--text-light);
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1400px;
            margin: 0 auto;
        }

        .school-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .school-logo {
            width: 70px;
            height: 70px;
            border-radius: 8px;
            object-fit: contain;
            background-color: white;
            padding: 5px;
        }

        .nav-menu {
            background-color: var(--secondary-color);
            padding: 0.5rem 1rem;
            display: flex;
            gap: 0.5rem;
            overflow-x: auto;
            /* Pour mobile */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .nav-btn {
            color: var(--text-light) !important;
            text-decoration: none;
            padding: 0.75rem 1.25rem;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .nav-btn:hover {
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .nav-btn.active {
            background-color: rgba(255, 255, 255, 0.25);
            font-weight: bold;
        }

        .pulse-on-hover:hover {
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
            }

            70% {
                box-shadow: 0 0 0 5px rgba(255, 255, 255, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
            }
        }

        .main-content {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 1rem;
            min-height: calc(100vh - 200px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .nav-menu {
                flex-wrap: wrap;
                justify-content: center;
            }

            .nav-btn {
                padding: 0.5rem 0.75rem;
                font-size: 0.9rem;
            }
        }

        /* Footer optionnel */
        .footer {
            background-color: var(--primary-color);
            color: var(--text-light);
            text-align: center;
            padding: 1rem;
            margin-top: 2rem;
        }
    </style>
</head>

<body>
    <!-- En-tête principal -->
    <header class="main-header">
        <div class="header-content">
            <div class="school-info">
                <img src="{{ asset('image/twendeleye_logo.png') }}" alt="Logo Lycée Twendeleye" class="school-logo">
                <div>
                    <h1 class="h3 mb-1 text-warning"><i class="fas fa-graduation-cap me-2 text-warning"></i>LYCÉE TWENDELEYE</h1>
                    <p class="mb-0"><i class="fas fa-chalkboard-teacher me-1"></i>Portail d'administration scolaire</p>
                </div>
            </div>

            <!-- Informations utilisateur (optionnel) -->
            <div class="user-info d-none d-md-block">
                <div class="dropdown">
                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i> Administrateur
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{route('edit_profile_admin')}}"><i class="fas fa-user-cog me-2"></i>Mon profil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="post" onsubmit="return confirm('se deconnecter ?')">
                                @csrf
                                <button class="btn btn-danger">
                                    <i class="fa fa-sign-out"></i> Se Déconnecter
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation principale -->
    <nav class="nav-menu">
        <a href="{{ route('profile_admin') }}" class="nav-btn {{ request()->routeIs('admin') ? 'active' : '' }}">
            <i class="fas fa-home"></i> Accueil
        </a>
        <a href="{{route('eleves.index')}}" class="nav-btn {{ request()->routeIs('eleves.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Les Élèves
        </a>
        <a href="{{route('les_payements')}}" class="nav-btn {{ request()->routeIs('les_payements') ? 'active' : '' }}">
            <i class="fas fa-money-check-alt"></i> Les Paiements
        </a>
        <a href="{{route('classes.index')}}" class="nav-btn {{ request()->routeIs('classes.*') ? 'active' : '' }}">
            <i class="fas fa-chalkboard"></i> Les Classes
        </a>
        <a href="{{route('les_frais.index',$user->id)}}" class="nav-btn {{ request()->routeIs('les_frais.*') ? 'active' : '' }}">
            <i class="fas fa-file-invoice-dollar"></i> Les Frais
        </a>
        <a href="{{route('les_users')}}" class="nav-btn {{ request()->routeIs('les_users') ? 'active' : '' }}">
            <i class="fas fa-user-cog"></i>Les Utilisateurs
        </a>
        <a href="{{route('les_alerts')}}" class="nav-btn {{ request()->routeIs('les_alerts.*') ? 'active' : '' }}">
            <i class="fas fa-bell"></i> Les Alerts
        </a>
    </nav>

    <!-- Contenu principal -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Pied de page (optionnel) -->
    <footer class="footer">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Lycée Twendeleye - Tous droits réservés</p>
            <small><i class="fas fa-phone-alt me-1"></i> Contact: +243 XX XXX XXX | <i class="fas fa-envelope me-1"></i> contact@lycee-twendeleye.cd</small>
        </div>
        <div>
            <form action="{{ route('logout') }}" method="post" onsubmit="return confirm('se deconnecter ?')">
                @csrf
                <button class="btn btn-danger">
                    <i class="fa fa-sign-out"></i> Se Déconnecter
                </button>
            </form>
        </div>
    </footer>

    <!-- Scripts personnalisés -->
    <script>
        // Marquer l'élément de navigation actif
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-btn');

            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });

            // Animation du menu
            const navButtons = document.querySelectorAll('.nav-btn');
            navButtons.forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    this.classList.add('pulse-on-hover');
                });

                btn.addEventListener('mouseleave', function() {
                    this.classList.remove('pulse-on-hover');
                });
            });
        });
    </script>

    @yield('scripts')
</body>

</html>