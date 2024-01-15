<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Content/css/bootstrap.min.css" rel="stylesheet">
    <title>Resultat</title>
</head>
<body class="p-3 mb-2 bg-dark text-white">

<div id="page">
<h1>Resultat</h1>

<a href="?controller=home&action=home" class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Retour</a>

<div class="p-4' rounded border border-blue"> 
    <ol>
        <?php foreach($data as $ligne) : ?>
        <li>
             <?= print_r($ligne) ?> 
        </li>
        <?php endforeach?>
    </ol>
</div>

</div>

<script src="Content/js/bootstrap.min.js"></script>
</body>
</html>

<?php
/*
<?php if ($ligne['poster_path']==0) : ?>
    <img src="Content/img/movie-poster-default.jpg" class="float-right w-25 h-25 p-3" />
<?php elseif (isset($ligne['poster_path'])) : ?>
    <img src=https://image.tmdb.org/t/p/original<?=$ligne['poster_path']?> class="float-right w-25 h-25 p-3" />

<?php endif?>
*/
?>