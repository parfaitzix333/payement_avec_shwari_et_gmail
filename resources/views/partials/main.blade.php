<main>
    <!--? slider Area Start-->
    <div class="slider-area ">
        <div class="slider-active">
            <!-- Single Slider -->
            <div class="single-slider slider-height d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-9 col-lg-9">
                            <!--
                            <div class="hero__caption">
                                <h1>Demander vos<span>Informations !</span></h1>
                            </div> -->
                            <!--Hero form -->
                            <form class="search-box" action="index.php" method="POST" enctype="multipart/form-data" name="f_popup">
                                <div class="input-form">
                                    <input type="text" placeholder="Votre Numéro Matricule" name="refNum">
                                </div>
                                <div class="search-form">
                                    <button name="valider" class="btn btn-success"><i class="fas fa-check"></i>Valider</button>
                                </div>
                                <?php
                                //rechercheEtat();
                                ?>
                            </form>
                            <!-- Hero Pera -->
                            <div class="hero-pera">
                                <p>Pour le suivi sur l état de votre demande</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider Area End-->
    <!-- The Modal -->
    <div class="modal" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Voici la photo de votre passeport</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                        <?php
                                //rechercheEtat();
                                ?>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                        <button type="button" class="btn-warning" id="button"><i class="fas fa-angle-right rotate-icon" style="padding-right: 10px;"></i>Pivoter</button>
                            <button type="button" class="btn-success" data-dismiss="modal"><i class="fas fa-check"></i>Valider</button>
                            <button type="button" class="btn-info" onclick="return onClick(this)" id=""><i class="fas fa-exclamation"></i>Changer</button>
                        </div>
                    </div>
                </div>
            </div>
    <!--? our info Start -->
    <div class="our-info-area pt-70 pb-40">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-info mb-30">
                        <div class="info-icon">
                            <span class="flaticon-support"></span>
                        </div>
                        <div class="info-caption">
                            <p>Appelez-nous au</p>
                            <span>+ (242)04-050-63-61</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-info mb-30">
                        <div class="info-icon">
                            <span class="flaticon-clock"></span>
                        </div>
                        <div class="info-caption">
                            <p>Dimanche FERMÉ</p>
                            <span>Lun - Sam 8h00 - 18h00</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-info mb-30">
                        <div class="info-icon">
                            <span class="flaticon-place"></span>
                        </div>
                        <div class="info-caption">
                            <p>Brazzaville/République du Congo</p>
                            <span>130, Avenue de l’indépendance, Centre-Ville, B.P. : 2457</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- our info End -->
    <!--? Categories Area Start -->
    <div class="categories-area section-padding30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Section Tittle -->
                    <div class="section-tittle text-center mb-80">
                        <h2>LES DISPOSITIONS DE L’OCTROI DES VISAS DE VOYAGE EN REPUBLIQUE DEMOCRATIQUE DU CONGO</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-cat text-center mb-50">
                        <div class="cat-icon">
                            <span class="flaticon-shipped"></span>
                        </div>
                        <div class="cat-cap">
                            <h5><a href="FormulaireDemande_1.php">Pour nos frères et sœurs du Congo Brazzaville</a></h5>
                            <p>
                                Dépôt demande de visa avec dossier complet ;</br>
                                Avoir la prise en charge de la DGM ;</br>
                                Durée : Moins de 10 jours.
                                </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-cat text-center mb-50">
                        <div class="cat-icon">
                            <span class="flaticon-ship"></span>
                        </div>
                        <div class="cat-cap">
                            <h5><a href="FormulaireDemande_1.php">Pour les passeports officiels et spéciaux</a></h5>
                            <p>Dépôt demande de visa avec dossier complet ;</br>
                                Durée : Moins de 10 jours.
                                </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-cat text-center mb-50">
                        <div class="cat-icon">
                            <span class="flaticon-plane"></span>
                        </div>
                        <div class="cat-cap">
                            <h5><a href="FormulaireDemande_1.php">Pour les étrangers résidents au Congo Brazza</a></h5>
                            <p>Dépôt demande de visa avec dossier complet ;</br>
                                Avoir la prise en charge de la DGM ;</br>
                                Durée : Moins de 10 jours.
                                </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Categories Area End -->
</main>
