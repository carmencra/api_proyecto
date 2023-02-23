<?php
namespace Controllers;
use Models\Ponente;
use Lib\ResponseHttp;
use Lib\Pages;

class ApiPonenteController {
    private Pages $pages;
    private Ponente $ponente;

    public function __construct() {
        // ResponseHttp::setHeaders();
        $this->ponente= new Ponente();
        $this->pages= new Pages();
    }

    //crea un ponente con los datos pasados
    public function crear($datos_ponente) {
        $datos= json_decode($datos_ponente);

        //si los campos no están vacíos, los asigna al ponente
        if ($this->validar_datos($datos->nombre, $datos->apellidos) === true) { 
            //validación imagen
            $foto= $_FILES['imagen'];

            $nom_foto= $foto['name'];            
            $temp_foto= $foto['tmp_name'];
            $ruta_foto= './images/'.$nom_foto;

            if (!is_dir('./images')){
                mkdir('./images', '0777');
            }

            //si hay un fichero seleccionado, lo sube
            if (is_uploaded_file($temp_foto)) {
                move_uploaded_file($temp_foto, $ruta_foto);

                //creamos un ponente decodificando el objeto de json
                $array_datos= json_decode(json_encode($datos), true);
                $array_datos['imagen']= $nom_foto;

                //si no hay tags ni redes, los borramos para que se introoduzcan como nulo en la bd;
                if (empty($datos->tags)) {
                    unset($array_datos['tags']);
                }
                if (empty($datos->redes)) {
                    unset($array_datos['redes']);
                }

                $ponente= Ponente::fromArray($array_datos);

                if (!$ponente->esta_registrado()) {
                    //guardamos el ponente en la BD
                    $guardar= $ponente->save();

                    if ($guardar) {
                        $result= json_decode(ResponseHttp::statusMessage(200, "Ponente creado"));
                    }
                    else {
                        $result= json_decode(ResponseHttp::statusMessage(400, "Ponente no creado"));
                    }
                }
                else {
                    $result= json_decode(ResponseHttp::statusMessage(400, "Ponente ya registrado"));
                }                
            }
            else {
                $result= json_decode(ResponseHttp::statusMessage(400, "*Imagen obligatoria"));
            }
        }
        else {
            //error por campos vacíos o formato incorrecto
            $result= $this->validar_datos($datos->nombre, $datos->apellidos);
        }
    return $result;
    }

    public function validar_datos($nombre, $apellidos) {
        //comprueba que los campos no estén vacíos
        if (empty($nombre) || empty($apellidos)) {
            $result= json_decode(ResponseHttp::statusMessage(400, "Nombre, apellidos e imagen son requeridos"));
        }
        //si está todo relleno, comprueba que sean válidos
        else {
            $pattern = "/^[a-zA-Z\sñáéíóúÁÉÍÓÚ ]+$/";
            if (preg_match($pattern, $nombre) && preg_match($pattern, $apellidos)) {
                $result= true;
            }
            else {
                $result= json_decode(ResponseHttp::statusMessage(400, "Solo letras y espacios"));
            }
        }
        return $result;

    }


    //lista todos los ponentes
    public function listar() {
        $ponente= new Ponente([]);
        $ponentes= $ponente->findAll();
        return $ponentes;
    }

    //busca el ponente que se corresponde con el id pasado
    public function busca_ponente($id) {
        $ponente= $this->ponente->findOne($id);
        return $ponente;
    }

    //modifica el ponente del id pasado con los nuevos datos pasados
    public function modificar($id, $datos_ponente) {
        $datos= json_decode($datos_ponente);

        //si los campos están correctos, valida también la foto
        if ($this->validar_datos($datos->nombre, $datos->apellidos) === true) { 
            //validación imagen
            $foto= $_FILES['imagen'];

            $nom_foto= $foto['name'];            
            $temp_foto= $foto['tmp_name'];
            $ruta_foto= './images/'.$nom_foto;

            if (!is_dir('./images')){
                mkdir('./images', '0777');
            }

            //si hay un fichero seleccionado, lo sube
            if (is_uploaded_file($temp_foto)) {
                move_uploaded_file($temp_foto, $ruta_foto);

                //creamos un ponente decodificando el objeto de json
                $array_datos= json_decode(json_encode($datos), true);
                $array_datos['imagen']= $nom_foto;

                //si no hay tags ni redes, los borramos para que se introoduzcan como nulo en la bd;
                if (empty($datos->tags)) {
                    unset($array_datos['tags']);
                }
                if (empty($datos->redes)) {
                    unset($array_datos['redes']);
                }

                $ponente= Ponente::fromArray($array_datos);

                //guardamos el ponente en la BD
                $actualizar= $ponente->actualizar($id);

                if ($actualizar) {
                    $result= json_decode(ResponseHttp::statusMessage(200, "Ponente actualizado"));

                    //llevamos al index de ponentes
                    header("Location: ". $_ENV['BASE_URL']);
                }
                else {
                    $result= json_decode(ResponseHttp::statusMessage(400, "Ponente no actualizado"));
                }              
            }
            else {
                $result= json_decode(ResponseHttp::statusMessage(400, "*Imagen obligatoria"));
            }
        }
        else {
            //error por campos vacíos o formato incorrecto
            $result= $this->validar_datos($datos->nombre, $datos->apellidos);
        }
    return $result;
    }

    //borra el ponente cuyo id se le indique    
    public function delete($id) {
        $encuentra_id= $this->ponente->findOne($id);

        if ($encuentra_id) {
            $borrar= $this->ponente->delete($id);

            if ($borrar) {
                $result= json_decode(ResponseHttp::statusMessage(200, "Ponente borrado"));
            }
            else {
                $result= json_decode(ResponseHttp::statusMessage(400, "Ponente no borrado"));
            }
        }
        else {
            $result= json_decode(ResponseHttp::statusMessage(400, "Ponente no existente"));
        }
        return $result;
    }
    
}

?>
