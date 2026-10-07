<?php

require "conexao.php";


$cod_produto = trim(filter_input(INPUT_GET, "cod_produto")?? "");


if ($cod_produto !== "") {

    $sql = "SELECT 
                cod_produto,
                desc_produto,
                dt_cadastro
            FROM cadastro_produto
            WHERE cod_produto LIKE :cod_produto
            ORDER BY cod_produto";
    
    $stmt = $pdo -> prepare($sql);
    $stmt->execute(["cod_produto" => "%{$cod_produto}%"
]);

}else{

    $sql = "SELECT 
                cod_produto,
                desc_produto,
                dt_cadastro
            FROM cadastro_produto
            ORDER BY cod_produto"; 
    $stmt = $pdo -> query($sql);

}
    $estoque = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Consulta de Produtos</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<main>

    <h1>Produtos</h1>

    <?php if (!$estoque): ?>

        <p>Nenhum produto encontrado.</p>

    <?php else: ?>

        <table border="1">

            <thead>
                <tr>
                    <th>Código</th>
                    <th>Descrição</th>
                    <th>Data</th>
                    <th>Açoes</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($estoque as $produto): ?>

                    <tr>
                        <td><?= htmlspecialchars($produto["cod_produto"]) ?></td>
                        <td><?= htmlspecialchars($produto["desc_produto"]) ?></td>
                        <td><?= htmlspecialchars($produto["dt_cadastro"]) ?></td>

                         <td>
                                <a 
                                    href="editar.php?cod_produto=<?= urlencode ($produto['cod_produto']) ?>">
                                    Editar
                                </a>
                                |
                                <a
                                    href="deletar.php?cod_produto=<?= urlencode($produto['cod_produto']) ?>" onclick="return confirm('Deseja excluir este produto?')">
                                    Excluir
                                </a>
                            </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php endif; ?>

    <p>
        <a href="index.html">Voltar</a>
    </p>

</main>

</body>
</html>