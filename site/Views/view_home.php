<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Content/img/favicon.ico" rel="icon">
    <link href="Content/css/bootstrap.min.css" rel="stylesheet">
    <link href="Content/css/view_home_style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Le Septieme Art - Accueil</title>

    <?php require 'view_navbar.php';?>

    <div class="background-image my-5 text-center image-container">
        <img src="Content/img/pulp-fiction-background.jpg" alt="Movie poster for index background" class="rounded mx-auto">
    </div>
    
    <section class="py-8 text-white">
        <div class="container nouveautes">
            <hr class="border-gray-800">
            <h2 id="fonc-title" class="text-2xl font-semibold my-5 text-center">NOUVEAUTÉS</h2>
            <div class="row g-4 justify-content-center">                
                <?php foreach ($data as $movie) : ?>
                    <div class="col">
                        <a href="?controller=details&action=details&tconst=<?= $movie['tconst'] ?>">
                            <div class="image-frame">
                                <img src="https://image.tmdb.org/t/p/original/<?= $movie['poster_path'] ?>" alt="Movie thumbnail for 'Movie Title'" class="img-frame img-fluid rounded">
                                <div class="hover-text">
                                    <p class="poster-title"><?= $movie['primarytitle'] ?></p>
                                    <p><i class="fas fa-star" style="color: yellow;"></i>&nbsp;<?= $movie['averagerating'] ?></p>
                                    <p class="poster-numvotes"><i class="fas fa-chart-bar"></i>&nbsp;<?= $movie['numvotes'] ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        </div> 
    </section>

    <script>
        //Script qui ajoute le blur sur les images au hover pour que le blur et le hover-text se superposent correctement
        $(document).ready(function(){
            $('.img-fluid').hover(function(){
                $(this).addClass('blur');
            }, function(){
                $(this).removeClass('blur');
            });
            $('.hover-text').hover(function(){
                $(this).closest('.image-frame').find('.img-fluid').addClass('blur');
            }, function(){
                $(this).closest('.image-frame').find('.img-fluid').removeClass('blur');
            });
        });
    </script>


    <section id="fonctionnalites" class="py-8 text-white">
        <div class="container">
            <hr class="border-gray-800">
            <h2 id="fonc-title" class="text-2xl font-semibold my-5 text-center">FONCTIONNALITÉS</h2>
            <div class="row g-4 justify-content-center">

                <div class="features-grid">

                <!-- Row 1 -->
                <div class="row">

                    <!-- Feature 1 -->
                    <div class="feature col-md-6">
                        <a class="feature-block text-decoration-none" href="?controller=home&action=recherche">
                            <div class="fonc-box feature-content p-4">
                                <h3 class="text-center text-xl font-semibold mt-2">RECHERCHES SIMPLES</h3>
                                <div class="content-with-img">
                                    <img src="Content/img/icons8-coche-100.png" class="feature-img">
                                    <p class="feature-text-description"><br />La recherche simple permet à l'utilisateur de faire une recherche sur un film tapant simplement son intitulé (nom du film)</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Feature 2 -->
                    <div class="col-md-6">
                        <a class="feature-block text-decoration-none">
                            <div class="fonc-box feature-content p-4">
                                <h3 class="text-center text-xl font-semibold mt-2">RECHERCHES AVANCÉES</h3>
                                <div class="content-with-img">
                                    <img src="Content/img/icons8-rafraichir-120.png" class="feature-img">
                                    <p class="feature-text-description">La recherche avancée permet une recherche plus poussée que la recherche simple, notamment en laissant plus de filtres à l'utilisateur (genre, pays, année, etc..)</p>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
                
                <!-- Row 2 -->
                <div class="row">

                    <!-- Feature 3 -->
                    <div class="feature col-md-6">
                        <a class="feature-block text-decoration-none" href="?controller=commun&action=commun">
                            <div class="fonc-box feature-content p-4">
                                <h3 class="text-center text-xl font-semibold mt-2">COMMUN</h3>
                                <div class="content-with-img">
                                    <img src="Content/img/icons8-dossier-ouvert-120.png" class="feature-img" >
                                    <p class="feature-text-description">La recherche simple permet à l'utilisateur de faire une recherche sur un film ou un acteur en tapant simplement son intitulé (nom du film, nom/prénom de l'acteur)</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Feature 4 -->
                    <div class="feature col-md-6">
                        <a class="feature-block text-decoration-none">
                            <div class="fonc-box feature-content p-4">
                                <h3 class="text-center text-xl font-semibold mt-2">RAPPROCHEMENT</h3>
                                <div class="content-with-img">
                                    <img src="Content/img/icons8-partager-2-100.png" class="feature-img">
                                    <p class="feature-text-description">La recherche "Rapprochement" permet de relier deux films ou personnes par une chaîne de personnes et films la plus courte possible suivant la relation “X a participé au film Y”</p>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>

                </div>

            </div>
        </div>
    </section>

<?php require 'view_end.php';?>