<?php
class Controller_recherche_avancee extends Controller {
    
    public function action_default() {
        $this->action_recherche();
    }

    public function action_recherche(){
        $
        $this->render("recherche_avancee");
    }


    public function action_recherche_avancee() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['expression']) && isset($_POST['filters'])) {
            $expression = $_POST['expression'];
            $filters = $_POST['filters'];

            $resultats = $this->model->recherche_avancee($expression, $filters);

            header('Content-Type: application/json');
            echo json_encode($resultats);
            $this->render("recherche_avancee", $resultats);
            exit;
        }
    }
}


?>