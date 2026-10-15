<?php

require "conexao.php";

$erro = null;
$produto = null;
$cod_produto = "";

$valorCodProduto = $_GET["cod_produto"] ?? "";

if (!is_string($valorCodProduto)) {

    $erro = "O código do produto informado é inválido.";

} else {

    $cod_produto = trim($valorCodProduto);

    if ($cod_produto === "") {

        $erro = "Produto não informado.";

    } elseif (strlen($cod_produto) > 10) {

        $erro = "O código do produto deve possuir no máximo 10 caracteres.";

    } else {

        $sql = "SELECT
                    cod_produto,
                    desc_produto
                FROM cadastro_produto
                WHERE cod_produto = :cod_produto";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            "cod_produto" => $cod_produto
        ]);

        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$produto) {
            $erro = "Produto não cadastrado.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Produto</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="app-container">

        <!-- CABEÇALHO -->
        <header>
            <h1>Editar Produto</h1>
        </header>

        <!-- CONTEÚDO PRINCIPAL -->
        <main class="historico-main">

            <section class="Cadastro historico-card editar-card">

                <h2>Dados do produto</h2>

                <?php if ($erro !== null): ?>

                    <p class="mensagem-erro">
                        <?= htmlspecialchars(
                            $erro,
                            ENT_QUOTES,
                            "UTF-8"
                        ) ?>
                    </p>

                    <div class="historico-acoes">

                        <a
                            href="consultar_produtos.php"
                            class="botao-voltar">
                            ← Voltar aos produtos
                        </a>

                    </div>

                <?php else: ?>

                    <!-- FORMULÁRIO DE EDIÇÃO -->
                    <form
                        action="atualizar.php"
                        method="POST"
                        class="panel-form editar-form">

                        <!-- Código original para localizar o registro -->
                        <input
                            type="hidden"
                            name="cod_original"
                            value="<?= htmlspecialchars(
                                (string) $produto["cod_produto"],
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>"
                        >

                        <div class="fields editar-fields">

                            <label for="cod_produto">
                                Código do produto
                            </label>

                            <input
                                type="text"
                                id="cod_produto"
                                name="cod_produto"
                                maxlength="10"
                                value="<?= htmlspecialchars(
                                    (string) $produto["cod_produto"],
                                    ENT_QUOTES,
                                    "UTF-8"
                                ) ?>"
                                required
                            >

                            <label for="desc_produto">
                                Descrição do produto
                            </label>

                            <input
                                type="text"
                                id="desc_produto"
                                name="desc_produto"
                                maxlength="255"
                                value="<?= htmlspecialchars(
                                    (string) $produto["desc_produto"],
                                    ENT_QUOTES,
                                    "UTF-8"
                                ) ?>"
                                required
                            >

                        </div>

                        <!-- BOTÕES -->
                        <div class="editar-acoes">

                            <button type="submit">
                                Salvar Alterações
                            </button>

                            <a
                                href="consultar_produtos.php"
                                class="botao-secundario">
                                Cancelar
                            </a>

                        </div>

                    </form>

                <?php endif; ?>

            </section>

        </main>

    </div>

</body>

</html>