<?php

class Model
{

    private $bd;

    private static $instance = null;

    private function __construct()
    {
        include "./Utils/connexion.php";
        $this->bd = new PDO("pgsql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
        $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->bd->query("SET nameS 'utf8'");
    }

    public static function getModel()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function recherche($expression) 
    {
        if (strlen($expression) < 3) {
            return "Les recherches doivent avoir trois caractères minimum";
        }
        $requete = $this->bd->prepare("SELECT * FROM titlebasics WHERE originaltitle ~* :expression"); 
        $requete->bindValue(":expression", "$expression", PDO::PARAM_STR);
        $requete->execute();
        $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
    }
}