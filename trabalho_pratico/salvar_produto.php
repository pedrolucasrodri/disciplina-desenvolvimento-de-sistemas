<?php

require "conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST"){
    exit("Método inválido");
}

$cod_produto  = trim($_POST["cod_produto"] ?? "");

if (strlen($cod_produto) > 10) {
    exit("O código do produto deve possuir no máximo 10 caracteres.");
}

$desc_produto = trim($_POST["desc_produto"] ?? "");

if (strlen($desc_produto) > 101) {
    exit("O código do produto deve possuir no máximo 10 caracteres.");
}


if ($cod_produto === "" || $desc_produto === ""){
    exit("Preencha todos os campos.");
}

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
    exit("Já existe um produto cadastrado com este código ou descrição.");
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

try{
    
    $stmt->execute([
        "cod_produto" => $cod_produto,
        "desc_produto" => $desc_produto
    ]);
    echo "Produto cadastrado com sucesso!";
    // Tratamento de erro, código duplicado 23000 - violação de integridade ---------> add para descrição 
    }catch (PDOException $e){
        if ($e->getCode() == "23000"){
            echo "Cadastro de produto exixtente, tente novamente por favor.";
    } else{
        echo "Erro ao cadastrar produto.";
    }
}
?>