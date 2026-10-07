<?php

require "conexao.php";

$sql = "SELECT
            e.cod_produto,
            p.desc_produto,
            e.qtd
        FROM estoque e
        INNER JOIN cadastro_produto p
            ON e.cod_produto = p.cod_produto
        ORDER BY e.cod_produto";

$stmt = $pdo->query($sql);

$estoque = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Consulta de Estoque</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<main>

    <h1>Estoque Atual</h1>

    <?php if (!$estoque): ?>

        <p>Nenhum produto encontrado.</p>

    <?php else: ?>

        <table border="1">

            <thead>
                <tr>
                    <th>Código</th>
                    <th>Descrição</th>
                    <th>Quantidade</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($estoque as $produto): ?>

                    <tr>
                        <td><?= htmlspecialchars($produto["cod_produto"]) ?></td>
                        <td><?= htmlspecialchars($produto["desc_produto"]) ?></td>
                        <td><?= htmlspecialchars($produto["qtd"]) ?></td>
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