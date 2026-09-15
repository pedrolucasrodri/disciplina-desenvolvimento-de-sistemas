<?php 
    $host = "localhost";
    $banco = "escola";
    $usuario = "root";
    $senha = "";
    try {
        $pdo = new PDO(
        "mysql:host=$host;dbname=$banco;charset=utf8mb4",
        $usuario,
        $senha
        );
        
        $pdo->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
        $alunos = [
            ["id" => 1, "nome" => "Ana", "nota" => 8.5],
            ["id" => 2, "nome" => "Carlos", "nota" => 6.0],
            ["id" => 3, "nome" => "Mariana", "nota" => 9.0]
        ];

        $sql = "INSERT INTO alunos (nome, nota)
            VALUES (:nome, :nota)";
        
        $stmt = $pdo->prepare($sql);
        
        foreach ($alunos as $aluno) {
            $stmt->execute([
                "nome" => $aluno["nome"],
                "nota" => $aluno["nota"]
           ]);
        }
        
        $sql = "SELECT id, nome, nota
                FROM alunos
                ORDER BY id";
        $stmt = $pdo->query($sql);
        $resultado = $stmt->fetchAll(
            PDO::FETCH_ASSOC
        );

        foreach ($resultado as $aluno) {
            $nota = $aluno["nota"];
            
        if ($nota >= 7) {
            $situacao = "Aprovado";
        } elseif ($nota >= 5) {
            $situacao = "Recuperação";
        } else {
            $situacao = "Reprovado";
            }
        echo $aluno["id"] . " - " . $aluno["nome"] . " - " .
            $nota . " - " . $situacao . "\n";
        }
        
    } catch (PDOException $erro) {
        echo "Erro no banco: " .
        $erro->getMessage();
    }

?>    