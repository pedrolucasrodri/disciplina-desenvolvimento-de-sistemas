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

INSERT INTO cadastro_produto
(cod_produto, desc_produto)
VALUES
('BAT0123', 'Bateria 12V 60Ah');

INSERT INTO cadastro_produto
(cod_produto, desc_produto)
VALUES
('PNE0456', 'Pneu Aro 15');

INSERT INTO cadastro_produto
(cod_produto, desc_produto)
VALUES
('OLE0789', 'Óleo Lubrificante 5W30');

INSERT INTO cadastro_produto
(cod_produto, desc_produto)
VALUES
('FLT0101', 'Filtro de Óleo');

INSERT INTO cadastro_produto
(cod_produto, desc_produto)
VALUES
('VEL0202', 'Jogo de Velas');

INSERT INTO cadastro_produto
(cod_produto, desc_produto)
VALUES
('AMP0303', 'Amortecedor Dianteiro');

INSERT INTO cadastro_produto
(cod_produto, desc_produto)
VALUES
('DIS0404', 'Disco de Freio');

INSERT INTO cadastro_produto
(cod_produto, desc_produto)
VALUES
('PAS0505', 'Pastilha de Freio');

INSERT INTO cadastro_produto
(cod_produto, desc_produto)
VALUES
('COR0606', 'Correia Dentada');

INSERT INTO cadastro_produto
(cod_produto, desc_produto)
VALUES
('LMP0707', 'Lâmpada H4 60/55W');