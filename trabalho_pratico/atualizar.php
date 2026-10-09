<?php
require "conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST"){
    exit("Método Inválido");
}

$cod_produto = trim(filter_input(INPUT_POST, "cod_produto")?? "");

if (strlen($cod_produto) > 10) {
    exit("O código do produto deve possuir no máximo 10 caracteres.");
}

$desc_produto = trim(filter_input(INPUT_POST, "desc_produto")??"");
$cod_original = trim($_POST["cod_original"] ?? "");

if (strlen($desc_produto) > 101) {
    exit("O código do produto deve possuir no máximo 10 caracteres.");
}


if ($cod_produto === "" || $desc_produto === "") {
    exit("Preencha todos os campos.");
}

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
    exit("Já existe um produto cadastrado com este código ou descrição.");
}

$sql =" UPDATE cadastro_produto
        SET cod_produto = :cod_produto, desc_produto = :desc_produto    
        WHERE cod_produto = :cod_original";

$stmt = $pdo -> prepare($sql);

try {
        $stmt->execute([
        "cod_produto"  => $cod_produto,
        "desc_produto" => $desc_produto,
        "cod_original" => $cod_original
    ]);

    // verifica quantidade de registros alterados.
    if ($stmt -> rowCount() > 0) {
        echo("Produto atualizado com sucesso!");
    }
    else{
        echo("Nenhum registro foi alterado. Verifique os dados informados");
    }
} catch (PDOException $e) {
    exit("Erro ao atualizar cadastro.");
}

?>