<?php
require "conexao.php";

$mensagem = "";
$sucesso = false;
$cod_original = "";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $mensagem = "Método inválido. Envie o formulário de edição.";
} else {
    $valorCodigo = $_POST["cod_produto"] ?? "";
    $valorDescricao = $_POST["desc_produto"] ?? "";
    $valorCodigoOriginal = $_POST["cod_original"] ?? "";
    $cod_original = is_string($valorCodigoOriginal)
        ? trim($valorCodigoOriginal)
        : "";

    if (
        !is_string($valorCodigo)
        || !is_string($valorDescricao)
        || !is_string($valorCodigoOriginal)
    ) {
        $mensagem = "Os dados informados são inválidos.";
    } else {
        $cod_produto = trim($valorCodigo);
        $desc_produto = trim($valorDescricao);

        if (strlen($cod_produto) > 10) {
            $mensagem = "O código do produto deve possuir no máximo 10 caracteres.";
        } elseif (strlen($desc_produto) > 101) {
            $mensagem = "A descrição do produto deve possuir no máximo 101 caracteres.";
        } elseif ($cod_produto === "" || $desc_produto === "" || $cod_original === "") {
            $mensagem = "Preencha todos os campos.";
        } else {
            $sql = "SELECT COUNT(*)
                    FROM cadastro_produto
                    WHERE (
                            cod_produto = :cod_produto
                            OR desc_produto = :desc_produto
                          )
                      AND cod_produto <> :cod_original";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                "cod_produto"  => $cod_produto,
                "desc_produto" => $desc_produto,
                "cod_original" => $cod_original
            ]);

            if ($stmt->fetchColumn() > 0) {
                $mensagem = "Já existe um produto cadastrado com este código ou descrição.";
            } else {
                $sql = "UPDATE cadastro_produto
                        SET cod_produto = :cod_produto,
                            desc_produto = :desc_produto
                        WHERE cod_produto = :cod_original";

                $stmt = $pdo->prepare($sql);

                try {
                    $stmt->execute([
                        "cod_produto"  => $cod_produto,
                        "desc_produto" => $desc_produto,
                        "cod_original" => $cod_original
                    ]);

                    if ($stmt->rowCount() > 0) {
                        $mensagem = "Produto atualizado com sucesso!";
                        $sucesso = true;
                    } else {
                        $mensagem = "Nenhum registro foi alterado. Verifique os dados informados.";
                    }
                } catch (PDOException $e) {
                    $mensagem = "Erro ao atualizar cadastro.";
                }
            }
        }
    }
}

$voltaParaEdicao = !$sucesso && $cod_original !== "";

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Resultado da edição</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="app-container">

        <header>
            <h1>
                <?= $sucesso ? "Edição concluída" : "Resultado da edição" ?>
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
                        ? "Os dados do produto foram atualizados no sistema."
                        : "Confira as informações e tente novamente." ?>
                </p>

                <div class="resultado-acoes">

                    <a
                        href="<?= $voltaParaEdicao
                            ? 'editar.php?cod_produto=' . urlencode($cod_original)
                            : 'consultar_produtos.php' ?>"
                        class="botao-voltar">
                        <?= $voltaParaEdicao
                            ? "← Voltar à edição"
                            : "← Voltar aos produtos" ?>
                    </a>

                </div>

            </section>

        </main>

    </div>

</body>
</html>