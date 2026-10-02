<?php 
    require "conexao.php";

    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

    if ($id) {
        $sql = "SELECT id, nome, email, curso, criado_em 
        FROM alunos 
        WHERE id = :id";   

        $stmt = $pdo->prepare($sql);
        $stmt->execute(["id" => $id]);
    } else {
        $sql = "SELECT id, nome, email, curso, criado_em 
        FROM alunos 
        ORDER BY id";

        $stmt = $pdo->query($sql);
    }

    $alunos = $stmt->fetchALL();
?>

<!DOCTYPE html>
<html lang="pt-br">
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
                        <th>criado em</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($alunos as $aluno): ?>
                        <tr>
                            <td><?= htmlspecialchars($aluno["id"]) ?></td>
                            <td><?= htmlspecialchars($aluno["nome"]) ?></td>
                            <td><?= htmlspecialchars($aluno["email"]) ?></td>
                            <td><?= htmlspecialchars($aluno["curso"]) ?></td>
                            <td><?= htmlspecialchars($aluno["criado_em"]) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php endif; ?>
        <p><a href="index.html">Voltar</a></p>
    </main>
</body>
</html>