<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $dsn = 'mysql:host=127.0.0.1;dbname=freelancer_db;charset=utf8;';
    $conn = new PDO($dsn, 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    try {
        $query = 'INSERT INTO clientes (nome, email, senha) VALUES (:nome, :email, :senha)';
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':senha', $senha, PDO::PARAM_STR);
        $stmt->execute();
        
        header('Location: confirmacao_cadastro.php');
        exit();
    } catch (PDOException $e) {
        echo "Erro na conexão: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <main>
        <h1>Cadastro de Cliente</h1>

        <hr>

        <form action="" method="post">
            <ul>
                <li>
                    <h2>Nome</h2>
                    <input type="text" name="nome" placeholder="Informe o nome" required autofocus>
                </li>

                <li>
                    <h2>Email</h2>
                    <input type="email" name="email" placeholder="Informe o email" required>
                </li>

                <li>
                    <h2>Senha</h2>
                    <input type="password" name="senha" placeholder="Informe a senha" required>
                </li>
            </ul>

            <br>
            <button type="submit" class="btn">Cadastrar</button>
        </form>
    </main>
</body>

</html>
