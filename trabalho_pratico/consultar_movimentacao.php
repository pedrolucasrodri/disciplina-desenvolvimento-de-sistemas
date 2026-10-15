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
$movimentacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Movimentações</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="app-container">

        <header>
            <h1>Histórico de Movimentações</h1>
        </header>

        <main class="historico-main">

            <section class="Cadastro historico-card">

                <h2>Movimentações registradas</h2>

                <?php if (empty($movimentacoes)): ?>

                    <p class="mensagem-vazia">
                        Nenhuma movimentação encontrada.
                    </p>

                <?php else: ?>

                    <div class="tabela-wrapper">

                        <table class="tabela-movimentacoes">

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

                                        <td>
                                            <?= htmlspecialchars((string) $mov["id"], ENT_QUOTES, "UTF-8") ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars((string) $mov["cod_produto"], ENT_QUOTES, "UTF-8") ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars((string) $mov["desc_produto"], ENT_QUOTES, "UTF-8") ?>
                                        </td>

                                        <td>
                                            <?php
                                            if ($mov["tipo"] === "E") {
                                                $tipoTexto = "Entrada";
                                                $tipoClasse = "entrada";
                                            } elseif ($mov["tipo"] === "S") {
                                                $tipoTexto = "Saída";
                                                $tipoClasse = "saida";
                                            } else {
                                                $tipoTexto = "Outro";
                                                $tipoClasse = "";
                                            }
                                            ?>

                                            <span class="tipo-movimentacao <?= $tipoClasse ?>">
                                                <?= $tipoTexto ?>
                                            </span>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars((string) $mov["quantidade"], ENT_QUOTES, "UTF-8") ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars((string) $mov["data_movimento"], ENT_QUOTES, "UTF-8") ?>
                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                <?php endif; ?>

                <div class="historico-acoes">
                    <a href="index.html" class="botao-voltar">
                        ← Voltar ao início
                    </a>
                </div>

            </section>

        </main>

    </div>

</body>

</html>