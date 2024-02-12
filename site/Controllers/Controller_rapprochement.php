<?php

class Controller_rapprochement extends Controller {

    public function action_default() {
        $this->action_rapprochement();
    }

    public function action_rapprochement() {
        $this->render("rapprochement");
    }

}

?>