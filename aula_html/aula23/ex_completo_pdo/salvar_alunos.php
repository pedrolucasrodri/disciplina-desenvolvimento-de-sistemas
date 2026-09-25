<?php

$host = "localhost";
$porta = "3306";
$banco = "escola_formulario";
$usuario = "root";
$senha = "";

try {
    $pdo = new PDO (
        "mysql:host=$host;port=$porta;dbname=$banco; charset=utf8mb4",
        $usuario,
        $senha
    );

    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        echo "Método inválido.";
        exit;
    }


    $nome = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $curso = trim($_POST["curso"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");
    $cpf = trim($_POST["cpf"] ?? "");
    $endereco = trim($_POST["endereco"] ?? "");
    $turma = trim($_POST["turma"] ?? "");
    $idade = trim($_POST["idade"] ?? "");

        if ($nome === "" || $email === "" || $curso === "" || $telefone === "" || $cpf === "" || $endereco === "" || $turma === "" || $idade === "" ){
        echo "Preencha todos os campos.";
        exit;
    }   

        $sql = "INSERT INTO alunos (nome, email, curso, telefone, cpf, endereco, turma, idade)
        VALUES (:nome, :email, :curso, :telefone, :cpf, :endereco, :turma, :idade)";

        $stmt = $pdo -> prepare("$sql");
        $stmt -> execute([
            "nome" => $nome,
            "email" => $email,
            "curso" => $curso,
            "telefone" => $telefone, 
            "cpf" => $cpf, 
            "endereco" => $endereco, 
            "turma" => $turma,
            "idade" => $idade 
        ]);

        echo "Anluno cadastrado com sucesso!";

}   catch (PDOException $erro) {
        echo "Erro: " . $erro -> getMessage();
}

?>