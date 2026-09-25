<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Cadastro</title>
</head>
<body>

    <form action="processa.php" method="POST">

        <input
            type="text"
            name="nome"
            placeholder="Digite seu nome"
            required
        >

        <input
            type="email"
            name="email"
            placeholder="Digite seu e-mail"
            required
        >

        <button type="submit">
            Enviar
        </button>

    </form>

</body>
</html>