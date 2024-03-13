<?php

class Controller_commun extends Controller {

    public function action_default() {
        $this->action_recherche_commun();
    }

    public function action_commun() {
        $m = Model::getModel() ;
        if (isset($_GET['param1']) && isset($_GET['param2'])) {
            $data = $m->getCommun($_GET['param1'], $_GET['param2']);
            $this->render("commun", ['data' => $data]);
        }
        else {
            $this->render("commun");
        }
    }
}
?>