<?php
require "conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Método inválido.");
}

$id    = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$nome  = trim($_POST["nome"] ?? "");
$email = trim($_POST["email"] ?? "");
$curso = trim($_POST["curso"] ?? "");

if (!$id || $nome === "" || $email === "" || $curso === "") {
    exit("Preencha todos os campos corretamente.");
}

$sql = "UPDATE alunos
        SET nome = :nome, email = :email, curso = :curso
        WHERE id = :id";

$stmt = $pdo -> prepare($sql);
$stmt->execute([
    "id" => $id,
    "nome" => $nome,
    "email" => $email,
    "curso" => $curso
]);

if ($stmt->rowCount() > 0) {
    echo "Aluno atualizado com sucesso!";
} else {
    echo "Nenhum registro foi alterado. Verifique o ID ou os dados informados.";
}
