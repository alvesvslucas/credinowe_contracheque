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
    id INT AUTO_INCREMENT PRIMARY KEY,        -- ID único para cada funcionário
    nome VARCHAR(255) NOT NULL,               -- Nome do funcionário
    email VARCHAR(255) NOT NULL UNIQUE,       -- E-mail do funcionário (deve ser único)
    link_contracheque VARCHAR(255) NOT NULL,  -- Link para o contracheque
    status TINYINT(1) DEFAULT 1,              -- Status: 1 (ativo) ou 0 (inativo)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Data de criação
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- Última atualização
);

-- Insere um funcionário para testes
INSERT INTO funcionarios (nome, email, link_contracheque, status, created_at)
VALUES (
    'Funcionario Teste',
    'funcionario@inforttech.com',
    'https://meu.contracheque.com/link',
    1,
    NOW()
);
