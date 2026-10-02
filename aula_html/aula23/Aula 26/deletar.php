<?php

require "conexao.php";

if($_SERVER['REQUEST_METHOD'] !== "POST") {
    exit("Método inválido");
}

$id    = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);


if (!$id) {
    exit("ID inválido");
}

$sql = "DELETE FROM alunos
        WHERE id = :id";

$stmt = $pdo -> prepare($sql);
$stmt->execute([
    "id" => $id
]);

if ($stmt->rowCount() > 0) {
    echo "Aluno excluido com sucesso";
} else {
    echo "Nenhum aluno encontrado";
}


?>