<?php
namespace Controllers;
use Lib\Pages;
use Controllers\ApiUsuarioController;

class UsuarioController {
    private Pages $pages;
    private ApiUsuarioController $apiUsuarioController;

    public function __construct() {
        // ResponseHttp::setHeaders();
        $this->pages= new Pages();
        $this->apiUsuarioController= new ApiUsuarioController();
    }

    //registra un nuevo usuario
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datos_usuario= json_encode($_POST['data']);
            $resultado_registro=$this->apiUsuarioController->register($datos_usuario);
            $_SESSION['registro']= $resultado_registro;
        }
        $this->pages->render('usuario/registro');
    }

    //confirma la cuenta del usuario
    public function confirmar_cuenta($token) {
        $resultado_confirmar= $this->apiUsuarioController->confirmar_cuenta($token);
        $_SESSION['confirmar_usuario']= $resultado_confirmar;

        header("Location: ". $_ENV['BASE_URL']);
    }

    //inicia sesión
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datos_usuario= json_encode($_POST['data']);
            $resultado_login= $this->apiUsuarioController->login_usuario($datos_usuario);
            $_SESSION['login']= $resultado_login;
        }
        $this->pages->render('usuario/login');
    }

    //cierra la sesión del usuario logueado
    public function cerrar() {
        header("Location: ". $_ENV['BASE_URL']);
        session_destroy();
    }

}

?>
