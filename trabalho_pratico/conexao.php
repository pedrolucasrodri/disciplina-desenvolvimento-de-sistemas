<?php
$host = "localhost";
$dbname = "lojaVille";
$port = '3306';
$usuario = "root";
$senha = "";

try {
    $pdo= new PDO (
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8",
        $usuario,
        $senha
    );

    $pdo -> setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $e) {
    die("Erro na conexão: " . $e -> getMessage());
}

?>