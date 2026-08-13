create database if not exists db_begin
default character set utf8
default collate utf8_general_ci;

use db_general;

create table if not exists cliente (
	pk_cpf char(11) not null primary key,
    nome_cliente varchar(75) not null,
    dt_nacimento date not null,
    num_celular char(11) not null,
    email varchar(75) not null
)
default character set utf8;

create table if not exists usuarios (
	pk_usuario char(12) not null primary key,
    fk_email varchar(75) not null,
    senha char(15) not null,
    
    foreign key (fk_emai) references cliente(email)
)
default character set utf8;

create table if not exists cnh (
	pk_cnh char(9) primary key not null,
    fk_cpf char(11) not null,
    fk_nome_cliente varchar(75) not null,
    
    foreign key (fk_cpf) references cliente(pk_cpf),
    foreign key (fk_nome_cliente) references cliente(_nome_cliente)
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
    pt_motor char(3) not null,
) 
default character set utf8;




