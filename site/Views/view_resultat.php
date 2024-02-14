<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Content/css/bootstrap.min.css" rel="stylesheet">
    <link href="Content/css/view_resultat_style.css" rel="stylesheet">
    <link href="Content/css/view_home_style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Resultat</title>
</head>
<body>

    <?php require 'view_navbar.php';?>

    <form id="search-form" method="post" onsubmit="updateFormAction()" class="search-form">
        <input id="search-input" class="input-film col-md-6 offset-md-3 text-center" type="text" placeholder="Rechercher un film">
    </form>

    <div class="d-flex justify-content-center">
        <div class="spinner-border text-light" id="loader" role="status" style="display: none;">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <?php if (isset($_GET['recherche'])) : ?>

    <div class="container">

        <h1 id="titre-result">Résultats</h1>

        <div id="results-container">

        <?php foreach($data as $ligne) : ?>
            <div class="card mb-3 card-container" style="max-width: 1000px;">
                <div class="row no-gutters">
                    <div class="col-md-3">
                        <a href="?controller=details&action=details&tconst=<?= $ligne['tconst'] ?>">
                            <img src="https://image.tmdb.org/t/p/original/<?= $ligne['poster_path'] ?>" class="card-img poster-img" alt="<?= $ligne['originaltitle'] ?>">
                        </a>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <a href="?controller=details&action=details&tconst=<?= $ligne['tconst'] ?>">
                                <h5 class="card-title"><?= $ligne['originaltitle'] ?></h5>
                            </a>
                            <a class="card-text"><small class="text-muted"><?= $ligne['startyear'] ?></small></a>
                            <p class="card-text"><?= $ligne['overview'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>

        </div>

    </div>

    <?php else : ?>
        <h4 class="text-center text-white my-5" >Faites une recherche sur la barre de recherche pour afficher les résultats</h4>
    <?php endif ?>

    <script src="Content/js/view_resultat.js"></script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php if (isset($_GET['recherche']))
    require 'view_end.php';
?>