    CREATE DATABASE IF NOT EXISTS escola_formulario
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

    USE escola_formulario;

    CREATE TABLE IF NOT EXISTS alunos (
        id          INT AUTO_INCREMENT PRIMARY KEY,
        nome        VARCHAR(100) NOT NULL,
        email       VARCHAR(100) NOT NULL,
        curso       VARCHAR(100) NOT NULL,
        telefone    CHAR(11) NOT NULL,
        cpf         CHAR(11) NOT NULL,
        endereco    VARCHAR(200) NOT NULL,
        turma       VARCHAR(10) NOT NULL,
        idade      	CHAR(2),
        
        cirado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    
CREATE TABLE IF NOT EXISTS universidade (
	id 			INT AUTO_INCREMENT PRIMARY KEY,
    nome		VARCHAR(100),
    endereco	VARCHAR(200),
    cnpj 		CHAR(14),
    telefone	CHAR(11),
    
     cirado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
    
