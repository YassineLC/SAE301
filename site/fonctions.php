<?php

require "connexion.php";

function recherche($expression) {
    if (strlen($expression) < 3) {
        return "Les recherches doivent avoir trois caractères minimum";
    }
    global $bdd; 
    $requete = $bdd->prepare("SELECT * FROM titlebasics WHERE originaltitle ~* :expression"); 
    $requete->bindValue(":expression", "$expression", PDO::PARAM_STR);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

$resultats = recherche("star wars");

foreach($resultats as $result) {
    echo $result['originaltitle'] . "\t";
}