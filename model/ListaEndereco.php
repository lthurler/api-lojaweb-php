<?php
include "Usuario.php";
include "Endereco.php";

class ListaEndereco{
    public $usuario = new Usuario(); //FK - Foreign Key
    public $endereco = new Endereco(); //FK - Foreign Key
    public $numero;
    public $complemento;
    public $default = false;
    public $ative = true;
}