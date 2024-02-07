<?php

require_once('Utils/API/vendor/autoload.php');

class Model {

    private $bd;

    private static $instance = null;

    private function __construct()
    {
        //Add your credentials here to connect to the database
        include "Utils/credentials.php";
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
        $requete = $this->bd->prepare("SELECT * FROM titlebasics JOIN titleratings USING(tconst) WHERE originaltitle ~* :expression ORDER BY numvotes DESC"); 
        $requete->bindValue(":expression", "$expression", PDO::PARAM_STR);
        $requete->execute();
        $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
    }

    public function recherche_avancee($expression, $filtres)
    {
        if (strlen($expression) < 3) 
        {
            return "Les recherches doivent avoir trois caractères minimum";
        }

        if ($filtres['type'] == 'film')
        {
            $sql = "SELECT * FROM titlebasics JOIN titleratings USING(tconst) WHERE SIMILARITY(originaltitle, :expression) > 0.4"; 
        }
        elseif($filtres['type'] == 'personne')
        {
            $sql = "SELECT * FROM namebasics WHERE SIMILARITY(primaryname, :expression) > 0.5"; 
        }

        $firstIteration = true;
        foreach($filtres as $filtre => $val)
        {
            if ($firstIteration) 
            {
                $firstIteration = false;
                continue;
            }
            if ($val == "") {
                continue ;
            }
            $val = $this->bd->quote($val); 
            if ($filtre == 'genres') {
                $sql .= ' and ' . $filtre . '~*' . $val;
            }
            else {
            $sql .= ' and ' . $filtre . '=' . $val;
            }

        }

        if ($filtres['type'] == 'film') {
            $sql.= 'ORDER BY numvotes DESC' ;
        }

        $sql .= ';'; 
        $requete = $this->bd->prepare($sql);
        $requete->bindParam(":expression", $expression, PDO::PARAM_STR);
        $requete->execute();
        $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
    }


    function recherche_commun($param1, $param2) {
        $query = '';
        $paramType = '';
    
        //Condition pour vérifier si ce sont des personnes
        if (strpos($param1, 'nm') === 0 && strpos($param2, 'nm') === 0) {
            $query = '
                SELECT DISTINCT tp.tconst, tb.primaryTitle
                FROM titleprincipals tp
                JOIN titlebasics tb ON tp.tconst = tb.tconst
                JOIN titleprincipals tp2 ON tp.tconst = tp2.tconst
                JOIN namebasics nb ON tp2.nconst = nb.nconst
                WHERE tp.nconst = :person1 AND tp2.nconst = :person2
            ';
            $paramType = 'people';
    
        // Autre condition pour vérifier si ce sont des films
        } elseif (strpos($param1, 'tt') === 0 && strpos($param2, 'tt') === 0) {
            // Les deux paramètres sont des films
            $query = '
                SELECT DISTINCT nb.nconst, nb.primaryName
                FROM titleprincipals tp
                JOIN namebasics nb ON tp.nconst = nb.nconst
                JOIN titleprincipals tp2 ON tp.nconst = tp2.nconst
                JOIN titlebasics tb ON tp2.tconst = tb.tconst
                WHERE tp.tconst = :movie1 AND tp2.tconst = :movie2
            ';
            $paramType = 'movies';
        } else {
            echo "Paramètres invalides ! Veuillez mettre des paramètres correct svp";
            return;
        }
    
        $stmt = $this->bd->prepare($query);
    
        if ($paramType === 'people') {
            $stmt->bindParam(':person1', $param1, PDO::PARAM_STR);
            $stmt->bindParam(':person2', $param2, PDO::PARAM_STR);
        } elseif ($paramType === 'movies') {
            $stmt->bindParam(':movie1', $param1, PDO::PARAM_STR);
            $stmt->bindParam(':movie2', $param2, PDO::PARAM_STR);
        }
    
        $stmt->execute();
    
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if ($paramType === 'people') {
            echo "Ensemble des films en commun :";
        } elseif ($paramType === 'movies') {
            echo "Ensemble des personnes en commun :";
        }
    
        return $result;
    }

    public function getMoviesInfo($number) {
        $sql = "SELECT tb.tconst, tb.primarytitle, tr.averagerating, tr.numvotes
                FROM titlebasics tb
                JOIN titleratings tr ON tb.tconst = tr.tconst
                WHERE tb.startyear = EXTRACT(YEAR FROM CURRENT_DATE) - 1
                AND tb.titletype = 'movie'
                ORDER BY tr.numvotes DESC
                LIMIT :number ;";
        $requete = $this->bd->prepare($sql);
        $requete->bindParam(":number", $number, PDO::PARAM_INT);
        $requete->execute();
        $result = $requete->fetchAll(PDO::FETCH_ASSOC);

        require_once('Utils/API/vendor/autoload.php');
            
            $client = new \GuzzleHttp\Client();

        $posters = [];

        foreach($result as $film) {
            $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/' . $film['tconst'] . '?language=en-US', [
              'headers' => [
                'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI2NzAxNTJmZGQ1ZWYyMmUyYzdkNmRkZmQ1NzIyNzE3NyIsInN1YiI6IjY1OWQ2YmRiYjZjZmYxMDFhNjc0OWQyOSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.XMVnYm5EpfHU2S-X3FojIPw0CyNkvu8fEppBrw0Bt5s',
                'accept' => 'application/json',
              ],
            ]);

            $data = json_decode($response->getBody(), true);
            array_push($posters, $data);
        }
        return $posters;
    }
}


