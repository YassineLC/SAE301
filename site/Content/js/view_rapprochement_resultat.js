$(document).ready(function() {
    $('#myForme').on('submit', function(event) {
        event.preventDefault(); // Empêche le rechargement de la page
        var sourceValue = document.getElementById('source').value;
        var targetValue = document.getElementById('target').value;    
        var actionUrl = `?controller=rapprochement&action=rapprochement&source=${encodeURIComponent(sourceValue)}&target=${encodeURIComponent(targetValue)}`;
        $(this).attr('action', actionUrl);
        window.location.href = actionUrl;
    });

    // Écouteur d'événements pour la touche "Entrée"
    $('#').keypress(function(event) {
        if (event.keyCode === 13) {
            $('#submitBtn').click(); 
        }
    });
});

$('form').on('submit', function(e) {
e.preventDefault();
$('#loader').show();
$(this).hide();
});

function prepareAndSubmitForm() {
    // Récupérer les valeurs des champs
    var sourceValue = document.getElementById('source').value;
    var targetValue = document.getElementById('target').value;
    // Construire l'URL
    //var formAction = "?controller=rapprochement&action=rapprochement&source=" + encodeURIComponent(sourceValue) + "&target=" + encodeURIComponent(targetValue);
    var formAction = `?controller=rapprochement&action=rapprochement&source=${encodeURIComponent(sourceValue)}&target=${encodeURIComponent(targetValue)}`;

    // Mettre à jour l'attribut 'action' du formulaire
    var form = document.getElementById('myForme');
    form.action = formAction;
}