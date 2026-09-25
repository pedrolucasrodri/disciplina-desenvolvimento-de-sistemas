<?php

$host = "localhost";
$porta = "3306";
$banco = "escola_formulario";
$usuario = "root";
$senha = "";

try {
    $pdo = new PDO (
        "mysql:host=$host;port=$porta;dbname=$banco; charset=utf8mb4",
        $usuario,
        $senha
    );

    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        echo "Método inválido.";
        exit;
    }


    $nome = trim($_POST["nome"] ?? "");
    $endereco = trim($_POST["endereco"] ?? "");
    $cnpj = trim($_POST["cnpj"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");

        if ($nome === "" || $endereco === "" || $cnpj === "" || $telefone === "" ){
        echo "Preencha todos os campos.";
        exit;
    }   

        $sql = "INSERT INTO universidade (nome, endereco, cnpj, telefone)
        VALUES (:nome, :endereco, :cnpj, :telefone)";

        $stmt = $pdo -> prepare("$sql");
        $stmt -> execute([
            "nome" => $nome,
            "endereco" => $endereco, 
            "cnpj" => $cnpj, 
            "telefone"=> $telefone
        ]);

        echo "Universidade cadastradada com sucesso!";

}   catch (PDOException $erro) {
        echo "Erro: " . $erro -> getMessage();
}

?>