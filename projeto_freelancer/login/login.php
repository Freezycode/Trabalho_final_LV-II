<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os campos de login foram preenchidos
    if (isset($_POST['email']) && isset($_POST['senha'])) {
        // Conexão com o banco de dados
        $dsn = 'mysql:host=127.0.0.1;dbname=freelancer_db;charset=utf8;';
        $usuario = 'root';
        $senha_banco ='';

        try {
            $conexao = new PDO($dsn, $usuario, $senha_banco);
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consulta SQL para verificar se o usuário existe
            $query = "SELECT * FROM usuarios WHERE email = :email";
            $stmt = $conexao->prepare($query);
            $stmt->bindParam(':email', $_POST['email']);
            $stmt->execute();
            // Fim Consulta SQL para verificar se o usuário existe 


            // Verifica se o usuário foi encontrado
            if ($stmt->rowCount() > 0) {
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                // Verifica se a senha está correta
                if (password_verify($_POST['senha'], $usuario['senha'])) {
                    // Autenticação bem-sucedida, redireciona para a página apropriada
                    if ($usuario['tipo'] === 'cliente') {
                        header("Location: pagina_do_cliente.php");
                    } elseif ($usuario['tipo'] === 'freelancer') {
                        header("Location: pagina_do_freelancer.php");
                    }
                    exit;
                } else {
                    $erro = "Senha incorreta";
                }
            } else {
                $erro = "Usuário não encontrado";
            }
        } catch (PDOException $erro) {
            $erro = "Erro na conexão: " . $erro->getMessage();
        }
    } else {
        $erro = "Por favor, preencha todos os campos";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h2>Login</h2>
    <?php if (isset($erro)) echo "<p>$erro</p>"; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        <br>
        <button type="submit">Entrar</button>
    </form>
</body>

</html>
