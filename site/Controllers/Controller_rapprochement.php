<?php

class Controller_rapprochement extends Controller {

    public function action_default() {
        $this->action_rapprochement();
    }

    public function action_rapprochement()
    {
        if (isset($_GET['source']) && isset($_GET['target'])) 
        {
            $m = Model::getModel() ;
            $data = $m->rapprochementNom($_GET['source'], $_GET['target']);
            $this->render("rapprochement_resultat", ['data' => $data]);
        }
        else {
            $this->render("rapprochement_resultat");
        }
    }

}

?>