<?php
    namespace Models;

    use Exception;
    use PDO;
    use PDOException;
    use Lib\BaseDatos;


    class Usuario extends BaseDatos{
        private string $id;
        private string $nombre;
        private string $apellidos;
        private string $email;
        private string $password;
        private string $rol;
        private string $confirmado;
        private string $token;
        private string $token_exp;

        public function __construct($args)
        {
            parent::__construct();
            $this->id= $args['id'] ?? 'NULL';
            $this->nombre= $args['nombre'] ?? '';
            $this->apellidos= $args['apellidos'] ?? '';
            $this->email= $args['email'] ?? '';
            $this->password= $args['password'] ?? '';
            $this->rol= $args['rol'] ?? 'user';
            $this->confirmado= $args['confirmado'] ?? '';
            $this->token= $args['token'] ?? 'NULL';
            $this->token_exp= $args['token_exp'] ?? '0';
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

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    public function getRol() {
        return $this->rol;
    }

    public function setRol($rol) {
        $this->rol = $rol;
        return $this;
    }

    public function getConfirmado() {
        return $this->confirmado;
    }

    public function setConfirmado($confirmado) {
        $this->confirmado = $confirmado;
        return $this;
    }

    public function getToken() {
        return $this->token;
    }

    public function setToken($token) {
        $this->token = $token;
        return $this;
    }

    public function getToken_exp() {
        return $this->token_exp;
    }

    public function setToken_exp($token_exp) {
        $this->token_exp = $token_exp;
        return $this;
    }



    //guarda al usuario en la base de datos
    public function save() {
        $ins= $this->prepara("INSERT INTO usuarios (id, nombre, apellidos, email, password, rol, confirmado, token, token_exp) values (:id, :nombre, :apellidos, :email, :password, :rol, :confirmado, :token, :token_exp)");

        $ins->bindParam(':id', $id);
        $ins->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $ins->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
        $ins->bindParam(':email', $email, PDO::PARAM_STR);
        $ins->bindParam(':password', $password, PDO::PARAM_STR);
        $ins->bindParam(':rol', $rol, PDO::PARAM_STR);
        $ins->bindParam(':confirmado', $confirmado, PDO::PARAM_STR);
        $ins->bindParam(':token', $token, PDO::PARAM_STR);
        $ins->bindParam(':token_exp', $token_exp, PDO::PARAM_STR);

        $id= NULL;
        $nombre= $this->getNombre();
        $apellidos= $this->getApellidos();
        $email= $this->getEmail();
        $password= $this->getPassword();
        $rol= $this->getRol();
        $confirmado= 'no';
        $token= $this->getToken();
        $token_exp= $this->getToken_exp();

        try{
            $ins->execute();
            $result= true;
        }
        catch(PDOException $err){
            $result= false;
        }
        return $result;
    }

    //busca el correo del usuario para ver si ya está creado
    public function esta_registrado(): bool {
        $sql= $this->prepara("SELECT * FROM usuarios WHERE email= :email ");

        $email= strtolower($this->getemail());

        $sql->bindParam(':email', $email, PDO::PARAM_STR);

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


    //confirma la cuenta del usuario: vacía el token y cambia su confirmado a sí
    public function confirmar_cuenta() {
        $token= $this->getToken();
        $confirmado= $this->confirmar_usuario($token);
        $token_vaciado= $this->vaciar_token($token);
        if ($confirmado && $token_vaciado) {
            return true;
        }
        else {
            return false;
        }
    }
    
    //cambia el campo confirmado del usuario a só
    public function confirmar_usuario($token) {
        $sql= $this->prepara("UPDATE usuarios SET confirmado= 'si' WHERE token= :token");

        $sql->bindParam(':token', $token, PDO::PARAM_STR);
        
        try {
            $sql->execute();
            $result= true;
        }
        catch(PDOEXception $err) {
            $result= false;
        }
        return $result;
    }

    //vacía el token del usuario confirmado
    public function vaciar_token($token) {
        $sql= $this->prepara("UPDATE usuarios SET token= '' WHERE token= :token");
        
        $sql->bindParam(':token', $token, PDO::PARAM_STR);

        try {
            $sql->execute();
            $result= true;
        }
        catch(PDOEXception $err) {
            $result= false;
        }
        return $result;
    }

    
    //inicia sesión
    public function login($datos): bool|object {
        $result= false;
        $email= $datos['email'];
        $password= $datos['password'];

        $usuario= $this->buscaMail($email);

        if ($usuario !== false) {
            $verify= password_verify($password, $usuario->password);
            $result= $verify;
        }
        return $result;
    }

    //busca si el email ya existe en la base de datos
    public function buscaMail($email): bool|object{
        $result= false;
        $sql= $this->prepara("SELECT * FROM usuarios WHERE email= :email");
        $sql->bindParam(':email', $email, PDO::PARAM_STR);

        try {
            $sql->execute();
            if ($sql && $sql->rowCount() == 1) {
                $result= $sql->fetch(PDO::FETCH_OBJ);
            }
        }
        catch(PDOEXception $err) {
            $result= false;
        }
        return $result;
    }

    //le asigna un token al usuario creado
    public function asignar_token($token) {
        $sql= $this->prepara("UPDATE usuarios SET token= :token WHERE email= :email");
        $sql->bindParam(':token', $token, PDO::PARAM_STR);
        $sql->bindParam(':email', $email, PDO::PARAM_STR);

        $email= $this->getEmail();
        
        try {
            $sql->execute();
            $result= true;
        }
        catch(PDOEXception $err) {
            $result= false;
        }
        return $result;
    }


    //comprueba si el usuario está confirmado o no para poder iniciar sesión
    public function esta_confirmado(): bool {
        $sql= $this->prepara("SELECT confirmado FROM usuarios WHERE email= :email");
        $sql->bindParam(':email', $email, PDO::PARAM_STR);

        $email= $this->getEmail();

        try {
            $sql->execute();
            if ($sql->fetch()['confirmado'] == 'si') {
                return true;
            }
            else {
                return false;
            }
        }
        catch(PDOEXception $err) {
            $result= false;
        }
        return $result;
    }

    //devuelve si el usuario es administrador o no
    public function es_admin($email): bool{
        $sql= $this->prepara("SELECT * FROM usuarios WHERE email= :email and rol= 'admin'");

        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        
        try {
            $sql->execute();
            if ($sql && $sql->rowCount() == 1) {
                $result= true;
            }
            else {
                $result= false;
            }
        }
        catch(PDOEXception $err) {
            $result= false;
        }
        return $result;
    }
}

?>