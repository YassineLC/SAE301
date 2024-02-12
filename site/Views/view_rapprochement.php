<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Content/img/favicon.ico" rel="icon">
    <link href="Content/css/bootstrap.min.css" rel="stylesheet">
    <link href="Content/css/view_navbar_style.css" rel="stylesheet">
    <link href="Content/css/view_home_style.css" rel="stylesheet">
    <link href="Content/css/view_rapprochement_style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Le Septieme Art - Rapprochement</title>

    <?php require 'view_navbar.php'; ?>

    <div class="recherche1">
        <input type="text" id="search1" name="search1" class="recherche1_bis" placeholder="Entrer un film ou un acteur">
        <input type="text" id="search2" name="search2" class="recherche2_bis" placeholder="Entrer un film ou un acteur ">
        <button class="recherche_button" onclick="rechercher()">Rechercher</button>
    </div>

    <div class="recherche">
        <p> En attente de recherche </p>
    </div>

    <?php require 'view_end.php'; ?>    