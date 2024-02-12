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

    <?php if (isset($_GET['recherche'])) : ?>

    <div class="container">

        <h1 id="titre-result">Résultats</h1>

        <?php foreach($data as $ligne) : ?>
            <div class="card mb-3 card-container" style="max-width: 1000px;">
                <div class="row no-gutters">
                    <div class="col-md-3">
                        <a href="?controller=details&action=details&tconst=<?= $ligne['tconst'] ?>">
                            <img src="https://image.tmdb.org/t/p/original/<?= $ligne['poster_path'] ?>" class="card-img" alt="<?= $ligne['originaltitle'] ?>">
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

    <?php else : ?>

        <h4 class="text-center text-white my-5" >Faites une recherche sur la barre de recherche pour afficher les résultats</h4>

    <?php endif ?>

    <script>
    $(document).ready(function() {
        $('#search-form').on('submit', function(event) {
            event.preventDefault(); // Empêche le rechargement de la page
            var rechercheValue = $('#search-input').val();
            var actionUrl = '?controller=home&action=recherche&recherche=' + encodeURIComponent(rechercheValue);
            $(this).attr('action', actionUrl);
            window.location.href = actionUrl;
        });

        // Écouteur d'événements pour la touche "Entrée"
        $('#search-input').keypress(function(event) {
            if (event.keyCode === 13) {
                $('#search-form').submit(); // Soumet le formulaire si la touche "Entrée" est pressée
            }
        });
    });
</script>


<script src="Content/js/bootstrap.min.js"></script>

<?php if (isset($_GET['recherche']))
    require 'view_end.php';
?>