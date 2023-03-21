
CREATE TABLE usuario (
  id_usuario int(11) NOT NULL AUTO_INCREMENT,
  nome varchar(100) NOT NULL,
  foto varchar(150) DEFAULT NULL,
  cpf varchar(14) DEFAULT NULL,
  email varchar(150) NOT NULL,
  senha varchar(100) NOT NULL,
  telefone varchar(40) DEFAULT NULL,
  data_nasc date DEFAULT NULL,
  ativo tinyint(1) DEFAULT 1
);

CREATE TABLE funcionario (
  id_funcionario int(11) PRIMARY NOT NULL,
  cargo varchar(50) NOT NULL,
  id_usuario int(11) NOT NULL,
  FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);

CREATE TABLE endereco (
  cep varchar(10) PRIMARY KEY NOT NULL,
  logradouro varchar(150) DEFAULT NULL,
  bairro varchar(50) DEFAULT NULL,
  cidade varchar(50) DEFAULT NULL,
  uf varchar(2) DEFAULT NULL
);

