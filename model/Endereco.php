<?php

include_once("./service/DAO.php");
class Endereco
{
    public $cep; //PK - primary key (string)
    public $logradouro;
    public $bairro;
    public $cidade;
    public $uf;


    function add()
    {
        try {
            $dao = new DAO();
            $conn = $dao->conecta();
            $sql = "INSERT into endereco (cep, logradouro, bairro, cidade, uf) 
                VALUES (:cep, :logradouro, :ze, :cidade, :uf)";
            $stman = $conn->prepare($sql);
            $stman->bindParam(":cep", $this->cep);
            $stman->bindParam(":logradouro", $this->logradouro);
            $stman->bindParam(":ze", $this->bairro);
            $stman->bindParam(":cidade", $this->cidade);
            $stman->bindParam(":uf", $this->uf);
            $stman->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao cadastra o endereço!" . $e->getMessage());
        }
    }

    function get($cep)
    {
        try {
            $dao = new DAO();
            $conn = $dao->conecta();
            $sql = "Select * from endereco where endereco.cep = :cep";
            $stman = $conn->prepare($sql);
            $stman->bindParam(":cep", $cep);
            $stman->execute();
            $result = $stman->fetchAll();
            return $result;
        } catch (Exception $e) {
            throw new Exception("Erro ao cadastra o endereço!" . $e->getMessage());
        }
    }

    function getAll()
    {
        try {
            $dao = new DAO();
            $conn = $dao->conecta();
            //$sql = "Select * from endereco limit :inicio, :final";
            $sql = "Select * from endereco";
            $stman = $conn->prepare($sql);
            // $stman->bindParam(":inicio", $inicio);
            // $stman->bindParam(":final", $final);
            $stman->execute();
            $result = $stman->fetchAll();
            return $result;
        } catch (Exception $e) {
            throw new Exception("Erro ao cadastra o endereço!" . $e->getMessage());
        }
    }

    function up($idCep)
    {
        try {
            $dao = new DAO();
            $conn = $dao->conecta();
            $sql = "UPDATE endereco SET 
            cep = :cep,
            logradouro = :logradouro,
            bairro = :bairro,
            cidade = :cidade,
            uf = :uf 
            WHERE endereco.cep = :idCep";
            $stman = $conn->prepare($sql);
            $stman->bindParam(":cepNew", $this->cep);
            $stman->bindParam(":logradouro", $this->logradouro);
            $stman->bindParam(":ze", $this->bairro);
            $stman->bindParam(":cidade", $this->cidade);
            $stman->bindParam(":uf", $this->uf);
            $stman->bindParam(":idCep", $idCep);
            $stman->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao cadastra o endereço!" . $e->getMessage());
        }
    }

    function delete()
    {
        try {
            $dao = new DAO;
            $conn = $dao->conecta();
            $sql = "DELETE endereco where endereco.cep = :cep";
            $stman = $conn->prepare($sql);;
            $stman->bindParam(":cep", $this->cep);
            $stman->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao cadastra o usuário! " . $e->getMessage());
        }
    }
}
