$(document).ready(function() {
    $('#papa').on('submit', function(event) {
        event.preventDefault(); // Empêche le rechargement de la page
        var param1 = $('#param1').val();
        var param2 = $('#param2').val();
        var actionUrl = '?controller=commun&action=commun&param1=' + encodeURIComponent(param1) + '&param2='+ encodeURIComponent(param2);
        $(this).attr('action', actionUrl);
        window.location.href = actionUrl;
    });

    // Écouteur d'événements pour la touche "Entrée"
    $('#daronne').keypress(function(event) {
        if (event.keyCode === 13) {
            $('#papa').submit(); // Soumet le formulaire si la touche "Entrée" est pressée
        }
    });
});

$('form').on('submit', function(e) {
e.preventDefault();
$('#loader').show();
$(this).hide();
});