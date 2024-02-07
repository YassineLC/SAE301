<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Content/css/bootstrap.min.css" rel="stylesheet">
    <link href="Content/css/view_home_style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Page d'accueil</title>
    <script>
        function updateFormAction() {
            var rechercheValue = document.getElementById('rechercher').value;
            var form = document.getElementById('myForm');
            form.action = "?controller=home&action=recherche&recherche=" + encodeURIComponent(rechercheValue);
        }
    </script>
</head>
<body>
    <div id="navbar">
        <a class="navbar-brand" href="#">
            <img src="Content/img/logo-le-septieme-art.png" alt="Logo">
        </a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#">COMMUN</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">RAPPROCHEMENT</a>
            </li>
        </ul>
        <form id="myForm" method="post" onsubmit="updateFormAction()" class="search-form">
            <input type="text" id="rechercher" name="rechercher" class="form-control" placeholder="Rechercher">
            <button type="submit" class="btn-primary">Confirmer</button>
        </form>
    </div>
    <script src="Content/js/bootstrap.bundle.min.js"></script>
