<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Content/css/bootstrap.min.css" rel="stylesheet">
    <link href="Content/css/view_details_film.css" rel="stylesheet">
    <link href="Content/css/view_home_style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Détails personne</title>
    <style>
        .scrolling-wrapper {
            overflow-x: scroll;
            overflow-y: hidden;
            white-space: nowrap;
        }
        .scrolling-wrapper .card {
            display: inline-block;
        }
        .card img {
            width: 100%;
            height: auto;
        }
    </style>
</head>

    <?php require 'view_navbar.php'; ?>

    <div class="container text-white">
        <div class="row mb-4">
            <div class="col-md-4">
                <img src="https://image.tmdb.org/t/p/w600_and_h900_bestv2<?= $data['profile_path'] ?>" class="card-img rounded">
            </div>
            <div class="col-md-8">
                <h1 class="display-4"><?= $data['name'] ?></h1>
                <div class="person-infos">

                    <?php
                        setlocale(LC_TIME, 'fr_FR.UTF-8');
                        $date = strtotime($data['birthday']);
                        $date_fr = strftime('%e %B %Y', $date); //Formatage de la date en français
                    ?>
                    <p><strong>Date de naissance :</strong><br><?=$date_fr?></p>
                    <?php if ($data['deathday'] != null) : ?>
                        <?php
                            $date = strtotime($data['deathday']);
                            $date_fr = strftime('%e %B %Y', $date); //Formatage de la date en français
                        ?>
                        <p><strong>Date de décès :</strong><br><?=$date_fr?></p>
                    <?php endif; ?>
                    <p class="text-justify"><strong>Biographie :</strong><br><?= $data['biography']?></p>

                </div>
            </div>
        </div>

        <h2 class="text-white">Films les plus connus</h2> 
        <div class="scrolling-wrapper">
            <?php 
            $movies = $data['known_for'];
            foreach($movies as $movie): ?>
                <?php if (!empty($movie['poster_path'])): // Vérifie si le chemin de l'image de l'acteur existe ?>
                    <div class="card bg-dark text-white">
                        <img src="https://image.tmdb.org/t/p/original/<?= $movie['poster_path'] ?>" class="img-fluid" style="width: 200px; height: 300px;">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php if (isset($movie['title'])): ?>
                                    <?=$movie['title']?>
                                <?php elseif (isset($movie['name'])): ?>
                                    <?=$movie['name']?> 
                                <?php endif;?>
                            </h5>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

    </div>

    <?php require 'view_end.php';?>