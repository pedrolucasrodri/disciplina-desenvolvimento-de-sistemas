<?php

require "conexao.php";  

$cod_produto = trim(
    filter_input(INPUT_GET, "cod_produto") ?? ""
);

if ($cod_produto === "") {
    exit("Produto não informado.");
}

// Consulta saldo em estoque 

$sql = "SELECT qtd
        FROM estoque
        WHERE cod_produto = :cod_produto";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    "cod_produto" => $cod_produto
]);

$estoque = $stmt->fetch(PDO::FETCH_ASSOC);

// Não permite excluir se existir saldo 

if ($estoque && $estoque["qtd"] > 0) {

    exit(
        "Não é possível excluir. Existem {$estoque['qtd']} unidades em estoque."
    );
}

// Consulta histórico de movimentações

$sql = "SELECT COUNT(*)
        FROM movimentacao
        WHERE cod_produto = :cod_produto";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    "cod_produto" => $cod_produto
]);

$movimentacoes = $stmt->fetchColumn();

// Não permite excluir se houver movimentações 

if ($movimentacoes > 0) {

    exit(
        "Não é possível excluir. Produto possui movimentações registradas."
    );
}

// Exclui produto 

$sql = "DELETE
        FROM cadastro_produto
        WHERE cod_produto = :cod_produto";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    "cod_produto" => $cod_produto
]);

if ($stmt->rowCount() > 0) {

    echo "Cadastro excluído com sucesso.";

} else {

    echo "Nenhum cadastro encontrado.";

}