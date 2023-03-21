<?php
include_once("./config/config_dev.php");
//include_once("./config/config_prod.php");
include_once("./service/jwt.php");
include_once("./controller/usuario.php");
include_once("./controller/endereco.php");


//var_dump($_SERVER);

if (isset($_SERVER["REQUEST_METHOD"]) || isset($_SERVER["REQUEST_URI"])) {

    $method = $_SERVER["REQUEST_METHOD"];
    $router = $_SERVER["REQUEST_URI"];

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    if ($method == "OPTIONS") {
        header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Max-Age: 3600"); //1hora == 3600 seg;
        header("Access-Control-Allow-Credentials: true");
    }

    // Validação
    $receiveToken = isset($_SERVER["HTTP_AUTHORIZATION"]) ? $_SERVER["HTTP_AUTHORIZATION"] : null;
    $auth = validJWT($receiveToken);
    // if (!$auth) {
    //     http_response_code(401);
    //     echo json_encode(array("message" => "Acesso negado!"));
    // }

    usuarioController($method, $router, $auth);
    enderecoController($method, $router);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Item does not exist."));
}
