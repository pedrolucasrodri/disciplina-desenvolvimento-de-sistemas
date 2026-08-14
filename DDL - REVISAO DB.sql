create database if not exists db_begin
default character set utf8
default collate utf8_general_ci;

use db_begin;

create table if not exists cliente (
	pk_cpf char(11) primary key not null,
    nome_cliente varchar(75) not null,
    dt_nacimento date not null,
    num_celular char(11) not null,
    email varchar(75) not null
)
default character set utf8;

create table if not exists usuario (
	pk_id_usuario int auto_increment primary key,
	fk_cpf char(11) not null,
	usuario char(12) not null,
    senha char(15) not null,
    
    foreign key (fk_cpf) references cliente(pk_cpf)
)
default character set utf8;

create table if not exists cnh (
	pk_cnh char(9) primary key not null,
    fk_cpf char(11) not null,

    foreign key (fk_cpf) references cliente(pk_cpf)
)
default character set utf8;

create table if not exists carro (
	pk_chassi char(17) not null primary key,
	marca varchar(14) not null,
    modelo varchar(80) not null,
    ano date not null,
    placa  char(7) not null,
    cor varchar(25) not null,
    categoria varchar(2) not null, -- sera definido por A ou B ou AB...
    pt_motor char(3) not null
) 
default character set utf8;

create table if not exists reserva (
	pk_id_reserva int auto_increment primary key,
    fk_cpf char(11) not null,
    dt_retirada date not null,
    hr_retirada time not null,
    dt_devolucao date not null,
    hr_devolucao time not null,
    tp_retirada char(1) not null,
    tp_devolucao char(1) not null,
    valor decimal(7,2),
    
	foreign key (fk_cpf) references cliente(pk_cpf)
)
default character set utf8;

create table if not exists funcionarios (
	pk_cpf char(11) not null primary key,
    nome_cliente varchar(75) not null,
    dt_nacimento date not null,
    num_celular char(11) not null,
    email varchar(75) not null
)
default character set utf8;
