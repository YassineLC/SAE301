<?php

function e($message)
{
    return htmlspecialchars($message, ENT_QUOTES);
}



function sendDataToModel($source, $target) {
    $scriptPath = '/var/www/html/GitHub/GRP/SAE301/scripts/rapprochement.py';
    
    // Construction de la commande
    $command = "python3 " . escapeshellarg($scriptPath) . " " . escapeshellarg($source) . " " . escapeshellarg($target);
    
    // Exécution du script Python et capture de la sortie
    $output = shell_exec($command);
    
    // Décodage de la sortie JSON en tableau PHP
    $result = json_decode($output, true);
    
    // Transmettre les données au modèle
    //$this->model->processData($result);
    return $output;
}

?>
