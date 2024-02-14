<?php

class Controller_details extends Controller {

    public function action_default() {
        $this->action_details();
    }

    public function action_details() {
        $m = Model::getModel() ;
        if (isset($_GET['tconst']) && !isset($_GET['nconst'])) {
            $data = $m->getMovieInfo($_GET['tconst']);
            $this->render("details_film", $data);
        } elseif (isset($_GET['nconst']) && !isset($_GET['tconst'])) {
            $data = $m->getPersonInfo($_GET['nconst']);
            $this->render("details_personne", $data);
        }
    }
}

?>