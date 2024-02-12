<?php

class Controller_details extends Controller {

    public function action_default() {
        $this->action_details();
    }

    public function action_details() {
        $m = Model::getModel() ;
        $data = $m->getMovieInfo($_GET['tconst']);
        $this->render("details_film", $data);
    }

}

?>