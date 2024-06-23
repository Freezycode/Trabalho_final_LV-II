<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = '127.0.0.1';
    $dbname = 'talentos';
    $user = 'root';
    $pass = '';
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

    try {
        $conn = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha']; // Senha sem criptografia conforme solicitado
        $endereco = $_POST['endereco'];
        $telefone = $_POST['telefone'];

        // Inserir os dados na tabela de usuários, incluindo o nome da empresa
        $sql = "INSERT INTO usuarios (nome, email, senha, endereco, telefone, tipo) VALUES (?, ?, ?, ?, ?, 'Empresa')";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nome, $email, $senha, $endereco, $telefone]);

        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href = '/talentos08/index.php';</script>";
    } catch (PDOException $e) {
        die("Erro de conexão: " . $e->getMessage());
    }
} else {
    header('Location: form_cadastro_empresa.html');
    exit();
}
?>
