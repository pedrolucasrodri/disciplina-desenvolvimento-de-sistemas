<?php

require_once "conexao.php";

$nome = $_POST['nome'];
$email = $_POST['email'];

$sql = "INSERT INTO usuarios (nome, email)
        VALUES (:nome, :email)";

$stmt = $conexao->prepare($sql);

$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':email', $email);

$stmt->execute();

echo "Usuário cadastrado com sucesso!";