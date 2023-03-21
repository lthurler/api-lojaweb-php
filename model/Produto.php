<!-- "produto": {
        "nome": "Iphone",
        "descricao": "Celular 5G com 8GB RAM e câmera de 64Mp",
        "quant": 100,
        "data_alteracao": "2022-12-20",
        "valor": 2345.67,
        "largura": 250,
        "altura": 450,
        "comprimento": 2350,
        "peso": 2000,
        "fotos": [],
        "ativo": true
    } -->

<?php

include_once("./service/DAO.php");

class Produto
{
    public $id_Produto; //PK - primary key (int)
    public $nome;
    public $descricao;
    public $quant;
    public $data_alteracao;
    public $valor;
    public $largura;
    public $altura;
    public $comprimento;
    public $peso;
    public $fotos;
    public $ativo = true;


    //CRUD: create(add), read(getAll, get), update, delete
    function add()
    {
        try {
            $dao = new DAO;
            $conn = $dao->conecta(); //conectar ao banco de dados;
            $sql = "INSERT into produto (nome, descricao, quant, data_alteracao, valor, largura, altura,comprimento ,peso ,fotos) 
                VALUES (:nome, :descricao, :quant, :data_alteracao, :valor, :largura, :altura, :comprimento, :peso, :fotos)"; //Criar o comando SQL com os paramentos

            $stman = $conn->prepare($sql); //Prepara o comando SQL para executar;
            $stman->bindParam(":nome", $this->nome);
            $stman->bindParam(":descricao", $this->descricao);
            $stman->bindParam(":quant", $this->quant);
            $stman->bindParam(":data_alteracao", $this->data_alteracao);
            $stman->bindParam(":valor", $this->valor);
            $stman->bindParam(":largura", $this->largura);
            $stman->bindParam(":altura", $this->altura);
            $stman->bindParam(":comprimento", $this->comprimento);
            $stman->bindParam(":peso", $this->peso);
            $stman->bindParam(":fotos", $this->fotos);
            $stman->execute(); //grava dos dados no banco de dados;
        } catch (Exception $e) {
            throw new Exception("Erro ao cadastra o produto! " . $e->getMessage());
        }
    }

    function getAll()
    {
        try {
            $dao = new DAO;
            $conn = $dao->conecta();
            $sql = "SELECT id_produto, nome, descricao, quant, data_alteracao, valor, largura, altura,comprimento ,peso ,fotos, ativo from produto where produto.ativo = true";
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
            throw new Exception("Erro ao listar todos os produtos! " . $e->getMessage());
        }
    }

    function get($id)
    {
        try {
            $dao = new DAO;
            $conn = $dao->conecta();
            $sql = "SELECT id_produto, nome, descricao, quant, data_alteracao, valor, largura, altura,comprimento ,peso ,fotos, ativo 
                from produto 
                where produto.id_produto=:id 
                and produto.ativo = true";
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
            throw new Exception("Erro ao listar todos os produtos! " . $e->getMessage());
        }
    }

    function update()
    {
        try {
            $dao = new DAO;
            $conn = $dao->conecta(); //conectar ao banco de dados;
            $sql = "UPDATE produto set
                nome = :nome,
                descricao = :descricao,
                quant = :quant,
                data_alteracao = :data_alteracao,
                valor = :valor,
                largura = :largura,
                altura = :altura,
                comprimento = :comprimento,
                peso = :peso,
                fotos = :fotos 
                where id_produto = :id";

            $stman = $conn->prepare($sql); //Prepara o comando SQL para executar;
            $stman->bindParam(":nome", $this->nome);
            $stman->bindParam(":descricao", $this->descricao);
            $stman->bindParam(":quant", $this->quant);
            $stman->bindParam(":data_alteracao", $this->data_alteracao);
            $stman->bindParam(":valor", $this->valor);
            $stman->bindParam(":largura", $this->largura);
            $stman->bindParam(":altura", $this->altura);
            $stman->bindParam(":comprimento", $this->comprimento);
            $stman->bindParam(":peso", $this->peso);
            $stman->bindParam(":fotos", $this->fotos);
            $stman->execute(); //grava dos dados no banco de dados;
        } catch (Exception $e) {
            throw new Exception("Erro ao cadastrar o produto! " . $e->getMessage());
        }
    }

    function delete($id) //remoção fisica do banco de dados
    {
        try {
            $dao = new DAO;
            $conn = $dao->conecta(); //conectar ao banco de dados;
            $sql = "DELETE produto where id_produto = :id";
            $stman = $conn->prepare($sql); //Prepara o comando SQL para executar;
            $stman->bindParam(":id", $id);
            $stman->execute(); //grava dos dados no banco de dados;
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir o produto! " . $e->getMessage());
        }
    }

    function deleteLogico($id) //remoção logico do banco de dados
    {
        try {
            $dao = new DAO;
            $conn = $dao->conecta(); //conectar ao banco de dados;
            $sql = "UPDATE produto set produto.ativo = false where id_produto = :id";
            $stman = $conn->prepare($sql); //Prepara o comando SQL para executar;
            $stman->bindParam(":id", $id);
            $stman->execute(); //grava dos dados no banco de dados;
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir o produto! " . $e->getMessage());
        }
    }
}
