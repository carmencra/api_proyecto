<?php
require_once __DIR__.'/vendor/autoload.php';

use Dotenv\Dotenv;
use Lib\ResponseHttp;

$dotenv= Dotenv::createImmutable(__DIR__); //para acceder al .env
$dotenv-> safeLoad();


// http_response_code(202);
// $status= ['code' => 202, 'message' => 'estoy en el index'];
// echo json_encode($status);


echo ResponseHttp::getStatusMessage(404, 'no existe');


?>
