<?php

require "conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST"){
    exit("Método inválido");
}

$cod_produto  = trim($_POST["cod_produto"] ?? "");
$desc_produto = trim($_POST["desc_produto"] ?? "");

if ($cod_produto === "" || $desc_produto === ""){
    exit("Preencha todos os campos.");
}

$sql = "INSERT INTO cadastro_produto
        (
            cod_produto,
            desc_produto
        )
        VALUES
        (
            :cod_produto,
            :desc_produto
        )";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    "cod_produto" => $cod_produto,
    "desc_produto" => $desc_produto
]);

echo "Produto cadastrado com sucesso!";
?>