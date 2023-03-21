<?php
include_once("./model/Usuario.php");



function usuarioController($method, $router, $auth)
{
    if ($method == "POST") { //Envio dados e cadastros
        if (!empty(strstr($router, "/usuario/add"))) {
            //         try {
            //             $dados = json_decode(file_get_contents(php://input));
            //             //var_dump($dados);
            //             $user = new Usuario();
            //             $user->nome = $dados->nome;
            //             $user->email = $dados->email;
            //             $user->senha = $dados->senha;
            //             $user->cpf = $dados->cpf;
            //             $user->foto = $dados->foto;
            //             $user->telefone = $dados->telefone;
            //             $user->data_nasc = $dados->data_nasc;
            //             $user->ativo = $dados->ativo;
            //             $user->add();
            //             echo "Usuario Cadastrado!";
            //         } catch (Exception $e) {
            //             echo json_encode("error:" . $e->getMessage());
            //         }
            //     }
            // }
            // if ($method == "PUT") { //Alterações de dados
            //if (!empty(strstr($router, "/usuario/update"))) {
            try {
                $dados = json_decode(file_get_contents('php://input'));
                //var_dump($dados);
                $user = new Usuario();
                $user->nome = $dados->nome;
                $user->email = $dados->email;
                $user->cpf = $dados->cpf;
                $user->foto = $dados->foto;
                $user->telefone = $dados->telefone;
                $user->data_nasc = $dados->data_nasc;
                $user->ativo = $dados->ativo;
                $user->id_usuario = $dados->id_usuario;
                if ($user->id_usuario == null) {
                    $user->senha = $dados->senha;
                    http_response_code(200);
                    $user->add();
                } else {
                    http_response_code(201);
                    $user->update();
                }

                echo  json_encode('"result":"Dados Salvos!"');
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode("error:" . $e->getMessage());
            }
        }
        if (!empty(strstr($router, "/usuario/logon"))) {
            try {
                $dados = json_decode(file_get_contents('php://input'));
                $user = new Usuario();
                $result = $user->logon($dados->email, $dados->pass);
                if ($result != null) {
                    http_response_code(200);
                    $user = $result[0];
                    echo json_encode(array("id" => $user->id_usuario, "nome" => $user->nome, "token" => generateJWT($user)));
                } else {
                    http_response_code(401);
                    echo  json_encode("Usuario não encontrado!");
                }
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode("error:" . $e->getMessage());
            }
        }
    }

    if ($method == "GET") { //Busca de dados
        if (!empty(strstr($router, "/usuario/list")) && $auth) {
            try {
                $user = new Usuario();
                $result = $user->getAll();
                http_response_code(200);
                echo json_encode($result);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode("error:" . $e->getMessage());
            }
        }
        if (!empty(strstr($router, "/usuario/get"))) {
            try {
                //$id = $_GET["id"];
                //var_dump($_GET);
                //var_dump(explode("/", $router)); //explode: separa uma string em vetor com base em um caracter. No exemplo o "/"

                $dados = explode("/", $router);
                $id = $dados[count($dados) - 1];
                $user = new Usuario();
                $result = $user->get($id);
                http_response_code(200);
                echo json_encode($result);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode("error:" . $e->getMessage());
            }
        }
    }

    if ($method == "DELETE") { //Busca de dados
        if (!empty(strstr($router, "/usuario")) && $auth) {
            try {
                $dados = json_decode(file_get_contents('php://input'));
                $user = new Usuario();
                $user->deleteLogico($dados->id_usuario);
                http_response_code(200);
                echo "Dados Removidos!";
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode("error:" . $e->getMessage());
            }
        }
    }
}
