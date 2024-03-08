<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Content/css/bootstrap.min.css" rel="stylesheet">
    <link href="Content/css/view_home_style.css" rel="stylesheet">
    <link rel="stylesheet" href="Content/css/styles_recherche_avancee.css">

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

    <?php require 'view_navbar.php';?>

    <div class="carre">
        <div class="texte">
            Recherche avancée
        </div>
    </div>
    
    <div class="button">
        <button type="button" class="btn btn-light" onclick="updateFilters('films')">Films</button>
        <button type="button" class="btn btn-light" onclick="updateFilters('acteurs')">Acteurs</button>
    </div>
    
    <div class="resultat-container">
        <div class="gauche">
            <div class="filtre">
                <div>Filtres</div>
            </div>
        </div>
        <div class="droite">
            <div class="recherche">
                <input type="text" class="crecherche" placeholder="Recherche">
            </div>
            <div class="resultat">
                <div class="texte">
                    RESULTAT 
                </div>
            </div>
        </div>
    </div>
    
    <?php require "view_end.php";?>
    


    
    <script src="Content/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateFilters(type) {
            var filtersDiv = document.querySelector('.filtre');
    
            filtersDiv.innerHTML = "<div>Filtres</div>";
    
            if (type === 'films') {
            filtersDiv.innerHTML += "<label>Type: <select><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select></label> <br>";
            filtersDiv.innerHTML += "<label>Genre: <select><option value='Action'>Action</option><option value='Comedy'>Comédie</option><option value='Drama'>Drama</option></select></label>";
            } else if (type === 'acteurs') {
                filtersDiv.innerHTML += "<label>Type: <select><option value='Acteur'>Acteur</option><option value='Réalisateur'>Réalisateur</option></select></label>";
                filtersDiv.innerHTML += "<label>Année de naissance: <input type='text' name='birthyear'></label>";
                filtersDiv.innerHTML += "<label>Année de décès: <input type='text' name='deathyear'></label>";
                filtersDiv.innerHTML += "<label>Profession principale: <input type='text' name='primaryprofession'></label>";
            }
        }
    </script>
</body>
</html>