<?php
require "conexao.php";

$cod_produto = trim(filter_input(INPUT_GET, "cod_produto") ?? "");

if ($cod_produto === "") {
    exit("Produto não informado.");
}  {
    $sql = "SELECT qtd
            FROM estoque
            WHERE cod_produto = :cod_produto";

        $stmt = $pdo->prepare($sql);

        $stmt -> execute(["cod_produto" => $cod_produto]);

$estoque = $stmt -> fetch(PDO::FETCH_ASSOC);

if($estoque && $estoque["qtd"] > 0) {
    exit("Não é possivel excluir. Exitem {$estoque['qtd']} unidades em estoque.");
        }

    $sql = "DELETE FROM cadastro_produto
        WHERE cod_produto = :cod_produto";

        $stmt = $pdo -> prepare($sql);
        $stmt -> execute(["cod_produto" => $cod_produto]);
}

if ($stmt -> rowCount() > 0) {
    echo("Cadastro excluido com sucesso.");
} else {
    echo("Nenhum cadastro encontrado");
}

?>