/* SQL: Standard Query Language, literalmente a linguagem padrão para realizar queries.*/

/* DDL: linguagem de definição(criação da estrutura) de dados */ 
create database lojaweb;

use lojaweb;

show databases;

CREATE TABLE usuario(
    id_usuario int AUTO_INCREMENT PRIMARY KEY,
    --id_usuario varchar(50) PRIMARY KEY, -- ou # para uma linha e /* */ para multiplas linha
    nome varchar(100) not null,
    foto varchar(150),
    cpf varchar(14),
    email varchar(150) not null,
    senha varchar(100) not null,
    telefone varchar(40),
    ativo boolean DEFAULT true
);

show tables;

desc usuario;

alter TABLE usuario add data_nasc date null;

CREATE TABLE funcionario( 
    id_funcionario int AUTO_INCREMENT PRIMARY KEY,
    cargo varchar(50) NOT null,
    id_usuario int NOT Null,
    FOREIGN KEY(id_usuario) REFERENCES usuario(id_usuario)
);


/* DML: limguagem de manipulação de dados */
INSERT into usuario (nome, email, senha) 
VALUES (Ana Maria, ana@email.com, 12345);

INSERT into usuario (nome, email, senha) 
VALUES
(Carlos Cunha, carlos@email.com, 333333),
(Paulo Silva, paulo@email.com, 222222),
(Maria da Silva, maria@email.com, 44444);

INSERT INTO funcionario (id_usuario, cargo) 
VALUES (1,"Gerente");

select * from usuario;

select usuario.nome, funcionario.cargo 
from usuario, funcionario;

select usuario.*, funcionario.cargo 
from usuario, funcionario
WHERE funcionario.cargo = "Gerente";

SELECT * 
FROM usuario,funcionario 
where usuario.id_usuario = funcionario.id_usuario
and usuario.data_nasc =1980-12-01;

SELECT * 
FROM usuario,funcionario 
where usuario.id_usuario = funcionario.id_usuario 
and usuario.data_nasc BETWEEN 1980-12-01 and 1980-12-30;/* YYYY-MM-DD*/


-- ---------------------------

INSERT INTO usuario (data_nasc) VALUES (1980-12-20);

UPDATE usuario 
SET 
nome = Carlos Silva Jr,
email = carlosjr@email.com,
senha = 1234rj
where id_usuario = 5;

UPDATE usuario 
SET 
data_nasc = 1980-12-14
where id_usuario = 5;


SELECT * 
FROM usuario,funcionario
WHERE usuario.ativo = true
and usuario.id_usuario = funcionario.id_funcionario;

SELECT DISTINCT * 
FROM usuario
left join funcionario as f on usuario.id_usuario = f.id_usuario
WHERE usuario.ativo=true;

-----

CREATE table endereco( 
    cep varchar(10) PRIMARY KEY NOT null,
    logradouro varchar(150),
    bairro varchar(50),
    cidade varchar(50),
    uf varchar(2) 
)

SELECT * FROM usuario LIMIT 21,40;