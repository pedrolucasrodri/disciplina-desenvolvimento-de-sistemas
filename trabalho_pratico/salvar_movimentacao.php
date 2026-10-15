<?php

require "conexao.php";

$mensagem = "";
$sucesso = false;

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    $mensagem = "Método inválido. Envie o formulário de movimentação.";

} else {

    $valorCodigo = $_POST["cod_produto"] ?? "";
    $valorTipo = $_POST["tipo"] ?? "";
    $valorQuantidade = $_POST["quantidade"] ?? "";

    if (
        !is_string($valorCodigo) ||
        !is_string($valorTipo) ||
        !is_string($valorQuantidade)
    ) {

        $mensagem = "Os dados informados são inválidos.";

    } else {

        $cod_produto = trim($valorCodigo);
        $tipo = trim($valorTipo);
        $quantidade = filter_var(
            $valorQuantidade,
            FILTER_VALIDATE_INT
        );

        if (strlen($cod_produto) > 10) {

            $mensagem = "O código do produto deve possuir no máximo 10 caracteres.";

        } elseif (
            $cod_produto === "" ||
            $quantidade === false ||
            $quantidade <= 0 ||
            !in_array($tipo, ["E", "S"], true)
        ) {

            $mensagem = "Informe um código, um tipo de movimentação e uma quantidade válida.";

        } else {

            // Verifica se o produto está cadastrado
            $sql = "SELECT cod_produto
                    FROM cadastro_produto
                    WHERE cod_produto = :cod_produto";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                "cod_produto" => $cod_produto
            ]);

            $produto = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$produto) {

                $mensagem = "Produto não cadastrado.";

            } else {

                try {

                    // Inicia uma transação para manter o estoque
                    // e o histórico consistentes.
                    $pdo->beginTransaction();

                    // CONSULTA CORRETA DO ESTOQUE
                    $sql = "SELECT qtd
                            FROM estoque
                            WHERE cod_produto = :cod_produto
                            FOR UPDATE";

                    $stmt = $pdo->prepare($sql);

                    $stmt->execute([
                        "cod_produto" => $cod_produto
                    ]);

                    $estoque = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Produto ainda não possui registro de estoque
                    if (!$estoque && $tipo === "S") {

                        $pdo->rollBack();

                        $mensagem = "Não é possível realizar saída sem estoque.";

                    } elseif (
                        $estoque &&
                        $tipo === "S" &&
                        $quantidade > (int) $estoque["qtd"]
                    ) {

                        $pdo->rollBack();

                        $mensagem = "Estoque insuficiente. Saldo atual: "
                            . (int) $estoque["qtd"] . " unidades.";

                    } else {

                        // Atualiza ou cria o saldo
                        if (!$estoque) {

                            // Primeira entrada do produto
                            $sql = "INSERT INTO estoque
                                        (cod_produto, qtd)
                                    VALUES
                                        (:cod_produto, :quantidade)";

                        } elseif ($tipo === "E") {

                            // Entrada: soma ao saldo atual
                            $sql = "UPDATE estoque
                                    SET qtd = qtd + :quantidade
                                    WHERE cod_produto = :cod_produto";

                        } else {

                            // Saída: subtrai do saldo atual
                            $sql = "UPDATE estoque
                                    SET qtd = qtd - :quantidade
                                    WHERE cod_produto = :cod_produto";
                        }

                        $stmt = $pdo->prepare($sql);

                        $stmt->execute([
                            "cod_produto" => $cod_produto,
                            "quantidade" => $quantidade
                        ]);

                        // Registra o histórico da movimentação
                        $sql = "INSERT INTO movimentacao
                                    (cod_produto, tipo, quantidade)
                                VALUES
                                    (:cod_produto, :tipo, :quantidade)";

                        $stmt = $pdo->prepare($sql);

                        $stmt->execute([
                            "cod_produto" => $cod_produto,
                            "tipo" => $tipo,
                            "quantidade" => $quantidade
                        ]);

                        $pdo->commit();

                        $mensagem = "Movimentação registrada com sucesso!";
                        $sucesso = true;
                    }

                } catch (PDOException $e) {

                    if ($pdo->inTransaction()) {
                        $pdo->rollBack();
                    }

                    if ($e->getCode() === "23000") {

                        $mensagem = "Não foi possível concluir a movimentação devido a uma restrição do banco de dados.";

                    } else {

                        $mensagem = "Ocorreu um erro ao registrar a movimentação. Verifique os dados e tente novamente.";
                    }
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

    <title>Resultado da Movimentação</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="app-container">

        <header>
            <h1>
                <?= $sucesso
                    ? "Movimentação concluída"
                    : "Resultado da movimentação" ?>
            </h1>
        </header>

        <main class="historico-main">

            <section class="Cadastro historico-card resultado-card">

                <div class="resultado-icone <?= $sucesso
                    ? 'icone-sucesso'
                    : 'icone-erro' ?>">

                    <?= $sucesso ? "✓" : "!" ?>

                </div>

                <h2>
                    <?= $sucesso ? "Tudo certo!" : "Atenção!" ?>
                </h2>

                <p class="mensagem-resultado <?= $sucesso
                    ? 'resultado-sucesso'
                    : 'resultado-erro' ?>">

                    <?= htmlspecialchars(
                        $mensagem,
                        ENT_QUOTES,
                        "UTF-8"
                    ) ?>

                </p>

                <p class="texto-auxiliar">
                    <?= $sucesso
                        ? "O estoque e o histórico foram atualizados."
                        : "Confira o código do produto, o tipo de movimentação e o saldo disponível." ?>
                </p>

                <div class="resultado-acoes">

                    <a href="index.html" class="botao-voltar">
                        ← Voltar ao início
                    </a>

                </div>

            </section>

        </main>

    </div>

</body>

</html>