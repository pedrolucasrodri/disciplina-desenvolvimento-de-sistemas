CREATE DATABASE IF NOT EXISTS lojaVille
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE lojaVille;

CREATE TABLE IF NOT EXISTS cadastro_produto (
    cod_produto VARCHAR(10) PRIMARY KEY,
    desc_produto VARCHAR(100) NOT NULL,
    dt_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS movimentacao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cod_produto VARCHAR(10) NOT NULL,
    tipo ENUM('E', 'S') NOT NULL,
    quantidade INT NOT NULL,
    data_movimento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (cod_produto) REFERENCES produto(cod_produto)
);

CREATE TABLE IF NOT EXISTS estoque (
    cod_produto VARCHAR(10) PRIMARY KEY,
    qtd INT NOT NULL DEFAULT 0,

    FOREIGN KEY (cod_produto) REFERENCES produto(cod_produto)
);

select *
from lojaville.cadastro_produto