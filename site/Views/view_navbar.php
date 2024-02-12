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

<body>
    <div id="navbar">
        <a class="navbar-brand" href="?controller=home&action=home">
            <img src="Content/img/logo-le-septieme-art.png" alt="Logo">
        </a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="?controller=commun&action=commun">COMMUN</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">RAPPROCHEMENT</a>
            </li>
        </ul>
        <form id="myForm" method="post" onsubmit="updateFormAction()" class="search-form">
            <input type="text" id="rechercher" name="rechercher" class="form-control" placeholder="Rechercher">
            <button id="navbar-submit" type="submit" class="btn-primary">Confirmer</button>
        </form>
    </div>
    <script src="Content/js/bootstrap.bundle.min.js"></script>