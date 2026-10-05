<?php

require "conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$nome = trim($_GET["nome"] ?? "");

if ($id) {

    $sql = "SELECT id, nome, email, curso, idade, cidade, periodo, criado_em
            FROM alunos
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(["id" => $id]);

} elseif ($nome !== "") {

    $sql = "SELECT id, nome, email, curso, idade, cidade, periodo, criado_em
            FROM alunos
            WHERE nome LIKE :nome
            ORDER BY nome";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "nome" => "%$nome%"
    ]);

} else {

    $sql = "SELECT id, nome, email, curso, idade, cidade, periodo, criado_em
            FROM alunos
            ORDER BY nome";

    $stmt = $pdo->query($sql);
}

$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de alunos</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main class="card card-larga">
        <h1>Alunos Cadastrados</h1>

        <?php if (!$alunos): ?>
            <p>Nenhum aluno encontrado.</p>
            <?php else: ?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>curso</th>
                        <th>Idade</th>
                        <th>Cidade</th>
                        <th>Período</th>
                        <th>criado em</th>
                        <th>Açoes</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($alunos as $aluno): ?>
                        <tr>
                            <td><?= htmlspecialchars($aluno["id"]) ?></td>
                            <td><?= htmlspecialchars($aluno["nome"]) ?></td>
                            <td><?= htmlspecialchars($aluno["email"]) ?></td>
                            <td><?= htmlspecialchars($aluno["curso"]) ?></td>
                            <td><?= htmlspecialchars($aluno["idade"]) ?></td>
                            <td><?= htmlspecialchars($aluno["cidade"]) ?></td>
                            <td><?= htmlspecialchars($aluno["periodo"]) ?></td>
                            <td><?= htmlspecialchars($aluno["criado_em"]) ?></td>

                            <td>
                                <a href="editar.php?id=<?= $aluno['id'] ?>">Editar</a>
                                |
                                <a
                                    href="deletar.php?id=<?= $aluno['id'] ?>"
                                    onclick="return confirm('Deseja excluir este aluno?')"
                                    >
                                    Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <p><a class="botao" href="index.html">Voltar</a></p>
    </main>
</body>
</html>