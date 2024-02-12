<?php

class Controller_test extends Controller {

public function action_home() {
        $m = Model::getModel();
        $this->render("home") ;
    }

    public function action_default() {
        $this->action_commun();
    }

    public function action_commun() {
        if (isset($_GET['commun'])) {
            $m = Model::getModel() ;
            $data = $m->graphe('Will Smith');
            $this->render("test", ['data' => $data]);
        }
        else {
            echo "Erreur";
        }
    }
}

?>