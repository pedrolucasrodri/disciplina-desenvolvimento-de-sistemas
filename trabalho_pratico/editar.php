<?php
require "conexao.php";

$cod_produto = trim($_GET["cod_produto"] ?? "");

if (strlen($cod_produto) > 10) {
    exit("O código do produto deve possuir no máximo 10 caracteres.");
}

if ($cod_produto == "") {
    exit("Produto não informado");
}

$sql = "SELECT 
            cod_produto,
            desc_produto    
        FROM cadastro_produto
        WHERE cod_produto = :cod_produto";

$stmt = $pdo->prepare($sql);

$stmt -> execute([
    "cod_produto" => $cod_produto
]);

$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    exit("Produto não cadastrado");
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Editar Produto</title>
    </head>

    <body>
        <main>
            <form action="atualizar.php" method="POST">
                <h1>Editar Produto</h1>

                <input type="hidden" name="cod_original" value="<?=htmlspecialchars($produto['cod_produto'])?>">
                <label>Código do Produto</label>

                <input type="text" name="cod_produto" value="<?=htmlspecialchars($produto['cod_produto'])?>"required>

                <br><br>

                <label>Descrição do Produto</label>
                <input type="text" name="desc_produto" value="<?=htmlspecialchars($produto['desc_produto'])?>" required>
                
                <br><br>

                <button type="submit">Salvar Alterações</button>
            </form>
            
            <p>
                <a href="consultar_produtos.php">Voltar</a>
            </p>


        </main>
        
    </body>
</html>