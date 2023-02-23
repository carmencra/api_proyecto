<?php
    namespace Models;

    use Exception;
    use PDO;
    use PDOException;
    use Lib\BaseDatos;


    class Ponente extends BaseDatos{
        private string $id;
        private string $nombre;
        private string $apellidos;
        private string $imagen;
        private string $tags;
        private string $redes;

        public function __construct()
        {
            parent::__construct();
        }


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
        return $this;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
        return $this;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
        return $this;
    }

    public function getTags() {
        return $this->tags;
    }

    public function setTags($tags) {
        $this->tags = $tags;
        return $this;
    }

    public function getRedes() {
        return $this->redes;
    }

    public function setRedes($redes) {
        $this->redes = $redes;
        return $this;
    }

    public static function fromArray(array $data): Ponente {
        $ponente= new Ponente();
        $ponente->setId($data['id'] ?? 'NULL');
        $ponente->setNombre($data['nombre'] ?? '');
        $ponente->setApellidos($data['apellidos'] ?? '');
        $ponente->setImagen($data['imagen'] ?? '');
        $ponente->setTags($data['tags'] ?? 'NULL');
        $ponente->setRedes($data['redes'] ?? 'NULL');
        
        return $ponente;
    }

    //saca todos los ponentes de la base de datos
    public function findAll() {
        $this->consulta("SELECT * FROM ponentes ORDER BY id");
        return $this->extraer_todos();
    }

    //saca el ponente que se corresponde con el id pasado
    public function findOne($id){
        $this->consulta("SELECT * FROM ponentes WHERE id= $id");
        return $this->extraer_registro();
    }

    //borra el ponente que se corresponde con el id pasado
    public function delete($id) {
        $borr= $this->prepara("DELETE FROM ponentes WHERE id= $id");
        try{
            $borr->execute();
            $result= true;
        }
        catch(PDOException $err){
            $result= false;
        }
        return $result;
    }

    //guarda al ponente en la base de datos
    public function save() {
        $ins= $this->prepara("INSERT INTO ponentes (id, nombre, apellidos, imagen, tags, redes) values (:id, :nombre, :apellidos, :imagen, :tags, :redes)");

        $ins->bindParam(':id', $id);
        $ins->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $ins->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
        $ins->bindParam(':imagen', $imagen, PDO::PARAM_STR);
        $ins->bindParam(':tags', $tags, PDO::PARAM_STR);
        $ins->bindParam(':redes', $redes, PDO::PARAM_STR);

        $id= NULL;
        $nombre= $this->nombre;
        $apellidos= $this->apellidos;
        $imagen= $this->imagen;
        $tags= $this->tags;
        $redes= $this->redes;

        try{
            $ins->execute();
            $result= true;
        }
        catch(PDOException $err){
            $result= false;
        }
        return $result;
    }


    //busca el nombre del ponente para ver si ya está creado
    public function esta_registrado(): bool {
        $sql= $this->prepara("SELECT * FROM ponentes WHERE nombre= :nombre and apellidos= :apellidos");

        $nombre= strtolower($this->getNombre());
        $apellidos= strtolower($this->getApellidos());

        $sql->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $sql->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);

        try {
            $sql->execute();
            if ($sql && $sql->rowCount() == 1) {
                $result= true;
            }
            else{
                $result= false;
            }
        }
        catch(PDOEXception $err) {
            $result= false;
        }
        return $result;
    }

    //modifica al ponente con los datos creados en el mismo objeto ponente
    public function actualizar($id) {
        $sql= $this->prepara("UPDATE ponentes SET nombre=:nombre, apellidos=:apellidos, imagen=:imagen, tags=:tags, redes=:redes WHERE id=:id");

        $nombre= $this->getNombre();
        $apellidos= $this->getApellidos();
        $imagen= $this->getImagen();
        $tags= $this->getTags();
        $redes= $this->getRedes();

        //asigna los parámetros de la consulta
        $sql->bindParam(':id', $id);
        $sql->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $sql->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
        $sql->bindParam(':imagen', $imagen, PDO::PARAM_STR);
        $sql->bindParam(':tags', $tags, PDO::PARAM_STR);
        $sql->bindParam(':redes', $redes, PDO::PARAM_STR);
        
        try{
            $sql->execute();
            $result= true;
        }
        catch(PDOException $err){
            $result= false;
        }
        return $result;
    }

}

?>