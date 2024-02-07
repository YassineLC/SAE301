<script src="Content/js/jquery-3.7.1.min.js.js"></script>

<script>
    $(document).ready(function() {
        $('#myForm').on('submit', function(event) {
            event.preventDefault(); // Empêche le rechargement de la page
            var rechercheValue = $('#rechercher').val();
            var actionUrl = '?controller=home&action=recherche&recherche=' + encodeURIComponent(rechercheValue);
            $(this).attr('action', actionUrl);
            window.location.href = actionUrl;
        });
    });
</script>


</head>
<body>
    <div id="navbar">
        <nav class="navbar navbar-expand-lg navbar-dark rounded">
            <div class="container">
                <a class="navbar-brand me-auto" href="?controller=home&action=home">
                    <img src="Content/img/logo-le-septieme-art.png" alt="Logo">
                </a>

                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=commun&action=commun">COMMUN</a>
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