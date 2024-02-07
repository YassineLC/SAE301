<?php

class Controller_home extends Controller {

    public function action_default() {
        $this->action_home();
    }

    public function action_home() {
        $m = Model::getModel();
        $data = $m->getURLPosters(5);
        $this->render("home", $data);
    }

    public function action_recherche() {
        if (isset($_GET['recherche'])) {
            $m = Model::getModel() ;
            $data = $m->recherche($_GET['recherche']);
            $this->render("resultat", ['data' => $data]);
        }
        else {
            echo "Erreur";
        }
    }

    public function action_recherche_avancee() 
    {
        if (isset($_GET['recherche']) && isset($_GET['type'])) {
            $m = Model::getModel() ;
            $data = $m->recherche_avancee($_GET['recherche'],$this->filtres());
            $this->render("resultat", $data);
        }
        else {
            echo "Erreur";
        }
    }

    public function filtres() 
    {
        if ($_GET['type'] == 'film') {
        $filtres = [
            'type' => isset($_GET['type']) ? $_GET['type'] : '',
            'genres' => isset ($_GET['genres']) ? $_GET['genres'] : ''
        ];
        }
        elseif ($_GET['type'] == 'personne') {
        $filtres = [
            'type' => isset($_GET['type']) ? $_GET['type'] : '',
            'birthyear' => isset ($_GET['birthyear']) ? $_GET['birthyear'] : '',
            'deathyear' => isset ($_GET['deathyear']) ? $_GET['deathyear'] : '',
            'primaryprofession' => isset ($_GET['primaryprofession']) ? $_GET['primaryprofession'] : '',
            'knownfortitles' => isset ($_GET['knownfortitles']) ? $_GET['knownfortitles'] : ''
        ];
        }

        return $filtres;
    }

}