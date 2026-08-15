use db_begin;

insert into carro 
(pk_chassi, marca, modelo, ano, placa, cor , categoria, pt_motor)
values 
('9BWZZZ377VT004251', 'Volkswagen', 'Polo', '2025', 'ABC1234', 'Branco', 'A', '1.0'),
('9BWZZZ377VT004252', 'Fiat', 'Argo', '2026', 'DEF5678', 'Preto', 'B', '1.3'),
('9BWZZZ377VT004253', 'Chevrolet', 'Onix LT', '2026', 'GHI9012', 'Prata', 'B', '1.0'),
('9BWZZZ377VT004254', 'Fiat', 'Mobi', '2023', 'JKL3456', 'Cinza', 'AB', '2.0'),
('9BWZZZ377VT004255', 'Hyunday', 'Hb20', '2024', 'MNO7890', 'Azul', 'AB', '2.0');

insert into cliente
(pk_cpf, nome_cliente, dt_nascimento, num_celular, email)
values
('12345678901', 'João Silva', '1990-05-10', '11987654321', 'joao@email.com'),
('23456789012', 'Maria Souza', '1988-09-15', '11976543210', 'maria@email.com'),
('34567890123', 'Carlos Oliveira', '1995-03-22', '11965432109', 'carlos@email.com'),
('45678901234', 'Ana Pereira', '1992-11-08', '11954321098', 'ana@email.com'),
('56789012345', 'Lucas Santos', '1985-07-30', '11943210987', 'lucas@email.com');

insert into cnh
(pk_cnh, fk_cpf) 
values 
('123456789', '12345678901'),
('234567890', '23456789012'),
('345678901', '34567890123'),
('456789012', '45678901234'),
('567890123', '56789012345');

insert into funcionarios
(pk_cpf, nome_func, dt_nascimento, num_celular, email)
values
('11111111111', 'Pedro Almeida', '1980-04-12', '11911111111', 'pedro@empresa.com'),
('22222222222', 'Fernanda Lima', '1987-06-25', '11922222222', 'fernanda@empresa.com'),
('33333333333', 'Ricardo Costa', '1991-08-17', '11933333333', 'ricardo@empresa.com'),
('44444444444', 'Juliana Rocha', '1989-10-03', '11944444444', 'juliana@empresa.com'),
('55555555555', 'Marcos Ferreira', '1984-12-29', '11955555555', 'marcos@empresa.com');

insert into reserva 
(fk_cpf, fk_chassi, dt_retirada, hr_retirada, dt_devolucao, hr_devolucao, tp_retirada, tp_devolucao, valor)
values
('12345678901', '9BWZZZ377VT004251','2025-01-10', '08:00:00', '2025-01-15', '18:00:00', 'A', 'A', 750.00),
('23456789012', '9BWZZZ377VT004252','2025-02-05', '09:00:00', '2025-02-08', '17:00:00', 'C', 'A', 420.50),
('34567890123', '9BWZZZ377VT004253','2025-03-12', '10:00:00', '2025-03-18', '16:00:00', 'C', 'C', 980.00),
('45678901234', '9BWZZZ377VT004254','2025-04-20', '07:30:00', '2025-04-25', '19:00:00', 'A', 'C', 850.75),
('56789012345', '9BWZZZ377VT004255','2025-05-02', '11:00:00', '2025-05-05', '15:00:00', 'C', 'A', 399.90);

insert into usuario
(fk_cpf, usuario, senha)
values
('12345678901', 'joaosilva', 'senha123'),
('23456789012', 'mariasouza', 'senha234'),
('34567890123', 'carlosoli', 'senha345'),
('45678901234', 'anapereira', 'senha456'),
('56789012345', 'lucassanto', 'senha567');





















