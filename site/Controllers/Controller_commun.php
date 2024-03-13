<?php


class Controller_commun extends Controller {

    public function action_default() {
        $this->action_commun();
    }

 
    public function action_commun() {
        $m = Model::getModel();
        $this->render("commun");
    
    }

    public function action_recherche_commun() {
        if (isset($_GET['recherche1']) && isset($_GET['recherche2'])) {
            $m = Model::getModel();
            $data = $m->recherche_commun($_GET['recherche1'], $_GET['recherche2'], $db);
            $this->render("view_commun", ['data' => $data]);
        } else {
            $this->render("view_commun");
        }
    }
    //Controller_commun
    //public function action_commun() {
    //    if (isset($_GET['recherche1']) && isset($_GET['recherche2'])) {
    //        $m = Model::getModel();
    //       $data = $m->recherche_commun($_GET['recherche1'], $_GET['recherche2']);
    //        $this->render("view_commun", ['data' => $data]);
    //    } else {
    //        $this->render("view_commun");
    //    }
    //}
    
}

?>