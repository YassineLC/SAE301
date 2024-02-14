<?php

class Controller_recherche_avancee extends Controller {

    public function action_default() {
        $this->action_recherche_avancee();
    }

    public function action_recherche_avancee() {
        $this->render("recherche_avancee");
    }

}

?>