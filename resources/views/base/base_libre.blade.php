<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Plateforme DERKAT - Gestion de paiements et patrimoine">
    <title>LYCÉE TWENDELEYE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: rgb(225, 228, 8);
            --secondary-color: rgb(14, 8, 137);
            --accent-color: rgb(4, 108, 21);
            --light-color: rgb(241, 238, 238);
            --overlay-color: rgba(1, 99, 29, 0.83);
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-image: url('{{ asset("image/pierres.jpg") }}');
            font-family: 'Georgia', 'Times New Roman', serif;
        }

        #main-content {
            flex: 1;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }

        #main-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.3);
            z-index: 0;
        }

        .title {
            background-color: var(--overlay-color);
            padding: 1rem;
            z-index: 1;
            position: relative;
        }

        .title h1 {
            font-weight: 700;
            color: var(--primary-color);
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }

        .nav-container {
            z-index: 1;
            position: relative;
        }

        .nav-content {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-toggle::after {
            margin-left: 0.5em;
            vertical-align: 0.15em;
        }

        .dropdown-menu {
            background-color: rgba(14, 8, 137, 0.9);
            border: 2px solid var(--accent-color);
            min-width: 180px;
        }

        .dropdown-item {
            color: var(--light-color);
            padding: 0.5rem 1rem;
            border-bottom: 1px solid var(--accent-color);
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: var(--secondary-color);
            color: white;
        }

        footer {
            background-color: var(--primary-color);
            color: black;
            padding: 1.5rem 0;
            margin-top: auto;
        }

        .btn-custom {
            background-color: var(--primary-color);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background-color: var(--accent-color);
            color: white;
        }

        @media (max-width: 768px) {
            .nav-content {
                flex-direction: column;
                align-items: center;
            }

            .dropdown {
                width: 100%;
                text-align: center;
            }

            .dropdown-menu {
                position: static !important;
                transform: none !important;
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .title h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>
    <div id="main-content">
        <div class="title text-center">
            <h1 class="mb-0">LYCÉE TWENDELEYE</h1>
            <p class="mb-0">Plateforme de gestion financière</p>
        </div>

        <div class="container nav-container py-3">
            <nav class="bg-light rounded shadow-sm p-3">
                <div class="nav-content">
                    

                    <div class="dropdown">
                        <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Quiter ?')">
                            @csrf
                            <button class="btn btn-danger">Se deconecter</button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>

        <div class="container my-4 position-relative" style="z-index: 1;">
            @yield('content')
        </div>
    </div>

    <footer class="text-center">
        <div class="container">
            <p class="mb-1">&copy; LYCÉE TWENDELEYE {{ date('Y') }} - Tous droits réservés</p>
            <p class="mb-0">
                <small>Dernière mise à jour : {{ date('d/m/Y H:i') }}</small>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Activation des tooltips Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>

</html>