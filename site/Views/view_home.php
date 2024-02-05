<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Content/css/bootstrap.min.css" rel="stylesheet">
    <link href="Content/css/test.css" rel="stylesheet">
    <title>Page d'accueil</title>
    <script>
        function updateFormAction() {
            var rechercheValue = document.getElementById('rechercher').value;
            var form = document.getElementById('myForm');
            form.action = "?controller=home&action=recherche&recherche=" + encodeURIComponent(rechercheValue);
        }
    </script>
    <style>
        .feature-hover {
    transition: background-color 0.3s ease;
}

.feature-hover:hover {
    background-color: #your-hover-color; /* Replace with your desired hover color */
}

.feature-block:focus .feature-hover,
.feature-block:focus-within .feature-hover {
    background-color: #your-hover-color; /* Replace with your desired hover color */
}
    </style>
</head>
<body>
    <div id="navbar">
        <nav class="navbar navbar-expand-lg navbar-dark rounded">
            <div class="container">
                <a class="navbar-brand me-auto" href="#">
                    <img src="Content/img/logo-le-septieme-art.png" alt="Logo">
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
    <script src="Content/js/bootstrap.bundle.min.js"></script>
    
    <section class="my-5">
    <h2 class="h2 mb-4">NOUVEAUTÉS</h2>
    <div class="row row-cols-1 row-cols-md-4 g-4">
        <!-- Repeat for each movie item -->
        <div class="col">
            <img src="https://placehold.co/220x330?text=Movie+Thumbnail&fontsize=25" alt="Movie thumbnail for 'Movie Title'" class="img-fluid rounded">
        </div>
        <div class="col">
            <img src="https://placehold.co/220x330?text=Movie+Thumbnail&fontsize=25" alt="Movie thumbnail for 'Movie Title'" class="img-fluid rounded">
        </div>
        <!-- ... -->
    </div>
    </section>

    <section id="fonctionnalites" class="py-8 text-white">
        <div class="container">
            <hr class="border-gray-800">
            <h2 id="fonc-title" class="text-2xl font-semibold my-5 text-center">FONCTIONNALITÉS</h2>
            <div class="row g-4 justify-content-center">

                <div class="features-grid">

                <!-- Row 1 -->
                <div class="row">

                    <!-- Feature 1 -->
                    <div class="feature col-md-6">
                        <a class="feature-block text-decoration-none">
                            <div class="fonc-box feature-content p-4">
                                <i class="fas fa-search-plus fa-2x"></i>
                                <h3 class="text-center text-xl font-semibold mt-2">RECHERCHES SIMPLES</h3>
                                <p feature-text>La recherche simple permet à l'utilisateur de faire une recherche sur un film ou un acteur en tapant simplement son intitulé (nom du film, nom/prénom de l'acteur)</p>
                            </div>
                        </a>
                    </div>

                    <!-- Feature 2 -->
                    <div class="col-md-6">
                        <a class="feature-block text-decoration-none">
                            <div class="fonc-box feature-content p-4">
                                <i class="fas fa-cogs fa-2x"></i>
                                <h3 class="text-center text-xl font-semibold mt-2">RECHERCHES AVANCÉES</h3>
                                <p>La recherche avancée permet une recherche plus poussée que la recherche simple, notamment en laissant plus de filtres à l'utilisateur (genre, pays, année, etc..)</p>
                            </div>
                        </a>
                    </div>

                </div>
                
                <!-- Row 2 -->
                <div class="row">

                    <!-- Feature 3 -->
                    <div class="feature col-md-6">
                        <a class="feature-block text-decoration-none">
                            <div class="fonc-box feature-content p-4">
                                <i class="fas fa-search-plus fa-2x"></i>
                                <h3 class="text-center text-xl font-semibold mt-2">COMMUN</h3>
                                <p feature-text>La recherche simple permet à l'utilisateur de faire une recherche sur un film ou un acteur en tapant simplement son intitulé (nom du film, nom/prénom de l'acteur)</p>
                            </div>
                        </a>
                    </div>

                    <!-- Feature 4 -->
                    <div class="feature col-md-6">
                        <a class="feature-block text-decoration-none">
                            <div class="fonc-box feature-content p-4">
                                <i class="fas fa-search-plus fa-2x"></i>
                                <h3 class="text-center text-xl font-semibold mt-2">RAPPROCHEMENT</h3>
                                <p feature-text>La recherche "Rapprochement" permet de relier deux films ou personnes par une chaîne de personnes et films la plus courte possible suivant la relation “X a participé au film Y”</p>
                            </div>
                        </a>
                    </div>

                </div>

                </div>

            </div>
        </div>
    </section>

</body>
</html>
