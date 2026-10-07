<?php

require "conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Método inválido");
}

$cod_produto = trim($_POST["cod_produto"] ?? "");
$tipo = trim($_POST["tipo"] ?? "");
$quantidade = filter_input(
    INPUT_POST,
    "quantidade",
    FILTER_VALIDATE_INT
);

if (
    $cod_produto === "" ||
    !$quantidade ||
    !in_array($tipo, ["E", "S"])
) {
    exit("Dados inválidos.");
}

/* registra a movimentação */

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

/* verifica se já existe no estoque */

$sql = "SELECT qtd
        FROM estoque
        WHERE cod_produto = :cod_produto";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    "cod_produto" => $cod_produto
]);

$estoque = $stmt->fetch();

/* primeira movimentação */

if (!$estoque) {

    if ($tipo === "S") {
        exit("Não é possível realizar saída sem estoque.");
    }

    $sql = "INSERT INTO estoque
            (cod_produto, qtd)
            VALUES
            (:cod_produto, :quantidade)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        "cod_produto" => $cod_produto,
        "quantidade" => $quantidade
    ]);

} else {

    $saldoAtual = $estoque["qtd"];

    if ($tipo === "E") {

        $sql = "UPDATE estoque
                SET qtd = qtd + :quantidade
                WHERE cod_produto = :cod_produto";

    } else {

        if ($quantidade > $saldoAtual) {
            exit("Estoque insuficiente.");
        }

        $sql = "UPDATE estoque
                SET qtd = qtd - :quantidade
                WHERE cod_produto = :cod_produto";
    }

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        "quantidade" => $quantidade,
        "cod_produto" => $cod_produto
    ]);
}

echo "Movimentação registrada com sucesso!";