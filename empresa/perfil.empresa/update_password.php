<?php
require 'pdo_connection.php'; 
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "<script>alert('Por favor, faça login primeiro.'); window.location.href = 'login.php';</script>";
    exit();
}

$usuarioId = $_SESSION['usuario']['id_usuarios'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senhaAtual = $_POST['senha_atual'];
    $novaSenha = $_POST['nova_senha'];

    try {
       
        $sql = "SELECT senha FROM usuarios WHERE id_usuarios = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$usuarioId]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senhaAtual, $usuario['senha'])) {
         
            $novaSenhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
            $updateSql = "UPDATE usuarios SET senha = ? WHERE id_usuarios = ?";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute([$novaSenhaHash, $usuarioId]);

            echo "<script>alert('Senha alterada com sucesso!'); window.location.href = '../index.php';</script>";
        } else {
            echo "<script>alert('Senha atual incorreta!'); window.location.href = 'index.php';</script>";
        }
    } catch (PDOException $e) {
        die("Erro ao atualizar a senha: " . $e->getMessage());
    }
} else {
    echo "<script>alert('Acesso inválido.'); window.location.href = 'index.php';</script>";
}
?>
