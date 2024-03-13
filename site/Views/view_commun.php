<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Content/css/bootstrap.min.css" rel="stylesheet">
    <link href="Content/css/view_resultat_style.css" rel="stylesheet">
    <link href="Content/css/view_home_style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Le Septieme Art - Commun </title>

    <?php require 'view_navbar.php';?>

        <div class="recherche1">
        <form method="GET" id="papa" onsubmit="updateForm()">
            <input type="text" id="param1" name="param1" class="recherche1_bis" placeholder="Entrer un film ou un acteur">
            <input type="text" id="param2" name="param2" class="recherche2_bis" placeholder="Entrer un film ou un acteur ">
            <button type="submit" class="recherche_button" id="daronne">Rechercher</button>
        </form>
        </div>

        <div class="resultat">
            <div class="texte">
                <?php if(isset($data) && !empty($data)): ?>
                    <ul class="list-group">
                        <?php foreach($data as $film): ?>
                            <li class="list-group-item"><?= htmlspecialchars($film['primarytitle']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>En attente de recherche</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="Content/js/view_resultat_commun.js"></script>

            <div class="form-group row">
                <div class="col-md-12">
                    <input type="text" id="search2" name="search2" class="input-film col-md-14 offset-md-3 text-center" placeholder="Entrer un film ou un acteur ">
                </div>
            </div>

          
            <button type="button" class="btn btn-primary" onclick="recherche_commun()">Rechercher</button>

    </form>

    <div class="d-flex justify-content-center">
        <div class="spinner-border text-light" id="loader" role="status" style="display: none;">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <!-- Résultats de la recherche -->
    <?php if (isset($_GET['recherche1']) && isset($_GET['recherche2'])) : ?>
    <div class="container">
        <?php if (!empty($data)) : ?>
            <h1>Résultats de la recherche</h1>
            <div class="row">
                <?php foreach ($data as $result) : ?>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= $result['titre'] ?></h5>
                                <!-- Afficher d'autres informations du résultat si nécessaire -->
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p>Aucun résultat trouvé </p>
        <?php endif; ?>
    </div>
    <?php else : ?>
        <h4 class="text-center text-white my-5" >Entrez un film/acteur sur la barre de recherche pour afficher les personnes en commun</h4>
    <?php endif ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="Content/js/view_resultat.js"></script>
    <script>
        // Fonction de recherche
        function recherche_commun() {
            var search1 = $('#search1').val();
            var search2 = $('#search2').val();
            var actionUrl = '?controller=commun&action=recherche_commun&recherche1=' + encodeURIComponent(search1) + '&recherche2=' + encodeURIComponent(search2);
            window.location.href = actionUrl;
        }

        $(document).ready(function() {
            $('#search-form').on('submit', function(event) {
                event.preventDefault(); // Empêche le rechargement de la page
                recherche_commun(); // Appel de la fonction de recherche lors de la soumission du formulaire
            });
        });
    </script>
    
   




<?php require 'view_end.php';?>