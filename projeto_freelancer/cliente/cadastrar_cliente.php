<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    try {
        $dsn = 'mysql:host=127.0.0.1;dbname=freelancer_db;charset=utf8;';
        $usuario = 'root';
        $senha_banco = '';

        $conexao = new PDO($dsn, $usuario, $senha_banco);
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "INSERT INTO clientes (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);

        $stmt->execute();

        header("Location: cadastro_sucesso.php");
        exit;
    } catch (PDOException $erro) {
        echo "Erro na conexão: " . $erro->getMessage();
    }
} else {
    header("Location: index.php");
    exit;
}
?>
