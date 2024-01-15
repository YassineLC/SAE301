<?php

class Controller_home extends Controller {

    public function action_home() {
        $m = Model::getModel();
        $this->render("home") ;
    }

    public function action_default() {
        $this->action_home();
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
}