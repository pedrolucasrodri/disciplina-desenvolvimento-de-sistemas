<?php
require "conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Método inválido.");
}

$id    = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
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

$sql = "UPDATE alunos
        SET nome = :nome, email = :email, curso = :curso, idade = :idade, cidade = :cidade, periodo = :periodo
        WHERE id = :id";

$stmt = $pdo -> prepare($sql);
try {

    $stmt->execute([
        "id" => $id,
        "nome" => $nome,
        "email" => $email,
        "curso" => $curso,
        "idade" => $idade,
        "cidade" => $cidade,
        "periodo" => $periodo
    ]);

   
    if ($stmt->rowCount() > 0) {
        echo "Aluno atualizado com sucesso!";
    }
    else {
        echo "Nenhum registro foi alterado. Verifique o ID ou os dados informados.";
 
    }  
        
}catch (PDOException $e) {
    exit("Erro ao atualizar aluno: Email já cadastrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <main>
        <table>
            <p><a class="botao" href="index.html">Voltar</a></p>
        </table>
    </main>
</body>
</html>