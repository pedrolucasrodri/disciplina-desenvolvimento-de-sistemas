<?php

require "conexao.php";

$cod_produto = "";
$erro = null;
$estoque = [];

$valorCodProduto = $_GET["cod_produto"] ?? "";

if (!is_string($valorCodProduto)) {

    $erro = "O código do produto informado é inválido.";

} else {

    $cod_produto = trim($valorCodProduto);

    if (strlen($cod_produto) > 10) {

        $erro = "O código do produto deve possuir no máximo 10 caracteres.";

    } else {

        $sql = "SELECT
                    e.cod_produto,
                    p.desc_produto,
                    e.qtd
                FROM estoque e
                INNER JOIN cadastro_produto p
                    ON e.cod_produto = p.cod_produto";

        if ($cod_produto !== "") {
            $sql .= " WHERE e.cod_produto LIKE :cod_produto";
        }

        $sql .= " ORDER BY e.cod_produto";

        $stmt = $pdo->prepare($sql);

        if ($cod_produto !== "") {
            $stmt->execute([
                "cod_produto" => "%{$cod_produto}%"
            ]);
        } else {
            $stmt->execute();
        }

        $estoque = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Estoque</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="app-container">

        <!-- CABEÇALHO -->
        <header>
            <h1>Estoque Atual</h1>
        </header>

        <!-- CONTEÚDO PRINCIPAL -->
        <main class="historico-main">

            <section class="Cadastro historico-card">

                <h2>Produtos em estoque</h2>

                <form method="GET" action="" class="busca-produtos">

                    <div class="campo-busca">

                        <label for="cod_produto">
                            Buscar pelo código do produto
                        </label>

                        <input
                            type="text"
                            id="cod_produto"
                            name="cod_produto"
                            maxlength="10"
                            placeholder="Digite o código..."
                            value="<?= htmlspecialchars(
                                $cod_produto,
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>"
                        >

                    </div>

                    <button type="submit">
                        Buscar
                    </button>

                    <a href="consultar_estoque.php"
                       class="acao-link acao-limpar">
                        Limpar
                    </a>

                </form>

                <?php if ($erro !== null): ?>

                    <p class="mensagem-erro">
                        <?= htmlspecialchars(
                            $erro,
                            ENT_QUOTES,
                            "UTF-8"
                        ) ?>
                    </p>

                <?php elseif (empty($estoque)): ?>

                    <p class="mensagem-vazia">
                        Nenhum produto encontrado no estoque.
                    </p>

                <?php else: ?>

                    <!-- ÁREA DA TABELA -->
                    <div class="tabela-wrapper">

                        <table class="tabela-movimentacoes">

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

                                        <td>
                                            <?= htmlspecialchars(
                                                (string) $produto["cod_produto"],
                                                ENT_QUOTES,
                                                "UTF-8"
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                (string) $produto["desc_produto"],
                                                ENT_QUOTES,
                                                "UTF-8"
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                (string) $produto["qtd"],
                                                ENT_QUOTES,
                                                "UTF-8"
                                            ) ?>
                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                <?php endif; ?>

                <!-- BOTÃO VOLTAR -->
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