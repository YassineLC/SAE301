<?php

class Controller_home extends Controller {

    public function action_home() {
        $m = Model::getModel();
        $data = $m->recherche("jean");
        $this->render("home", $data) ;
    }

    public function action_default() {
        $this->action_home();
    }

    public function action_recherche() {
        if (isset($_GET['recherche'])) {
            $m = Model::getModel() ;
            $data = $m->recherche($_GET['recherche']);
            $this->render("resultat", $data);
        }
        else {
            echo "Erreur";
        }
    }

}