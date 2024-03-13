<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Content/css/bootstrap.min.css" rel="stylesheet">
    <link href="Content/img/favicon.ico" rel="icon">
    <link href="Content/css/view_navbar_style.css" rel="stylesheet">
    <link href="Content/css/view_home_style.css" rel="stylesheet">
    <link href="Content/css/view_commun_style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Le Septieme Art - Commun </title>

    <?php require "view_navbar.php";?>

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

    <?php require "view_end.php";?>