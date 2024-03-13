<?php
class Controller_recherche_avancee extends Controller {
    
    public function action_default() {
        $this->action_recherche();
    }

    public function action_recherche(){
        $this->render("recherche_avancee");
    }

    public function action_recherche_avancee() {
        if (isset($_POST['expression']) && isset($_POST['filters'])) {
            $m = Model::getModel() ;
            $resultats = $m->recherche_avancee($_POST['expression'], $_POST['filters']);
            $this->render("recherche_avancee", ['resultats' => $resultats]);
        } else {
            $this->action_recherche();
        }
    }
}
?>
