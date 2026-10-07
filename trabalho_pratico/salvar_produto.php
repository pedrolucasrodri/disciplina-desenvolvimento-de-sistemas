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

try{
    
    $stmt->execute([
        "cod_produto" => $cod_produto,
        "desc_produto" => $desc_produto
    ]);
    echo "Produto cadastrado com sucesso!";
    }catch (PDOException $e){
        if ($e->getCode() == "23000"){
            echo "Cadastro de produto exixtente, tente novamente por favor.";
    } else{
        echo "Erro ao cadastrar produto.";
    }
}
?>