CREATE DATABASE IF NOT EXISTS escola_formulario
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE escola_formulario;

CREATE TABLE IF NOT EXISTS alunos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(120) UNIQUE NOT NULL,
  curso VARCHAR(100) NOT NULL,
  idade INT NOT NULL,
  cidade VARCHAR(100) NOT NULL,
  periodo ENUM('Matutino', 'Vespertino', 'Noturno') NOT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
