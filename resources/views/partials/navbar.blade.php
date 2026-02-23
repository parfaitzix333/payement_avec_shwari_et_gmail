<!--? Preloader Start -->
<div id="preloader-active">
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-inner position-relative">
            <div class="preloader-circle"></div>
            <div class="preloader-img pere-text">
                <img src="{{asset('img/logo/rdc5.png')}}" alt="Avatard"/>
            </div>
        </div>
    </div>
</div>
<!-- Preloader Start -->
<header>
    <!-- Header Start -->
    <div class="header-area">
        <div class="main-header ">
            <div class="header-top d-none d-lg-block">
                <div class="container">
                    <div class="col-xl-12">
                        <div class="row d-flex justify-content-between align-items-center">
                            <div class="header-info-left">
                                <ul>
                                    <li>Phone: + (243)90-018-259-9</li>
                                    <li>Email: parfaitzix333@gmail.com</li>
                                    <li>Concepteur : LUFUNGULA KAZIBA PATRICK</li>
                                </ul>
                            </div>
                                <div class="header-info-right">
                                <ul class="header-social">
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li> <a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-bottom  header-sticky">
                <div class="container">
                    <div class="row align-items-center">
                        <!-- Logo -->
                        <div class="col-xl-2 col-lg-2">
                            <div class="logo">
                                <a href="index.html"><img src="{{asset('img/logo/rdc6.png')}}" alt="Avatard" class="img-fluid rounded-circle" width="85" height="65" /></a>
                            </div>
                        </div>
                        <div class="col-xl-10 col-lg-10">
                            <div class="menu-wrapper  d-flex align-items-center justify-content-end">
                                <!-- Main-menu -->
                                <div class="main-menu d-none d-lg-block">
                                    <nav>
                                        <ul id="navigation">
                                           <!-- <li><a href="FormulaireDemande_1.php">Demander Visa</a></li>
                                            <li><a href="formConnexion.php">Se connecter</a></li>-->
                                            <li><a href="{{ route('faculte')}}">Acceuil</a></li>
                                            <li><a href="{{route('faculte')}}">Faculté</a></li>
                                            <li><a href="{{route('promotion')}}">Promotion</a></li>
                                            <li><a href="{{route('etudiant')}}">Etudiant</a></li>
                                            <li><a href="{{route('cours')}}">Cours</a></li>
                                            <li><a href="{{route('enseignent')}}">Enseignant</a></li>
                                            <li id="gRegistre"><a href="{{route('afficher')}}">Registre</a></li>
                                        </ul>
                                    </nav>
                                </div>
                                <!-- Header-btn
                                <div class="header-right-btn d-none d-lg-block ml-20">
                                    <a href="{{asset('img/passeports/Formulaire_Visa_Congo_Kinshasa_RDC.pdf')}}" class="btn header-btn" target="_blank">Obtenir Formulaire</a>
                                </div>-->
                            </div>
                        </div>
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->
</header>
