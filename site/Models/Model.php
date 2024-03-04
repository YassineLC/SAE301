<?php

require_once('Utils/API/vendor/autoload.php');

class Model {

    private $bd;

    private static $instance = null;

    private function __construct()
    {
        //Ajouter les informations de connexion à la base de données dans credentials.php
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

        // Exécute la requête SQL pour récupérer les données de la base de données
        $requete = $this->bd->prepare("SELECT * FROM titlebasics JOIN titleratings USING(tconst) WHERE originaltitle ~* :expression ORDER BY numvotes DESC LIMIT 30"); 
        $requete->bindValue(":expression", "$expression", PDO::PARAM_STR);
        $requete->execute();
        $resultats_bdd = $requete->fetchAll(PDO::FETCH_ASSOC);

        require_once('Utils/API/vendor/autoload.php');
        $client = new \GuzzleHttp\Client();
        $donnees = [];

        // Parcours des résultats de la base de données
        foreach($resultats_bdd as $film_bdd) {
            try {
                // Fait une requête à l'API pour obtenir les données supplémentaires
                $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/' . $film_bdd['tconst'] . '?language=fr-fr', [
                    'headers' => [
                        'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI2NzAxNTJmZGQ1ZWYyMmUyYzdkNmRkZmQ1NzIyNzE3NyIsInN1YiI6IjY1OWQ2YmRiYjZjZmYxMDFhNjc0OWQyOSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.XMVnYm5EpfHU2S-X3FojIPw0CyNkvu8fEppBrw0Bt5s',
                        'accept' => 'application/json',
                    ],
                ]);

                if ($response->getStatusCode() === 404) {
                    // Passe au film suivant si le film n'est pas trouvé dans l'API
                    continue;
                }

                if ($response->getStatusCode() === 200) {
                    $donnees_film_api = json_decode($response->getBody(), true);

                    // Vérifie si le film a un poster
                    if (isset($donnees_film_api['poster_path'])) {
                        // Fusionne les données de la base de données avec les données de l'API
                        $donnees_fusionnees = array_merge($film_bdd, $donnees_film_api);

                        $donnees[] = $donnees_fusionnees;
                    }
                }
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                // Gère l'exception si la requête échoue
                continue;
            }
        }
        
        return $donnees;
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

    #Recherche Commun Obsolète
    function recherche_commun2($param1, $param2) {
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
    //NEW Recherche commun
    function recherche_commmun($param1, $param2, $db) {
        // Requête pour obtenir l'ID du premier paramètre
        $stmtId1 = $db->prepare('SELECT nconst FROM namebasics WHERE primaryname = :name1');
        $stmtId1->bindParam(':name1', $param1, PDO::PARAM_STR);
        $stmtId1->execute();
        $id1 = $stmtId1->fetchColumn();
    
        // Requête pour obtenir l'ID du deuxième paramètre
        $stmtId2 = $db->prepare('SELECT nconst FROM namebasics WHERE primaryname = :name2');
        $stmtId2->bindParam(':name2', $param2, PDO::PARAM_STR);
        $stmtId2->execute();
        $id2 = $stmtId2->fetchColumn();
    
        // Requête pour trouver des films en commun
        $query = '
            SELECT DISTINCT tb.tconst, tb.primarytitle
            FROM titleprincipals tp
            JOIN titlebasics tb ON tp.tconst = tb.tconst
            WHERE tp.nconst = :id1
            AND tb.tconst IN (
                SELECT tp2.tconst
                FROM titleprincipals tp2
                WHERE tp2.nconst = :id2
            )
        ';
    
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id1', $id1, PDO::PARAM_STR);
        $stmt->bindParam(':id2', $id2, PDO::PARAM_STR);
        $stmt->execute();
    
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        echo "Ensemble des films en commun :";
        print_r($result);
    }

    public function getIndexMovies($number) {
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

        $donnees = [];

        foreach($result as $film) {
            $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/' . $film['tconst'] . '?language=fr-fr', [
              'headers' => [
                'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI2NzAxNTJmZGQ1ZWYyMmUyYzdkNmRkZmQ1NzIyNzE3NyIsInN1YiI6IjY1OWQ2YmRiYjZjZmYxMDFhNjc0OWQyOSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.XMVnYm5EpfHU2S-X3FojIPw0CyNkvu8fEppBrw0Bt5s',
                'accept' => 'application/json',
              ],
            ]);

            $data = json_decode($response->getBody(), true);
            $data['tconst'] = $film['tconst'];
            $data['primarytitle'] = $film['primarytitle'];
            $data['averagerating'] = $film['averagerating'];
            $data['numvotes'] = $film['numvotes'];
            array_push($donnees, $data);
        }
        return $donnees;
    }

    public function graphe($expression)
    {
        $requete = $this->bd->prepare("SELECT nconst, primaryname, primaryprofession, knownfortitles FROM namebasics WHERE primaryname ~* :expression AND cardinality(string_to_array(knownfortitles, ',')) > 2 AND 'actor' = any(string_to_array(primaryprofession, ',')) limit(1);"); 
        $requete->bindValue(":expression", "$expression", PDO::PARAM_STR);
        $requete->execute();
        $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
    }

    public function getMovieInfo($tconst) {
        $requete = $this->bd->prepare("SELECT * FROM titlebasics tb JOIN titleratings tr ON tb.tconst = tr.tconst WHERE tb.tconst = :tconst"); 
        $requete->bindValue(":tconst", "$tconst", PDO::PARAM_STR);
        $requete->execute();
        $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

        require_once('Utils/API/vendor/autoload.php');
        $client = new \GuzzleHttp\Client();

        foreach($resultat as &$movie) {
            // First API request to get basic movie info
            $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/' . $movie['tconst'] . '?language=fr-fr', [
                'headers' => [
                    'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI2NzAxNTJmZGQ1ZWYyMmUyYzdkNmRkZmQ1NzIyNzE3NyIsInN1YiI6IjY1OWQ2YmRiYjZjZmYxMDFhNjc0OWQyOSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.XMVnYm5EpfHU2S-X3FojIPw0CyNkvu8fEppBrw0Bt5s',
                    'accept' => 'application/json',
                ],
            ]);

            $movieData = json_decode($response->getBody(), true);
            $movie = array_merge($movie, $movieData);

            // Second API request to get cast info
            $castResponse = $client->request('GET', 'https://api.themoviedb.org/3/movie/' . $movie['tconst'] . '/credits', [
                'headers' => [
                    'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI2NzAxNTJmZGQ1ZWYyMmUyYzdkNmRkZmQ1NzIyNzE3NyIsInN1YiI6IjY1OWQ2YmRiYjZjZmYxMDFhNjc0OWQyOSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.XMVnYm5EpfHU2S-X3FojIPw0CyNkvu8fEppBrw0Bt5s',
                    'accept' => 'application/json',
                ],
            ]);

            $castData = json_decode($castResponse->getBody(), true);

            // Filter only actors (known_for_department: "Acting")
            $actors = array_filter($castData['cast'], function($person) {
                return $person['known_for_department'] == 'Acting';
            });

            $movie['actors'] = $actors;
        }

            return $resultat;
        }

        public function getPersonInfo($nconst) {
            $requete = $this->bd->prepare("SELECT * FROM namebasics WHERE nconst = :nconst"); 
            $requete->bindValue(":nconst", "$nconst", PDO::PARAM_STR);
            $requete->execute();
            $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

            require_once('Utils/API/vendor/autoload.php');
            $client = new \GuzzleHttp\Client();

            $response = $client->request('GET', 'https://api.themoviedb.org/3/find/' . $nconst . '?external_source=imdb_id&language=fr-fr', [
                'headers' => [
                    'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI2NzAxNTJmZGQ1ZWYyMmUyYzdkNmRkZmQ1NzIyNzE3NyIsInN1YiI6IjY1OWQ2YmRiYjZjZmYxMDFhNjc0OWQyOSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.XMVnYm5EpfHU2S-X3FojIPw0CyNkvu8fEppBrw0Bt5s',
                    'accept' => 'application/json',
                ],
            ]);

            $personData = json_decode($response->getBody(), true);

            $personID = $personData['person_results'][0]['id'];

            $personCreditsResponse = $client->request('GET', 'https://api.themoviedb.org/3/person/' . $personID . '?language=fr-fr', [
                'headers' => [
                    'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI2NzAxNTJmZGQ1ZWYyMmUyYzdkNmRkZmQ1NzIyNzE3NyIsInN1YiI6IjY1OWQ2YmRiYjZjZmYxMDFhNjc0OWQyOSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.XMVnYm5EpfHU2S-X3FojIPw0CyNkvu8fEppBrw0Bt5s',
                    'accept' => 'application/json',
                ],
            ]);

            $personCreditsData = json_decode($personCreditsResponse->getBody(), true);

            $data = array_merge($resultat[0], $personCreditsData);

            // Vérifier si la biographie est vide
            if (empty($data['biography'])) {
                $personBioResponse = $client->request('GET', 'https://api.themoviedb.org/3/person/' . $personID . '?language=en-US', [
                    'headers' => [
                        'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI2NzAxNTJmZGQ1ZWYyMmUyYzdkNmRkZmQ1NzIyNzE3NyIsInN1YiI6IjY1OWQ2YmRiYjZjZmYxMDFhNjc0OWQyOSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.XMVnYm5EpfHU2S-X3FojIPw0CyNkvu8fEppBrw0Bt5s',
                        'accept' => 'application/json',
                    ],
                ]);

                $personBioData = json_decode($personBioResponse->getBody(), true);

                $data['biography'] = $personBioData['biography'];
            }

            $personMovies = $client->request('GET', 'https://api.themoviedb.org/3/find/' . $nconst . '?external_source=imdb_id&language=fr-fr', [
                'headers' => [
                    'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI2NzAxNTJmZGQ1ZWYyMmUyYzdkNmRkZmQ1NzIyNzE3NyIsInN1YiI6IjY1OWQ2YmRiYjZjZmYxMDFhNjc0OWQyOSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.XMVnYm5EpfHU2S-X3FojIPw0CyNkvu8fEppBrw0Bt5s',
                    'accept' => 'application/json',
                ],
            ]);

            $personMoviesData = json_decode($personMovies->getBody(), true);
            $data['known_for'] = $personMoviesData['person_results'][0]['known_for'];

            return $data;
        }

}


