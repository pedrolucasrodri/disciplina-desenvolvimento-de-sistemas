<?php

require "conexao.php";

$sql = "SELECT
            m.id,
            m.cod_produto,
            p.desc_produto,
            m.tipo,
            m.quantidade,
            m.data_movimento
        FROM movimentacao m
        INNER JOIN cadastro_produto p
            ON m.cod_produto = p.cod_produto
        ORDER BY m.data_movimento DESC";

$stmt = $pdo->query($sql);

$movimentacoes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Movimentações</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<main>

    <h1>Histórico de Movimentações</h1>

    <?php if (!$movimentacoes): ?>

        <p>Nenhuma movimentação encontrada.</p>

    <?php else: ?>

        <table border="1">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Descrição</th>
                    <th>Tipo</th>
                    <th>Quantidade</th>
                    <th>Data</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($movimentacoes as $mov): ?>

                    <tr>

                        <td><?= htmlspecialchars($mov["id"]) ?></td>

                        <td><?= htmlspecialchars($mov["cod_produto"]) ?></td>

                        <td><?= htmlspecialchars($mov["desc_produto"]) ?></td>

                        <td>
                            <?= $mov["tipo"] === "E" ? "Entrada" : "Saída" ?>
                        </td>

                        <td><?= htmlspecialchars($mov["quantidade"]) ?></td>

                        <td><?= htmlspecialchars($mov["data_movimento"]) ?></td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php endif; ?>

    <p>
        <a href="index.html">Voltar</a>
    </p>

</main>

</body>
</html>