<?php

class Controller_commun extends Controller {

    public function action_default() {
        $this->action_recherche_commun();
    }

    public function action_recherche_commun() {
        $m = Model::getModel() ;
        //$data = $m->recherche_commun('nm0000206', 'nm0000401') ;
        $this->render("commun");
    }

}

?>