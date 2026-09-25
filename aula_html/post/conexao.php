<?php

$host = "localhost";
$dbname = "escola";
$usuario = "root";
$senha = "";

try {

    $conexao = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $usuario,
        $senha
    );

    $conexao->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $e) {

    die("Erro na conexão: " . $e->getMessage());

}