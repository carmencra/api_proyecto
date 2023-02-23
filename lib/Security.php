<?php
    namespace Lib;

    use Dotenv\Dotenv;
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    use PDOException;

class Security {
    final public static function clavesecreta(){
        $dotenv = Dotenv::createImmutable(dirname(__DIR__.'/'));
        $dotenv -> load();
        return $_ENV['SECRET_KEY'];
    }

    //encriptar
    final public static function encriptaPassw(string $passw): string {
        $passw= password_hash($passw, PASSWORD_DEFAULT);
        return $passw;
    }

    //verificar
    final public static function validaPassw(string $passw, string $passwash): bool {
        if (password_verify($passw, $passwash)) {
            return true;
        }
        else {
            return false;
        }
    }

    final public static function crearToken(string $key, array $data) {
        $time= strtotime("now");
        $token= array(
            "iat"=>$time,
            "exp"=>$time + 3600,
            "data"=>$data
        );
        return JWT::encode($token, $key, 'HS256') ;
    }

    final public static function getToken() {
        $headers= apache_request_header();
        if (!isset($header['Authorization'])) {
            return $response['message']= json_decode(ResponseHttp::statusMessage403, 'Acceso denegado');
        }
        try {
            $authorizationArr= explode(' ', $headers['Authorization']);
            $token= $authorizationArr[1];
            $decodeToken= JWT::decode($token, new Key(Security::clavesecreta(), 'HS256'));
            return $decodeToken;
        }
        catch (PDOException $exception) {
            return $response['message']= json_encode(ResponseHttp::statusMessage(401, 'Token expirado o inválido'));
        }
    }

    final public static function validateToken(array $token, $key) {
        $info= self::getToken();
    }
}

?>
