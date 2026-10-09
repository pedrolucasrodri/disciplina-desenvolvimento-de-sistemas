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

$quantidade = filter_input(INPUT_POST, "quantidade",FILTER_VALIDATE_INT);

if ($cod_produto === "" || !$quantidade || !in_array($tipo, ["E", "S"])
) {
    exit("Dados inválidos.");
}

// Verificação se produto existe na tabela produtos
$sql = "SELECT 
            cod_produto
        FROM cadastro_produto
        WHERE cod_produto = :cod_produto";

$stmt = $pdo->prepare($sql);

$stmt -> execute([
    "cod_produto" => $cod_produto
]);

$produto = $stmt -> fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    exit("Produto não cadastrado.");
}

// Registra movimentação.

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

// Verificação se já tem saldo para o produto.

$sql = "SELECT qtd
        FROM estoque
        WHERE cod_produto = :cod_produto";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    "cod_produto" => $cod_produto
]);

$estoque = $stmt->fetch();

/*--------movimentação de estoque--------*/ 

// Produto sem saldo
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

// Produto possui saldo
} else {
    // Guarda o saldo atual
    $saldoAtual = $estoque["qtd"];

    if ($tipo === "E") {

        $sql = "UPDATE estoque
                SET qtd = qtd + :quantidade
                WHERE cod_produto = :cod_produto";

    } else {
        // saida de estoque
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