create database if not exists empresa;

use empresa;

CREATE TABLE IF NOT EXISTS usuarios (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL,
    login TEXT NOT NULL UNIQUE,
    senha TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS produtos (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL,
    descricao TEXT,
    preco REAL NOT NULL,
    estoque_minimo INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS estoque (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    produto_id INTEGER NOT NULL,
    tipo_movimentacao TEXT CHECK(tipo_movimentacao IN ('E','S')) NOT NULL,
    quantidade INTEGER NOT NULL,
    data_movimentacao DATE NOT NULL,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) 
);

