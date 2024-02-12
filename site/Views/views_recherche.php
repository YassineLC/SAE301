<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Content/css/bootstrap.min.css" rel="stylesheet">
    <link href="Content/css/view_home.css" rel="stylesheet">
    <link rel="stylesheet" href="Content/css/styles_recherche.css">
    <link href="Content/img/favicon.ico" rel="icon">
    <link href="Content/css/bootstrap.min.css" rel="stylesheet">
    <link href="Content/css/view_navbar_style.css" rel="stylesheet">
    <link href="Content/css/view_home_style.css" rel="stylesheet">
    <link href="Content/css/view_avancee_style.css" rel="stylesheet">
    <link href="Content/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Le Septieme Art - Recherche avancée </title>

    <title>Page d'accueil</title>
    <script>
        function updateFormAction() {
            var rechercheValue = document.getElementById('rechercher').value;
            var form = document.getElementById('myForm');
            form.action = "?controller=home&action=recherche&recherche=" + encodeURIComponent(rechercheValue);
        }
    </script>
</head>
<?php require="view_navbar.php";?>

  
    <div class="carre">
        <div class="texte">
            Recherche avancée
        </div>
    </div>
        <div class="button">
            <button type="button" class="btn btn-light">Films</button>
            <button type="button" class="btn btn-light">Acteurs</button>
        </div>
        <div class="recherche">
            <input type="text" class="crecherche" placeholder="Recherche">
        </div>

    

    <div class="resultat">
        <div class="texte">
            RESULTAT 
        </div>
    </div>
    <script src="Content/js/bootstrap.bundle.min.js"></script>
<?php require="view_end.php";?>
</html>