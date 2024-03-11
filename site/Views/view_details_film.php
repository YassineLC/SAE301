<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Content/css/bootstrap.min.css" rel="stylesheet">
    <link href="Content/css/view_details_film.css" rel="stylesheet">
    <link href="Content/css/view_home_style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Détails film</title>
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
<body class="text-white">
    <?php require 'view_navbar.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <img src="https://image.tmdb.org/t/p/original/<?= $data[0]['poster_path'] ?>" class="card-img rounded" alt="<?= $data[0]['originaltitle'] ?>">
            </div>
            <div class="col-md-8">
                <h1 class="display-4"><?= $data[0]['originaltitle'] ?></h1>
                <p>
                    <?php foreach ($data[0]['genres'] as $genre) :?>
                        <span class="badge badge-secondary"><?= $genre['name'] ?> </span>
                    <?php endforeach; ?>
                </p>
                <div class="movie-infos">

                    <?php
                        setlocale(LC_TIME, 'fr_FR.UTF-8');
                        $date = strtotime($data[0]['release_date']);
                        $date_fr = strftime('%e %B %Y', $date); //Formatage de la date en français
                        $duration = $data[0]['runtimeminutes'];
                        $hours = intdiv($duration, 60); // Calcule le nombre d'heures
                        $minutes = $duration % 60; // Calcule le reste des minutes
                    ?>
                    <p><strong>Durée :</strong><br><?= $hours ?>h<?= sprintf("%02d", $minutes) ?></p>
                    <p><strong>Date de sortie :</strong><br><?=$date_fr?></p>
                    <p class="text-justify"><strong>Synopsis :</strong><br><?= $data[0]['overview']?></p>
                    <p><strong>Budget :</strong><br><?= number_format($data[0]['budget'], 0, '.', ',') ?> $</p>
                    <p><strong>Revenus :</strong><br><?= number_format($data[0]['revenue'], 0, '.', ',') ?> $</p>
                    <p><strong>Note moyenne :</strong><br><?= $data[0]['averagerating']?></p>
                    <p><strong>Nombre de votes :</strong><br><?= number_format($data[0]['numvotes'], 0, '.', ',') ?></p>

                </div>
            </div>
        </div>
        <!-- Nouvelle ligne pour les acteurs -->
        <h2 class="text-white">Acteurs principaux</h2> 
        
        <div class="scrolling-wrapper">
            <?php 
            // Limite à 15 acteurs
            $actors = array_slice($data[0]['actors'], 0, 15);
            foreach($actors as $actor): ?>
                <?php if (!empty($actor['profile_path'])): // Vérifie si le chemin de l'image de l'acteur existe ?>
                    <div class="card bg-dark text-white">
                        <img src="https://image.tmdb.org/t/p/w200<?= $actor['profile_path'] ?>" alt="<?= $actor['name'] ?>" class="img-fluid" style="width: 200px; height: 300px;">
                        <div class="card-body">
                            <h5 class="card-title"><?= $actor['name'] ?></h5>
                            <p class="card-text"><?= $actor['character'] ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="scrolling-wrapper">
            <?php $director = array_slice($data[0]['director'], 0, 3);?>
            <?php foreach($director as $directors): ?>
                <?php if (!empty($directors['profile_path']) && ($directors['job'] === 'Director')): ?>
                    <div class="card bg-dark text-white" style="width: 200px;">
                        <img src="https://image.tmdb.org/t/p/w200<?= $directors['profile_path'] ?>" alt="<?= $directors['name'] ?>" class="img-fluid">
                        <div class="card-body">
                        <h5 class="card-title"><?= $directors['name'] ?></h5>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>




    <?php require 'view_end.php';?>