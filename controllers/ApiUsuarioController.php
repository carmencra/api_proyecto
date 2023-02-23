<?php
namespace Controllers;
use Models\Usuario;
use Lib\ResponseHttp;
use Lib\Pages;
use Lib\Security;
use Lib\Email;

class ApiUsuarioController {
    private Pages $pages;

    public function __construct() {
        // ResponseHttp::setHeaders();
        $this->pages= new Pages();
    }

    //registra un nuevo usuario
    public function register($datos_usuario) {
        $datos= json_decode($datos_usuario);

        //si los campos no están vacíos, los asigna al usuario
        if (!empty($datos->email) && !empty($datos->password)) {
            $datos->password= Security::encriptaPassw($datos->password);

            //creamos un usuario decodificando el objeto de json
            $array_datos= json_decode(json_encode($datos), true);
            $usuario= new Usuario($array_datos);

            //creamos el token y lo guardamos en la base de datos
            $token= Security::crearToken($usuario->getEmail(), [$usuario->getNombre()]);

            $usuario->setToken($token);             

            //guardamos el usuario en la BD
            $guardar= $usuario->save();

            if ($guardar) {
                //manda la confirmación del usuario por email
                $correo= new Email($usuario->getEmail(), $usuario->getToken());
                $correo->enviar_confirmacion();
                
                $result= json_decode(ResponseHttp::statusMessage(200, "Usuario creado y confirmación enviada"));
            }
            else {
                //si el usuario ya está registrado, saltará el error
                if ($usuario->esta_registrado()) {
                    $result= json_decode(ResponseHttp::statusMessage(400, "Usuario ya registrado"));
                }
                //si se da otro error, lo devuelve también
                else {
                    $result= json_decode(ResponseHttp::statusMessage(400, "Usuario no guardado"));
                }
            }
        }
        else {
            $result= json_decode(ResponseHttp::statusMessage(400, "No puede haber campos vacíos"));
        }
        return $result;
    }


    //confirma la cuenta del usuario
    public function confirmar_cuenta($token) {
        $usuario= new Usuario([]);
        $usuario->setToken($token);

        $confirmado= $usuario->confirmar_cuenta();
        if ($confirmado) {
            $result= json_decode(ResponseHttp::statusMessage(200, "Usuario confirmado"));
        }
        else {
            $result= json_decode(ResponseHttp::statusMessage(400, "Usuario no confirmado"));
        }
        return $result;
    }    


    //inicia sesión
    public function login_usuario($datos_usuario) {
        $datos= json_decode($datos_usuario);

        //si los campos no están vacíos, los asigna al usuario
        if (!empty($datos->email) && !empty($datos->password)) {
            $array_datos= json_decode(json_encode($datos), true);
            $usuario= new Usuario($array_datos);

            //sólo si el usuario está confirmado podrá iniciar sesión
            if ($usuario->esta_confirmado()) {
                $login= $usuario->login($array_datos);

                if ($login) {
                    $_SESSION['usuario']= $usuario->getEmail();
                    $result= json_decode(ResponseHttp::statusMessage(200, "Login completado"));

                    if ($usuario->es_admin($usuario->getEmail())) {
                        $_SESSION['admin']= true;
                    }
                    header("Location: ". $_ENV['BASE_URL']);
                }
                else {
                    $result= json_decode(ResponseHttp::statusMessage(400, "Login fallido"));
                }
            }
            else {
                $result= json_decode(ResponseHttp::statusMessage(400, "El usuario no está confirmado"));
            }
        } 
        else {
            $result= json_decode(ResponseHttp::statusMessage(400, "No puede haber campos vacíos"));
        }
        return $result;  
    }
    
}

?>
