<?php
namespace Controllers;
use Lib\Pages;
use Controllers\ApiPonenteController;

class PonenteController {
    private Pages $pages;
    private ApiPonenteController $apiPonenteController;

    public function __construct() {
        // ResponseHttp::setHeaders();¡
        $this->pages= new Pages();
        $this->apiPonenteController= new ApiPonenteController();
    }   
    
    //crea un nuevo ponente
    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datos_ponente= json_encode($_POST['data']);
            $resultado_crear= $this->apiPonenteController->crear($datos_ponente);
            $_SESSION['crea_ponente']= $resultado_crear;
        }
        $this->pages->render('ponente/crear');
    }
    
    //lista todos los ponentes
    public function listar() {
        $ponentes= $this->apiPonenteController->listar();
        
        $this->pages->render('ponente/listar', ['ponentes' => $ponentes]);
    }

    //modifica el ponente
    public function modificar($id="") {
        if (!isset($_POST['data'])) {
            $ponente= $this->apiPonenteController->busca_ponente($id);
            $_SESSION['ponente']= $ponente;

            $this->pages->render('ponente/modificar',['ponente' => $ponente]);
        }
        else {
            $datos_ponente= json_encode($_POST['data']);
            $resultado_modificar=$this->apiPonenteController->modificar($_SESSION['ponente']['id'], $datos_ponente);
            $_SESSION['modifica_ponente']= $resultado_modificar;
        }
        if (isset($_SESSION['ponente'])) {
            $this->pages->render('ponente/modificar',['ponente' => $_SESSION['ponente']]);
        }
    }

    //borra el ponente que se corresponde con el id pasado
    public function delete($id) {
        $resultado_borrar= $this->apiPonenteController->delete($id);
        $_SESSION['borrar_ponente']= $resultado_borrar;
        
        header("Location: ". $_ENV['BASE_URL']);
    }
    
}

?>
