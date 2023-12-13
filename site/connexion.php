<?php
$dbHost = 'localhost'; 
$dbUser = 'yassine';
$dbPass = 'toor';
$dbName = 'sae';

try {
    $bdd = new PDO("pgsql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    exit;
}

?>