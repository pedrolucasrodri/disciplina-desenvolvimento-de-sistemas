<?php

require "conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Método inválido");
}

$cod_produto = trim($_POST["cod_produto"] ?? "");

if (strlen($cod_produto) > 10) {
    exit("O código do produto deve possuir no máximo 10 caracteres.");
}

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

/* Verifica se o produto existe */

$sql = "SELECT cod_produto
        FROM cadastro_produto
        WHERE cod_produto = :cod_produto";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    "cod_produto" => $cod_produto
]);

$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    exit("Produto não cadastrado.");
}

/* Consulta estoque */

$sql = "SELECT qtd
        FROM estoque
        WHERE cod_produto = :cod_produto";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    "cod_produto" => $cod_produto
]);

$estoque = $stmt->fetch(PDO::FETCH_ASSOC);

/* Validações */

if (!$estoque) {

    if ($tipo === "S") {
        exit("Não é possível realizar saída sem estoque.");
    }

} else {

    $saldoAtual = $estoque["qtd"];

    if ($tipo === "S" && $quantidade > $saldoAtual) {
        exit("Estoque insuficiente.");
    }
}

/* Registra movimentação SOMENTE após validar */

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

/* Atualiza estoque */

if (!$estoque) {

    $sql = "INSERT INTO estoque
            (cod_produto, qtd)
            VALUES
            (:cod_produto, :quantidade)";

} elseif ($tipo === "E") {

    $sql = "UPDATE estoque
            SET qtd = qtd + :quantidade
            WHERE cod_produto = :cod_produto";

} else {

    $sql = "UPDATE estoque
            SET qtd = qtd - :quantidade
            WHERE cod_produto = :cod_produto";
}

$stmt = $pdo->prepare($sql);

$stmt->execute([
    "quantidade" => $quantidade,
    "cod_produto" => $cod_produto
]);

echo "Movimentação registrada com sucesso!";