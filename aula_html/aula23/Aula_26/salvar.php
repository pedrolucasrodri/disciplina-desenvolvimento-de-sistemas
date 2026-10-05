<?php
require "conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Método inválido.");
}

$nome  = trim($_POST["nome"] ?? "");
$email = trim($_POST["email"] ?? "");
$curso = trim($_POST["curso"] ?? "");
$idade = trim($_POST["idade"] ?? "");
$cidade = trim($_POST["cidade"] ?? "");
$periodo = trim($_POST["periodo"] ?? "");

$periodosPermitidos = [
    "Vespertino",
    "Matutino",
    "Noturno"
];

if ($nome === "") {
    exit("O campo nome é obrigatorio");
}

if (
    !filter_var($email, FILTER_VALIDATE_EMAIL)
    || $email === ""
) {
    exit("Email inválido");
}

if ($curso === "") {
    exit("O campo curso é obrigatório");
}

if ($idade < 7) {
    exit ("Idade inválida. O aluno deve ter no mínimo 7 anos.");
}


if ($cidade === "") {
    exit("O campo cidade é obrigatório");
}

if (!in_array($periodo, $periodosPermitidos, true)){    
    exit ("Período inválido");
}       

$sql = "INSERT INTO alunos (nome, email, curso, idade, cidade, periodo)
        VALUES (:nome, :email, :curso, :idade, :cidade, :periodo)";

$stmt = $pdo->prepare($sql);

try{
    $stmt->execute([
        "nome" => $nome,
        "email" => $email,
        "curso" => $curso,
        "idade" => $idade,
        "cidade" => $cidade,
        "periodo" => $periodo
    ]);
    
    echo "Aluno cadastrado com sucesso!";

} catch (PDOException $e) {
    exit("Erro ao cadastrar aluno: Email já cadastrado.");
}

