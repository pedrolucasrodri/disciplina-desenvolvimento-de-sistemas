<?php

require "conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    exit("ID inválido");
}

$sql = "DELETE FROM alunos
        WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    "id" => $id
]);

if ($stmt->rowCount() > 0) {
    echo "Aluno excluído com sucesso!";
} else {
    echo "Nenhum aluno encontrado.";
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