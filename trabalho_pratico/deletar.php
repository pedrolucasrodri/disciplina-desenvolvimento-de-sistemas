<?php

require "conexao.php";

$mensagem = "";
$sucesso = false;
$cod_produto = trim(
    filter_input(INPUT_GET, "cod_produto") ?? ""
);

if ($cod_produto === "") {
    $mensagem = "Produto não informado.";
} else {
    $sql = "SELECT qtd
            FROM estoque
            WHERE cod_produto = :cod_produto";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "cod_produto" => $cod_produto
    ]);
    $estoque = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($estoque && $estoque["qtd"] > 0) {
        $mensagem = "Não é possível excluir. Existem {$estoque['qtd']} unidades em estoque.";
    } else {
        $sql = "SELECT COUNT(*)
                FROM movimentacao
                WHERE cod_produto = :cod_produto";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            "cod_produto" => $cod_produto
        ]);
        $movimentacoes = $stmt->fetchColumn();

        if ($movimentacoes > 0) {
            $mensagem = "Não é possível excluir. Produto possui movimentações registradas.";
        } else {
            $sql = "DELETE
                    FROM cadastro_produto
                    WHERE cod_produto = :cod_produto";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                "cod_produto" => $cod_produto
            ]);

            if ($stmt->rowCount() > 0) {
                $mensagem = "Cadastro excluído com sucesso.";
                $sucesso = true;
            } else {
                $mensagem = "Nenhum cadastro encontrado.";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Resultado da exclusão</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="app-container">

        <header>
            <h1>
                <?= $sucesso ? "Exclusão concluída" : "Resultado da exclusão" ?>
            </h1>
        </header>

        <main class="historico-main">

            <section class="Cadastro historico-card resultado-card">

                <div class="resultado-icone <?= $sucesso ? 'icone-sucesso' : 'icone-erro' ?>">
                    <?= $sucesso ? "✓" : "!" ?>
                </div>

                <h2>
                    <?= $sucesso ? "Tudo certo!" : "Atenção!" ?>
                </h2>

                <p class="mensagem-resultado <?= $sucesso ? 'resultado-sucesso' : 'resultado-erro' ?>">
                    <?= htmlspecialchars(
                        $mensagem,
                        ENT_QUOTES,
                        "UTF-8"
                    ) ?>
                </p>

                <p class="texto-auxiliar">
                    <?= $sucesso
                        ? "O produto foi removido do sistema."
                        : "Confira o código e as condições para excluir o produto." ?>
                </p>

                <div class="resultado-acoes">

                    <a href="consultar_produtos.php" class="botao-voltar">
                        ← Voltar a tela de produtos
                    </a>

                </div>

            </section>

        </main>

    </div>

</body>
</html>