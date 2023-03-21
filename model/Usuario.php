<?php

include_once("./service/DAO.php");

class Usuario
{
    public $id_usuario; //PK - primary key (int)
    public $nome;
    public $foto;
    public $cpf;
    public $email;
    public $senha;
    public $telefone;
    public $data_nasc;
    public $ative = true;

    //CRUD: create(add), read(getAll, get), update, delete
    function add()
    {
        try {
            $dao = new DAO;
            $conn = $dao->conecta(); //conectar ao banco de dados;
            $sql = "INSERT into usuario (nome, foto, cpf, email, senha, telefone, data_nasc) 
                VALUES (:nome, :foto, :cpf, :email, md5(:senha), :telefone, :data_nasc)"; //Criar o comando SQL com os paramentos

            //Define a nova senha criptografada (sha256).
            $newSenha = crypt($this->senha, '$5$rounds=5000$' . $this->email . '$');

            $stman = $conn->prepare($sql); //Prepara o comando SQL para executar;
            $stman->bindParam(":nome", $this->nome);
            $stman->bindParam(":email", $this->email);
            $stman->bindParam(":cpf", $this->cpf);
            $stman->bindParam(":foto", $this->foto);
            $stman->bindParam(":data_nasc", $this->data_nasc);
            $stman->bindParam(":senha", $newSenha);
            $stman->bindParam(":telefone", $this->telefone);
            $stman->execute(); //grava dos dados no banco de dados;
        } catch (Exception $e) {
            throw new Exception("Erro ao cadastra o usuário! " . $e->getMessage());
        }
    }

    function getAll()
    {
        try {
            $dao = new DAO;
            $conn = $dao->conecta();
            $sql = "SELECT id_usuario, nome, foto, cpf, email, telefone, data_nasc, ativo from usuario where usuario.ativo = true";
            $stman = $conn->prepare($sql);
            $stman->execute();
            $result = $stman->fetchAll();
            return $result;
            //return $stman->fetchAll();
        } catch (PDOException $pdoe) {
            throw new Exception("Erro ao executar comando na base de dados! " . $pdoe->getMessage());
        } catch (JsonException $jsone) {
            throw new Exception("Erro ao montar o json! " . $jsone->getMessage());
        } catch (Exception $e) {
            throw new Exception("Erro ao listar todos os usuario! " . $e->getMessage());
        }
    }

    function get($id)
    {
        try {
            $dao = new DAO;
            $conn = $dao->conecta();
            $sql = "SELECT id_usuario,nome, foto, cpf, email, telefone, data_nasc, ativo 
                from usuario 
                where usuario.id_usuario=:id 
                and usuario.ativo = true";
            $stman = $conn->prepare($sql);
            $stman->bindParam(":id", $id);
            $stman->execute();
            $result = $stman->fetchAll();
            return $result;
            //return $stman->fetchAll();
        } catch (PDOException $pdoe) {
            throw new Exception("Erro ao executar comando na base de dados! " . $pdoe->getMessage());
        } catch (JsonException $jsone) {
            throw new Exception("Erro ao montar o json! " . $jsone->getMessage());
        } catch (Exception $e) {
            throw new Exception("Erro ao listar todos os usuario! " . $e->getMessage());
        }
    }

    function update()
    {
        try {
            $dao = new DAO;
            $conn = $dao->conecta(); //conectar ao banco de dados;
            $sql = "UPDATE usuario set
                nome = :nome,
                foto = :foto,
                cpf = :cpf,
                email = :email,
                telefone = :telefone,
                data_nasc = :data_nasc 
                where id_usuario = :id";

            $stman = $conn->prepare($sql); //Prepara o comando SQL para executar;
            $stman->bindParam(":nome", $this->nome);
            $stman->bindParam(":foto", $this->foto);
            $stman->bindParam(":cpf", $this->cpf);
            $stman->bindParam(":email", $this->email);
            $stman->bindParam(":telefone", $this->telefone);
            $stman->bindParam(":data_nasc", $this->data_nasc); //YYYY-MM-DD -> BR: DD-MM-YYYY
            $stman->bindParam(":id", $this->id_usuario);
            $stman->execute(); //grava dos dados no banco de dados;
        } catch (Exception $e) {
            throw new Exception("Erro ao cadastra o usuário! " . $e->getMessage());
        }
    }

    function delete($id) //remoção fisica do banco de dados
    {
        try {
            $dao = new DAO;
            $conn = $dao->conecta(); //conectar ao banco de dados;
            $sql = "DELETE usuario where id_usuario = :id";
            $stman = $conn->prepare($sql); //Prepara o comando SQL para executar;
            $stman->bindParam(":id", $id);
            $stman->execute(); //grava dos dados no banco de dados;
        } catch (Exception $e) {
            throw new Exception("Erro ao cadastra o usuário! " . $e->getMessage());
        }
    }

    function deleteLogico($id) //remoção logico do banco de dados
    {
        try {
            $dao = new DAO;
            $conn = $dao->conecta(); //conectar ao banco de dados;
            $sql = "UPDATE usuario set usuario.ativo = false where id_usuario = :id";
            $stman = $conn->prepare($sql); //Prepara o comando SQL para executar;
            $stman->bindParam(":id", $id);
            $stman->execute(); //grava dos dados no banco de dados;
        } catch (Exception $e) {
            throw new Exception("Erro ao cadastra o usuário! " . $e->getMessage());
        }
    }


    function logon($email, $pass)
    {
        try {
            $dao = new DAO;
            $conn = $dao->conecta();

            $newSenha = crypt($pass, '$5$rounds=5000$' . $email . '$');
            $sql = "SELECT id_usuario, nome, foto, cpf, email, telefone, data_nasc 
                from usuario 
                where usuario.email = :email 
                and usuario.senha = md5(:pass)
                and usuario.ativo = true";
            $stman = $conn->prepare($sql);
            $stman->bindParam(":email", $email);
            $stman->bindParam(":pass", $newSenha);
            $stman->execute();
            $result = $stman->fetchAll();
            return $result ? $result : null;
        } catch (Exception $e) {
            throw new Exception("Erro ao entrar com o usuario! " . $e->getMessage());
        }
    }
}
