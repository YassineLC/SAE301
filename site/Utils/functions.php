<?php

function e($message)
{
    return htmlspecialchars($message, ENT_QUOTES);
}

function recherche($expression) {
    if (strlen($expression) < 3) {
        return "Les recherches doivent avoir trois caractères minimum";
    }
    $bdd = Model::getModel();
    $requete = $bdd->prepare("SELECT * FROM titlebasics WHERE originaltitle ~* :expression"); 
    $requete->bindValue(":expression", "$expression", PDO::PARAM_STR);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

?>