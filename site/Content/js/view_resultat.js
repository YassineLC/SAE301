$(document).ready(function() {
    $('#search-form').on('submit', function(event) {
        event.preventDefault(); // Empêche le rechargement de la page
        var rechercheValue = $('#search-input').val();
        var actionUrl = '?controller=home&action=recherche&recherche=' + encodeURIComponent(rechercheValue);
        $(this).attr('action', actionUrl);
        window.location.href = actionUrl;
    });

    // Écouteur d'événements pour la touche "Entrée"
    $('#search-input').keypress(function(event) {
        if (event.keyCode === 13) {
            $('#search-form').submit(); // Soumet le formulaire si la touche "Entrée" est pressée
        }
    });
});

$('form').on('submit', function(e) {
e.preventDefault();
$('#loader').show();
$(this).hide();
});