-- Cria o banco de dados, se não existir
CREATE DATABASE IF NOT EXISTS credinowe;
USE credinowe;

-- Recria a tabela usuarios_admin
DROP TABLE IF EXISTS usuarios_admin;
CREATE TABLE usuarios_admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insere um administrador para testes
INSERT INTO usuarios_admin (nome, email, senha, criado_em)
VALUES (
    'Admin Teste', 
    'admin@inforttech.com', 
    '$2y$10$9P2rbdT6C1oT04LCyMdYwex9M1O.nkC8zD3UfrbQvgnwC8GQ.Wm2C', -- Hash da senha '123456'
    NOW()
);

-- Recria a tabela funcionarios
DROP TABLE IF EXISTS funcionarios;
CREATE TABLE funcionarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    link_contracheque TEXT NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insere um funcionário para testes
INSERT INTO funcionarios (nome, email, senha, link_contracheque, criado_em)
VALUES (
    'Funcionario Teste',
    'funcionario@inforttech.com',
    '$2y$10$9P2rbdT6C1oT04LCyMdYwex9M1O.nkC8zD3UfrbQvgnwC8GQ.Wm2C', -- Hash da senha '123456'
    'https://meu.contracheque.com/link',
    NOW()
);
