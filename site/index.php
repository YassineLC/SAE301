<?php

require "connexion.php";

function approximation($expression) {
    $requete = $bdd->prepare('SELECT * FROM titlebasics WHERE tconst = \':expression\''); 
    $requete->bindValue(":expression", $expression, PDO::PARAM_STR);
    $requete->execute();
    $resultat = $requete->fetch();
}