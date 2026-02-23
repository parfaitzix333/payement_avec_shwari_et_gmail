<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C.S GALAXIE</title>

    <!-- SEULEMENT ces deux liens CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Réinitialisation de marges et de paddings */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Styles de base */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background-image: url('image/pierres.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #333;
        }

        /* Header styles */
        #enseigne {
            background-color: rgba(245, 241, 241, 0.5);
            color: #0a0342;
            font-weight: bold;
            margin-bottom: 0;
            border-radius: 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            color: white;
        }

        /* Main content area */
        .content {
            display: flex;
            flex: 1;
            padding: 20px 0;
        }

        /* Navigation sidebar */
        #entete {
            width: 250px;
            background-color: rgba(206, 212, 218, 0.85);
            border-radius: 5px;
            padding: 15px;
            margin: 0 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        nav a {
            width: 100%;
            margin: 8px 0;
            text-align: left;
            padding: 10px 15px;
            transition: all 0.3s ease;
            border-radius: 4px;
        }

        nav a:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        nav a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main content zone */
        #zone_libre {
            flex: 1;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 5px;
            margin-right: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        /* Footer styles */
        footer {
            text-align: center;
            padding: 20px;
            color: white;
            background-color: rgb(98, 95, 120);
            margin-top: auto;
        }

        /* Mobile responsiveness */
        @media (max-width: 992px) {
            .content {
                flex-direction: column;
                padding: 10px;
            }

            #entete {
                width: 100%;
                margin: 10px 0;
            }

            #zone_libre {
                margin: 10px 0;
            }
        }

        @media (max-width: 768px) {
            .menu-icon {
                display: block;
                margin-left: 20px;
            }

            .nav-container {
                display: none;
                flex-direction: column;
                position: absolute;
                right: 0;
                background: rgba(206, 212, 218, 0.95);
                width: 100%;
                top: 60px;
                z-index: 1000;
                padding: 10px;
                border-radius: 0 0 5px 5px;
            }

            .nav-container.show {
                display: flex;
            }
        }

        /* Style spécifique pour les modals */
        .modal-backdrop {
            z-index: 1040 !important;
        }

        .modal {
            z-index: 1050 !important;
        }

        .logo {
            width: 40px;
            border-radius: 60px;
        }

        .nav-content a {
            text-align: left;
        }
    </style>
</head>

<body>
    <header>
        <h1 id="enseigne" class="alert alert-light text-center text-dark">
            C.S GALAXIE
        </h1>
        </h1>
    </header>


    <div class="content">
        <aside class="container alert alert-info" id="entete">
            <button class="btn btn-primary d-block d-md-none mb-3" onclick="toggleMenu()">
                <i class="fas fa-bars"></i> Menu
            </button>

            <nav class="bg-light rounded shadow-sm p-3 text-left">
                <div class="nav-content">
                    <div class="dropdown">
                        <button class="btn btn-outline-dark dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-2"></i>{{ $user->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-key me-2"></i>{{ $user->id }}</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>{{ $user->usertype }}</a></li>
                        </ul>
                    </div>
                    <a href="#" class="btn btn-custom">
                        <i class="fas fa-home me-2"></i>ACCUEIL
                    </a>
                    <a href="#" class="btn btn-custom">
                        <i class="fas fa-money-bill-wave me-2"></i>MES PAIEMENTS
                    </a>
                    <a href="#" class="btn btn-custom"> 
                        <i class="fas fa-landmark me-2"></i>PATRIMOINE
                    </a>

                </div>
            </nav>
        </aside>

        <main id="zone_libre">
            @yield('content')
        </main>
    </div>

    <footer>
        <p>&copy; {{ date('Y') }} Tous droits réservés à <strong>C.S GALAXIE</strong></p>
        <p class="mt-2">
            <a href="#" class="text-white me-3"><i class="fas fa-envelope"></i> Contact</a>
            <a href="#" class="text-white me-3"><i class="fas fa-info-circle"></i> À propos</a>
            <a href="#" class="text-white"><i class="fas fa-shield-alt"></i> Confidentialité</a>
        </p>
        <div>
            <form action="{{ route('logout') }}" method="post" onsubmit="return confirm('Deconnecter ?')">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-sign-out"></i>
                    Se deconnecter
                </button>
            </form>
        </div>
    </footer>

    <!-- IMPORTANT: Ces scripts doivent être dans cet ordre -->
    <!-- jQuery d'abord -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Puis Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <!-- Puis Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
        function toggleMenu() {
            const navLinks = document.getElementById('nav-links');
            navLinks.classList.toggle('show');
        }

        // Close menu when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const navLinks = document.getElementById('nav-links');
            const menuButton = document.querySelector('.d-block.d-md-none.mb-3');

            if (window.innerWidth <= 768 &&
                !event.target.closest('#nav-links') &&
                !event.target.closest('.d-block.d-md-none.mb-3') &&
                navLinks.classList.contains('show')) {
                navLinks.classList.remove('show');
            }
        });

        // Initialisation des tooltips Bootstrap si besoin
        $(function() {
            $('[data-bs-toggle="tooltip"]').tooltip()
        })
    </script>

    @yield('scripts')
</body>

</html>