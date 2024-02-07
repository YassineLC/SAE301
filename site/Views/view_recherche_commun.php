<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../Content/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Content/css/view_home_style.css" rel="stylesheet">
    <link href="../Content/css/view_test_style.css" rel="stylesheet">
    <title>Page commun</title>
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
        <nav class="navbar navbar-expand-lg navbar-dark rounded">
            <div class="container">
                <a class="navbar-brand me-auto" href="#">
                    <img src="../Content/img/logo-le-septieme-art.png" alt="Logo">
                </a>

                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="#">COMMUN</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">RAPPROCHEMENT</a>
                        </li>
                    </ul>
                </div>

                <div id="searchbar" class="ml-auto">
                    <form id="myForm" method="post" onsubmit="updateFormAction()" class="d-flex">
                        <input type="text" id="rechercher" name="rechercher" class="form-control me-2" placeholder="Rechercher">
                        <button type="submit" class="btn btn-primary">Confirmer</button>
                    </form>
                </div>
            </div>
        </nav>
    </div>
    <script src="../Content/js/bootstrap.bundle.min.js"></script>
    
    <div id="button">
        <button type="button" class="btn btn-light">Films</button>
        <button type="button" class="btn btn-light">Acteurs</button>
    </div>
    
    
    <div class="recherche1">
        <input type="text" id="search1" name="search1" class="recherche1_bis" placeholder="Entrer un film ou un acteur">
        <input type="text" id="search2" name="search2" class="recherche2_bis" placeholder="Entrer un film ou un acteur ">
        <button class="recherche_button" onclick="rechercher()">Rechercher</button>
    </div>


    <div class="recherche">
        <p class="texte">
        FILM JOUE EN COMMUN/ ACTEURS EN COMMUN
        </p>
    </div>

    <div class="resultat">
        <div class="texte text-center">
        RESULTAT
        </div>
    </div>

</body>
</html>