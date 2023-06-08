<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Page accueil</title>
    <!--lien de font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!--CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

    <style>
        img.d-block.w-100 {
            width: auto;
            height: 500px;
        }

        .about-img img {
            width: 100vh;
            height: auto;
        }

        .hero-title {
            filter: drop-shadow(calc(-1 * 1.2rem) 1.2rem calc(1.2rem * 2) black);
            text-shadow: 1px 2px 5px rgb(0 0 0) !important;


            display: inline;
            font-variation-settings: "wght"900;
            
        }
    </style>


</head>

<body class="antialiased">
    <!-------------------------------------NAVIGATION-------------------------------->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">CHALET<span class="text-warning">MED</span></a>
            <button aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
                class="navbar-toggler" data-bs-target="#navbarSupportedContent" data-bs-toggle="collapse"
                type="button">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#accueil">accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#à propos">à propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>

                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item"> <a href="{{ url('/dashboard') }}"
                                    class="text-black btn btn-warning connexion">Dashboard</a></li>
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit"
                                        class="text-black btn btn-outline-warning decon">Déconnexion</button></form>
                            </li>
                        @else
                            <li class="nav-item"> <a href="{{ route('login') }}"
                                    class="text-black btn btn-warning connexion">Connexion</a></li>
                        @endauth
                    @endif

                </ul>
            </div>
        </div>
    </nav>

    <!----------------------------------MAIN------------------------------------->
    <div class="carousel slide" data-bs-ride="carousel" id="carouselExampleIndicators">
        <div class="carousel-indicators">
            <button aria-label="Slide 1" class="active" data-bs-slide-to="0" data-bs-target="#carouselExampleIndicators"
                type="button"></button>
            <button aria-label="Slide 2" data-bs-slide-to="1" data-bs-target="#carouselExampleIndicators"
                type="button"></button>
            <button aria-label="Slide 3" data-bs-slide-to="2" data-bs-target="#carouselExampleIndicators"
                type="button"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active"
                style="background: #f1fbff;
            background-image: url(images/image1.jpg);
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            height: 100vh;">

                <div class="carousel-caption mt-4" style="bottom: 35%;">
                    <h3 class="hero-title">Syndic <br> <span>CHALET MED</span></h3>
                </div>
            </div>
            <div class="carousel-item"
                style="background: #f1fbff;
            background-image: url(images/image2.jpg);
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            height: 100vh;">

                <div class="carousel-caption  mt-4" style="bottom: 35%;">
                    <h3 class="hero-title">Syndic <br> <span>CHALET MED</span></h3>
                </div>
            </div>
            <div class="carousel-item"
                style="background: #f1fbff;
            background-image: url(images/img3.jpg);
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            height: 100vh;">

                <div class="carousel-caption mt-4" style="bottom: 35%;">
                    <h3 class="hero-title">Syndic <br> <span>CHALET MED</span></h3>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" data-bs-slide="prev" data-bs-target="#carouselExampleIndicators"
            type="button">
            <span aria-hidden="true" class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" data-bs-slide="next" data-bs-target="#carouselExampleIndicators"
            type="button">
            <span aria-hidden="true" class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!--infos bancaire --->
    @php
        use App\Models\CoordoneeBanque;
        $coordonee = CoordoneeBanque::all();
    @endphp
    <!-- Ajoutez ce code avant la partie "à propos" -->

    <section class="rib section-padding">
        <div class="container mt-0">
            <h1 class="text-center"><span class="apropos-title"> Compte bancaire pour les versements de
                    cotisations</span></h1>
            <div class="rib-info">
                <div class="row mt-6 mt-4">
                    @foreach ($coordonee as $coord)
                        @if ($coord->status == 1)
                            <div class="col-md-6">
                                <p><i class="fas fa-credit-card"></i> <span>Numéro de compte:
                                    </span> <span class="value">{{ $coord->numero_compte }}</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><i class="fas fa-building"></i> <span>Raison sociale:
                                    </span> <span class="value">{{ $coord->raison_sociale }}</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><i class="fas fa-map-marker-alt"></i> <span>Ville:
                                    </span> <span class="value">{{ $coord->ville }}</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><i class="fas fa-university"></i> <span>Banque:
                                    </span> <span class="value">{{ $coord->banque }}</span></p>
                            </div>
                            <div class="col-md-6">
                                @if ($coord->logo)
                                    <div class="logo-container">
                                        <img src="{{ asset('uploads/photos/' . $coord->logo) }}"
                                            alt="Logo de la banque" style="height: 50px; width: 50px;"
                                            class="logo">
                                    </div>
                                @endif
                            </div>
                        @endif
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!------------------------------------ à propos ------------------------------------------>
    <section class="about section-padding" id="à propos">
        <h1 class="text-center"><span class="apropos-title"> À Propos</span></h1>

        <div class="row">
            <div class="col-lg-8 col-md-12 col-12 ps-lg-5 mt-md-5">
                <div class="about-text">
                    <h2>
                        Le syndic chalet Med, est une entité à but non lucratif, géré par des
                        <br />bénévoles, qui sont à la source des propriétaires, des 41 chalets.
                    </h2>
                    <p>
                        Ils ont pour mission principale, le maintien, de la sécurité sur les quatre coins de la
                        résidence, jour et nuit, par le biais d’une équipe de sécurité composée principalement d’ancien
                        soldats de l’armée.
                        Les défis de tous les jours, en matière de jardinage, d’espace vert et de sécurité font partie
                        du quotidien du bureau exécutif du syndic CHALET MED.
                        Cet espace, vient renforcer notre détermination, à veiller sur la valeur ajouter des chalets,
                        par la gestion efficace, des cotisations des adhérents, sur tous les plans.

                    </p>
                    <p><i class="fa-solid fa-location-dot"></i> <span>CHALET MED ROUTE DE SEBTA
                        </span></p>
                    <p><i class="fa-solid fa-house"></i> <span>Villa</span></p>
                    <p><i class="fa-solid fa-person-swimming"></i> <span>PLAGE SABLE DOREE AVEC CORNICHE
                        </span></p>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-12">
                <div class="about-img">
                    <img alt="" class="img-fluid" src="images/img1.jpg" />
                </div>
                <div class="about-img">
                    <img alt="" class="img-fluid img2apropos" src="images/img3.jpg" />
                </div>
            </div>

        </div>
    </section>


    <!--video
  -->
    <div class="video-container">
        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="embed-responsive embed-responsive-16by9">
                    <h2 class="text-center video-title">Plongez dans l'ambiance paisible de notre résidence</h2>
                    <video class="embed-responsive-item" src="images/video1.mp4" controls
                        style="height: auto; width: 100%"></video>
                </div>
            </div>
        </div>
    </div>

    <!--------------------------------- services ---------------------------------->
    <section class="services section-padding" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header text-center pb-5">
                        <h2 class="text-center"><span class=" apropos-title">Services</span></h2>
                        <p>
                            Explorez les services offerts par notre application.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card text-dark text-center bg-white pb-2">
                        <div class="card-body">
                            <i class="fas fa-money-bill-wave"></i>
                            <h3 class="card-title">Gestion des cotisations</h3>
                            <p class="lead">
                                Suivez vos cotisations et paiements en toute simplicité
                            </p>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card text-dark text-center bg-white pb-2">
                        <div class="card-body">
                            <i class="fa-solid fa-money-check-dollar"></i>
                            <h3 class="card-title">Gestion des <br> charges</h3>
                            <p class="lead">
                                Suivez et gérez vos charges de résidence en toute simplicité.
                            </p>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card text-dark text-center bg-white pb-2">
                        <div class="card-body">
                            <i class="far fa-newspaper"></i>
                            <h3 class="card-title mt-4">Actualités </h3>
                            <p class="lead">
                                Restez informé des dernières nouvelles de la résidence.
                            </p>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card text-dark text-center bg-white pb-2 mt-3">
                        <div class="card-body">
                            <i class="fas fa-file-import"></i>
                            <h3 class="card-title mt-4">les reçus de paiement </h3>
                            <p class="lead">

                                Saisir et d'importer les reçus de paiement des charges fixes mensuelles et
                                occasionnelles.
                            </p>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card text-dark text-center bg-white pb-2 mt-3">
                        <div class="card-body">
                            <i class="fas fa-file-invoice-dollar"></i>

                            <h3 class="card-title mt-4">consulter votre situation</h3>
                            <p class="lead">
                                Consulter la situation (montant payé, instances de paiement)
                            </p>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card text-dark text-center bg-white pb-2 mt-3">
                        <div class="card-body">
                            <i class="fas fa-tachometer-alt"></i>
                            <h3 class="card-title mt-4">Dashboard</h3>
                            <p class="lead">
                                Dashboard affichant le solde actuel et le total des charges à prévoir par rubrique
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <!-- Contact-->
    <section class="contact section-padding" id="contact">
        <div class="container mt-5 mb-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header text-center pb-5">
                        <h2><span>Contactez-nous</span> </h2>
                        <!-- <p><i class="fa-solid fa-envelope"></i><span>*********@gmail.com</span></p> -->
                        <p style="margin-top: 18px ; font-size : 20px;"><i class="fa-solid fa-phone"></i><span>+212
                                6 61 18 82 81</span></p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- footer -->
    <footer class="bg-dark p-2 text-center">
        <div class="container">
            <p class="text-white">© 2023 CHLETMED. Tous droits réservés</p>
        </div>
    </footer>


    <!--Js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</body>

</html>
