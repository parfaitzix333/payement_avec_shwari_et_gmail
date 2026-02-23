<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portail des parents du Lycée Twendeleye">
    <title>Portail Parent - Lycée Twendeleye</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('image/twendeleye_logo.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #198754;
            /* Bootstrap success color */
            --secondary-color: #ffc107;
            /* Bootstrap warning color */
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .header-content {
            background: linear-gradient(135deg, #1a5c36 0%, #198754 100%);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .school-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .school-logo {
            height: 60px;
            width: auto;
            border-radius: 8px;
            background-color: white;
            padding: 5px;
        }

        .school-info h1 {
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 0.25rem;
        }

        .school-info p {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .user-info .dropdown-toggle {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            color: #1a5c36;
            font-weight: 500;
        }

        .user-info .dropdown-toggle:hover {
            background-color: white;
        }

        .nav-container {
            background-color: white;
            border-bottom: 3px solid var(--secondary-color);
            padding: 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .nav-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            padding: 1rem 2rem;
        }

        .nav-buttons .btn {
            border-radius: 20px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .nav-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .nav-buttons .btn-success {
            background-color: var(--primary-color);
        }

        .nav-buttons .btn-success:hover {
            background-color: #146c43;
            border-color: var(--secondary-color);
        }

        .content-container {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .header-content {
                padding: 1rem;
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .school-info {
                flex-direction: column;
                text-align: center;
            }

            .nav-buttons {
                justify-content: center;
                padding: 1rem;
            }

            .nav-buttons .btn {
                flex: 1 0 calc(50% - 0.5rem);
                min-width: 140px;
                text-align: center;
            }

            .content-container {
                padding: 1rem;
            }
        }

        @media (max-width: 480px) {
            .nav-buttons .btn {
                flex: 1 0 100%;
            }

            .school-logo {
                height: 50px;
            }

            .school-info h1 {
                font-size: 1.25rem;
            }
        }

        /* Active state for navigation */
        .nav-buttons .btn.active {
            background-color: var(--secondary-color);
            color: #212529;
            border-color: var(--secondary-color);
        }

        /* Footer styling */
        .footer {
            background-color: #1a5c36;
            color: white;
            padding: 1.5rem;
            text-align: center;
            margin-top: 2rem;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <header>
        <div class="header-content">
            <div class="school-info">
                <img src="{{ asset('image/twendeleye_logo.png') }}"
                    alt="Logo du Lycée Twendeleye"
                    class="school-logo">
                <div>
                    <h1 class="h3 mb-1 text-warning"><i class="fas fa-graduation-cap me-2"></i>LYCÉE TWENDELEYE</h1>
                    <p class="mb-0"><i class="fas fa-chalkboard-teacher me-1"></i>Portail du parent</p>
                </div>
            </div>

            <!-- User Information -->
            <div class="user-info">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle"
                        type="button"
                        id="userDropdown"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-user me-1"></i> Parent
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="{{route('edit_profile_parent')}}">
                                <i class="fas fa-user-cog me-2"></i>Mon profil
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="post" id="logoutForm">
                                @csrf
                                <button type="button" class="dropdown-item text-danger" onclick="confirmLogout()">
                                    <i class="fas fa-sign-out-alt me-2"></i>Se déconnecter
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation Section -->
    <nav class="nav-container">
        <div class="nav-buttons">
            <a href="{{route('profile_parent')}}" class="btn btn-success active">
                <i class="fas fa-home me-1"></i>Accueil
            </a>
            <a href="{{route('mes_payements')}}" class="btn btn-success">
                <i class="fas fa-credit-card me-1"></i>Catalogue de paiement
            </a>
        </div>
    </nav>

    <!-- Main Content Section -->
    <main class="content-container">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p class="mb-1">© {{ date('Y') }} Lycée Twendeleye - Tous droits réservés</p>
            <p class="mb-0 small">
                <i class="fas fa-phone me-1"></i> Contact: +243 XX XXX XXXX |
                <i class="fas fa-envelope ms-2 me-1"></i> info@twendeleye.edu.cd
            </p>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Confirmation pour la déconnexion
        function confirmLogout() {
            if (confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
                document.getElementById('logoutForm').submit();
            }
        }

        // Navigation active state management
        $(document).ready(function() {
            // Get current page URL
            var url = window.location.href;

            // Remove active class from all buttons
            $('.nav-buttons .btn').removeClass('active');

            // Add active class to current page button
            $('.nav-buttons .btn').each(function() {
                if (url.includes($(this).attr('href'))) {
                    $(this).addClass('active');
                }
            });

            // Handle button clicks for active state
            $('.nav-buttons .btn').on('click', function(e) {
                if (!$(this).attr('href').startsWith('#')) {
                    $('.nav-buttons .btn').removeClass('active');
                    $(this).addClass('active');
                }
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    @yield('scripts')
</body>

</html>