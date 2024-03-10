<?php

class Controller_rapprochement extends Controller {

    public function action_default() {
        $this->action_rapprochement();
    }

    public function action_rapprochement()
    {
        if (isset($_GET['source']) && isset($_GET['target']) && isset($_GET['type'])) 
        {
            $m = Model::getModel() ;
            if ($_GET['type'] == 'films')
            {
                $data = $m->rapprochementFilm($_GET['source'], $_GET['target']);
            }
            elseif ($_GET['type'] == 'acteurs')
            {
                $data = $m->rapprochementNom($_GET['source'], $_GET['target']);
            }
            else
            {
                echo "Erreur: pas bon element dans type";
            }
            $this->render("test", ['data' => $data]);
        }
        else {
            echo "Erreur: Manque element";
        }
    }

}

?>