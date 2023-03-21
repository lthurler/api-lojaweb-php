<?php
include_once("./model/Endereco.php");

function enderecoController($method, $router)
{
    post($method, $router);
    get($method, $router);
}

function post($method, $router)
{
    if ($method == "POST") {
        if (!empty(strstr($router, "/endereco/add"))) {
            try {
                $dados = json_decode(file_get_contents('php://input'));

                $endereco = new Endereco();
                $endereco->cep = $dados->cep;
                $endereco->logradouro = $dados->logradouro;
                $endereco->bairro = $dados->bairro;
                $endereco->cidade = $dados->cidade;
                $endereco->uf = $dados->uf;
                $endereco->add();

                http_response_code(200);
                echo "Dados Salvos!";
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode("error:" . $e->getMessage());
            }
        }
    }
}

function get($method, $router)
{
    if ($method == "GET") { //Busca de dados
        if (!empty(strstr($router, "/endereco/list"))) {
            try {
                $endereco = new Endereco();
                $result = $endereco->getAll();

                http_response_code(200);
                echo json_encode($result);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode("error:" . $e->getMessage());
            }
        }

        if (!empty(strstr($router, "/endereco/get"))) {
            try {
                $dados = explode("/", $router);
                $cep = $dados[count($dados) - 1];
                $endereco = new Endereco();
                $result = $endereco->get($cep);

                http_response_code(200);
                echo json_encode($result);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode("error:" . $e->getMessage());
            }
        }
    }
}
