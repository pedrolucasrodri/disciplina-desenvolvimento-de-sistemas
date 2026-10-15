```php
<?php

require "conexao.php";

// Inicializa as variáveis
$cod_produto = "";
$erro = null;
$estoque = [];

// Recebe o código pesquisado
$valorCodProduto = $_GET["cod_produto"] ?? "";

// Valida a pesquisa
if (!is_string($valorCodProduto)) {

    $erro = "O código do produto informado é inválido.";

} else {

    $cod_produto = trim($valorCodProduto);

    if (strlen($cod_produto) > 10) {

        $erro = "O código do produto deve possuir no máximo 10 caracteres.";

    } else {

        // Consulta com filtro, se o código foi informado
        if ($cod_produto !== "") {

            $sql = "SELECT
                        cod_produto,
                        desc_produto,
                        dt_cadastro
                    FROM cadastro_produto
                    WHERE cod_produto LIKE :cod_produto
                    ORDER BY cod_produto";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                "cod_produto" => "%{$cod_produto}%"
            ]);

        } else {

            // Lista todos os produtos
            $sql = "SELECT
                        cod_produto,
                        desc_produto,
                        dt_cadastro
                    FROM cadastro_produto
                    ORDER BY cod_produto";

            $stmt = $pdo->query($sql);
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

    <title>Consulta de Produtos</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="app-container">

        <header>
            <h1>Produtos</h1>
        </header>

        <main class="historico-main">

            <section class="Cadastro historico-card">

                <h2>Produtos cadastrados</h2>

                <!-- PESQUISA -->
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

                    <a href="consultar_produtos.php"
                       class="acao-link acao-limpar">
                        Limpar
                    </a>

                </form>

                <!-- RESULTADOS -->
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
                        Nenhum produto encontrado.
                    </p>

                <?php else: ?>

                    <div class="tabela-wrapper">

                        <table class="tabela-movimentacoes tabela-produtos">

                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Descrição</th>
                                    <th>Data de cadastro</th>
                                    <th>Ações</th>
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
                                                (string) $produto["dt_cadastro"],
                                                ENT_QUOTES,
                                                "UTF-8"
                                            ) ?>
                                        </td>

                                        <td>
                                            <div class="acoes-produto">

                                                <a
                                                    href="editar.php?cod_produto=<?= urlencode(
                                                        (string) $produto["cod_produto"]
                                                    ) ?>"
                                                    class="acao-link acao-editar">
                                                    Editar
                                                </a>

                                                <a
                                                    href="deletar.php?cod_produto=<?= urlencode(
                                                        (string) $produto["cod_produto"]
                                                    ) ?>"
                                                    class="acao-link acao-excluir"
                                                    onclick="return confirm('Deseja excluir este produto?')">
                                                    Excluir
                                                </a>

                                            </div>
                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                <?php endif; ?>

                <!-- VOLTAR -->
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
```