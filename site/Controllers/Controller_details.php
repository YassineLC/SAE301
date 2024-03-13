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

    public function action_details_v2() {
        $m = Model::getModel() ;
        if (isset($_GET['info']) && strpos($_GET['info'], 'nm') === 0) {
            $data = $m->getMovieInfo($_GET['info']);
            $this->render("details_film", $data);
        } elseif (isset($_GET['info']) && strpos($_GET['info'], 'tt') === 0) {
            $data = $m->getPersonInfo($_GET['info']);
            $this->render("details_personne", $data);
        }
    }
}

?>