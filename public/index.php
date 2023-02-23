<?php
require_once __DIR__.'/../vendor/autoload.php';

use Controllers\PonenteController;
use Controllers\UsuarioController;
use Lib\Router;
use Dotenv\Dotenv;

$dotenv= Dotenv::createImmutable(__DIR__); //para acceder al .env
$dotenv-> safeLoad();


session_start();

//header
require_once('views/layout/header.php');


//RUTAS

//ruta por defecto(listar ponentes)
Router::add('GET', '/', function(){
    (new PonenteController())->listar();
});


//si no hay un usuario logueado, se podrá hacer el registro y el login
if (!isset($_SESSION['usuario'])) {
    //registrar usuario
    Router::add('GET','usuario/register', function() {
        (new UsuarioController())->register();
    });
    Router::add('POST','usuario/register', function() {
        (new UsuarioController())->register();
    });


    //login usuario
    Router::add('GET','usuario/login', function() {
        (new UsuarioController())->login();
    });
    Router::add('POST', 'usuario/login', function() {
        (new UsuarioController())->login();
    });


    //confirmar cuenta usuario
    Router::add('GET', 'usuario/confirmarcuenta/:id', function($usuariotoken) {
        (new UsuarioController())->confirmar_cuenta($usuariotoken);
    });
}
//si se está logueado, se podrá ver los ponentes y cerrar sesión
else {
    //listar ponentes
    Router::add('GET','ponente/listar', function() {
        (new PonenteController())->listar();
    });


    //modificar datos usuario
    Router::add('POST', 'usuario/modificar/:id', function(int $usuarioid) {
        (new UsuarioController())->modificar($usuarioid);
    });
    Router::add('GET', 'usuario/modificar/:id', function(int $usuarioid) {
        (new UsuarioController())->modificar($usuarioid);
    });

    Router::add('GET','usuario/modificar', function() {
        (new UsuarioController())->modificar();
    });
    Router::add('POST','usuario/modificar', function() {
        (new UsuarioController())->modificar();
    });


    //cerrar sesión
    Router::add('GET','usuario/cerrar', function() {
        (new UsuarioController())->cerrar();
    });

    //además, si eres admin, podrás crear y modificar ponentes
    if (isset($_SESSION['admin'])) {
        //crear ponente
        Router::add('GET', 'ponente/crear', function() {
            (new PonenteController())->crear();
        });
        Router::add('POST', 'ponente/crear', function() {
            (new PonenteController())->crear();
        });
        
        
        //modificar ponente
        Router::add('POST', 'ponente/modificar/:id', function(int $ponenteid) {
            (new PonenteController())->modificar($ponenteid);
        });
        Router::add('GET', 'ponente/modificar/:id', function(int $ponenteid) {
            (new PonenteController())->modificar($ponenteid);
        });
        
        Router::add('POST', 'ponente/modificar', function() {
            (new PonenteController())->modificar();
        });
        Router::add('GET', 'ponente/modificar', function() {
            (new PonenteController())->modificar();
        });
        

        //borrar ponente
        Router::add('POST', 'ponente/delete/:id', function(int $ponenteid) {
            (new PonenteController())->delete($ponenteid);
        });
    }
    
}

Router::dispatch();


//footer
require_once('views/layout/footer.php');

?>
