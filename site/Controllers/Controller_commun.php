<?php

class Controller_commun extends Controller {

    public function action_default() {
        $this->action_recherche_commun();
    }

    public function action_recherche_commun() {
        $m = Model::getModel() ;
        //$data = $m->recherche_commun('Keanu Reeves', 'Laurence Fishburne') ;
        $this->render("commun");
    }

}

?>