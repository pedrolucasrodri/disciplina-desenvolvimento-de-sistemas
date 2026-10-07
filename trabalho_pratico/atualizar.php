<?php
require "conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST"){
    exit("Método Inválido");
}

$cod_produto = trim(filter_input(INPUT_POST, "cod_produto")?? "");
$desc_produto = trim(filter_input(INPUT_POST, "desc_produto")??"");
$cod_original = trim($_POST["cod_original"] ?? "");

if ($cod_produto === "" || $desc_produto === "") {
    exit("Preencha todos os campos.");
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