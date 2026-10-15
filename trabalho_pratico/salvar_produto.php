<?php

require "conexao.php";

$mensagem = "";
$sucesso = false;

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    $mensagem = "Método inválido. Envie o formulário de cadastro.";

} else {

    $valorCodigo = $_POST["cod_produto"] ?? "";
    $valorDescricao = $_POST["desc_produto"] ?? "";

    if (!is_string($valorCodigo) || !is_string($valorDescricao)) {

        $mensagem = "Os dados informados são inválidos.";

    } else {

        $cod_produto = trim($valorCodigo);
        $desc_produto = trim($valorDescricao);

        if (strlen($cod_produto) > 10) {

            $mensagem = "O código do produto deve possuir no máximo 10 caracteres.";

        } elseif (strlen($desc_produto) > 101) {

            $mensagem = "A descrição do produto deve possuir no máximo 101 caracteres.";

        } elseif ($cod_produto === "" || $desc_produto === "") {

            $mensagem = "Preencha todos os campos.";

        } else {

            try {

                $sql = "SELECT COUNT(*)
                        FROM cadastro_produto
                        WHERE cod_produto = :cod_produto
                           OR desc_produto = :desc_produto";

                $stmt = $pdo->prepare($sql);

                $stmt->execute([
                    "cod_produto" => $cod_produto,
                    "desc_produto" => $desc_produto
                ]);

                if ($stmt->fetchColumn() > 0) {

                    $mensagem = "Já existe um produto cadastrado com este código ou descrição.";

                } else {

                    $sql = "INSERT INTO cadastro_produto
                                (cod_produto, desc_produto)
                            VALUES
                                (:cod_produto, :desc_produto)";

                    $stmt = $pdo->prepare($sql);

                    $stmt->execute([
                        "cod_produto" => $cod_produto,
                        "desc_produto" => $desc_produto
                    ]);

                    $mensagem = "Produto cadastrado com sucesso!";
                    $sucesso = true;
                }

            } catch (PDOException $e) {

                if ($e->getCode() === "23000") {

                    $mensagem = "Este produto já existe. Verifique o código e a descrição.";

                } else {

                    $mensagem = "Ocorreu um erro ao cadastrar o produto. Tente novamente.";
                }
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

    <title>Resultado do Cadastro</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="app-container">

        <header>
            <h1>
                <?= $sucesso ? "Cadastro concluído" : "Resultado do cadastro" ?>
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

                <?php if ($sucesso): ?>

                    <p class="texto-auxiliar">
                        O produto foi registrado no sistema.
                    </p>

                <?php else: ?>

                    <p class="texto-auxiliar">
                        Confira as informações e tente novamente.
                    </p>

                <?php endif; ?>

                <div class="resultado-acoes">

                    <a href="index.html" class="botao-voltar">
                        ← Voltar ao início
                    </a>

                    <?php if (!$sucesso): ?>

                        <button
                            type="button"
                            onclick="history.back()">
                            Tentar novamente
                        </button>

                    <?php endif; ?>

                </div>

            </section>

        </main>

    </div>

</body>
</html>