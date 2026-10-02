<?php
require "conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Método inválido.");
}

$nome  = trim($_POST["nome"] ?? "");
$email = trim($_POST["email"] ?? "");
$curso = trim($_POST["curso"] ?? "");

if ($nome === "" || $email === "" || $curso === "") {
    exit("Preencha todos os campos.");
}

$sql = "INSERT INTO alunos (nome, email, curso)
        VALUES (:nome, :email, :curso)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    "nome" => $nome,
    "email" => $email,
    "curso" => $curso
]);

echo "Aluno cadastrado com sucesso!";
