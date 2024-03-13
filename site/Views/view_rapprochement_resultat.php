<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Content/css/bootstrap.min.css" rel="stylesheet">
    <link href="Content/css/view_rapprochement_resultat.css" rel="stylesheet"> 
    <link href="Content/css/view_home_style.css" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Rapprochement</title>
</head>
<body>

    <?php require 'view_navbar.php';?>
    
    <form id="myForme" method="post" onsubmit="prepareAndSubmitForm()">
        <input type="text" id="source" name="source" class="input-film col-md-6 offset-md-3 text-center" placeholder="Entrer un(e) acteur/actrice source">
        <input type="text" id="target" name="target" class="input-film col-md-6 offset-md-3 text-center" placeholder="Entrer un(e) acteur/actrice cible ">
        <button type="submit" id="submitBtn" class="btn-primary">Confirmer</button>
    </form>

    <div class="d-flex justify-content-center">
        <div class="spinner-border text-light" id="loader" role="status" style="display: none;">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <?php if (isset($_GET['source']) && isset($_GET['target'])) : ?>
    <div class="container">
        <?php $donnees = $data['additional_data']; ?>
        <h1 id="titre-result">Résultats</h1></br>
        <div id="results-container">
            <?php if ($data['status'] == 'success') : ?>
                <?php foreach($donnees as $index => $ligne) : ?>
                    <div class="text-center card mb-3 card-container" style="max-width: 1000px;">
                        <div class="row no-gutters">
                            <div class="col-md-3">
                                <?php $href = $ligne['type'] === 'movie' ? "?controller=details&action=details&tconst={$ligne['id']}" : "?controller=details&action=details&nconst={$ligne['id']}";
                                if ($ligne['type'] === 'movie') {
                                    $imgSrc = isset($ligne['poster_path']) && $ligne['poster_path'] ? "https://image.tmdb.org/t/p/original/{$ligne['poster_path']}" : "Content/img/default-movie.jpg";
                                } else {
                                    $imgSrc = isset($ligne['profile_path']) && $ligne['profile_path'] ? "https://image.tmdb.org/t/p/w600_and_h900_bestv2{$ligne['profile_path']}" : "Content/img/default-person.jpg";
                                }
                                ?>
                                <a href="<?= $href ?>">
                                    <?php $imgSrc = $ligne['type'] === 'movie' ? "https://image.tmdb.org/t/p/original/{$ligne['poster_path']}" : "https://image.tmdb.org/t/p/w600_and_h900_bestv2{$ligne['profile_path']}"; ?>
                                    <img src="<?= $imgSrc ?>" class="card-img <?= $ligne['type'] === 'movie' ? 'poster-img' : 'rounded' ?>" alt="<?= $ligne['type'] === 'movie' ? $ligne['title'] : $ligne['name'] ?>">
                                </a>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <a href="<?= $href ?>">
                                        <h5 class="card-title"><?= $ligne['type'] === 'movie' ? $ligne['title'] : $ligne['name'] ?></h5>
                                    </a>
                                    <?php if ($ligne['type'] === 'movie') : ?>
                                        <p class="card-text"><small class="text-muted"><?= $ligne['release_date'] ?></small></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($ligne['type'] === 'movie') : ?>
                        <?php if ($index < count($donnees) - 1) : ?>
                            <p class="text-between-cards" style="max-width: 1000px;">→ dont a joué aussi →</p>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if ($index < count($donnees) - 1) : ?>
                            <p class="text-between-cards" style="max-width: 1000px;">→ a joué dans →</p>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="text-center">
                    <img src="Content/img/rapprochement_oups.gif" alt="Chargement..." style="height:auto;">
                    <p class="oups">Aucun chemin trouvé, vérifiez l'orthographe</p>
                </div>
                <h4 class="text-center text-white my-5" >Entrez les prenoms et noms de deux acteurs/actrices dans les emplacements de recherche pour afficher les résultats</h4>
                <h5 class="text-center text-white my-5" >Les prénoms et noms doivent avoir des majuscules et être bien écrit</h5>
                <h6 class="text-center text-white my-5" >Exemple : Robert Downey Jr. et Richard S. Castellano</h6>
            <?php endif; ?>
        </div>
    </div>

    <?php else : ?>
        <h4 class="text-center text-white my-5" >Entrez les prenoms et noms de deux acteurs/actrices dans les emplacements de recherche pour afficher les résultats</h4>
        <h5 class="text-center text-white my-5" >Les prénoms et noms doivent avoir des majuscules et être bien écrit</h5>
        <h6 class="text-center text-white my-5" >Exemple : Robert Downey Jr. et Richard S. Castellano</h6>


    <?php endif ?>
    <?php print_r($data); ?>
    

   <script src="Content/js/view_rapprochement_resultat.js"></script> 


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php if (isset($_GET['source']) && isset($_GET['target']))
    require 'view_end.php';
?>
