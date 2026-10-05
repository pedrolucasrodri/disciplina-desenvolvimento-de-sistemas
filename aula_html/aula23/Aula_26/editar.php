<?php

require "conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    exit("ID inválido");
}

$sql = "SELECT *
        FROM alunos
        WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute(["id" => $id]);
$aluno = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$aluno) {
    exit("Aluno não encontrado");
}

?>

<!DOCTYPE html>
<html lang="pt-Br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aluno</title>

    <link rel="stylesheet" href="style.css">
</head>
<body><main class="card card-larga">

    <h1>Editar Aluno</h1>

    <form action="atualizar.php" method="POST">

        <input
            type="hidden"
            name="id"
            value="<?= $aluno['id'] ?>"
        >

        <label>Nome</label>
        <input
            type="text"
            name="nome"
            value="<?= htmlspecialchars($aluno['nome']) ?>"
            required
        >

        <label>Email</label>
        <input
            type="email"
            name="email"
            value="<?= htmlspecialchars($aluno['email']) ?>"
            required
        >

        <label>Curso</label>
        <input
            type="text"
            name="curso"
            value="<?= htmlspecialchars($aluno['curso']) ?>"
            required
        >

        <label>Idade</label>
        <input
            type="number"
            name="idade"
            value="<?= htmlspecialchars($aluno['idade']) ?>"
            required
        >

        <label>Cidade</label>
        <input
            type="text"
            name="cidade"
            value="<?= htmlspecialchars($aluno['cidade']) ?>"
            required
        >

        <label>Período</label>
        <input
            type="text"
            name="periodo"
            value="<?= htmlspecialchars($aluno['periodo']) ?>"
            required
        >

        <button type="submit">
            Atualizar
        </button>

    </form>

    <p>
        <a class="botao" href="consultar.php">Voltar</a>
    </p>

</main>

</body>
</html>