<?php
session_start();
require '../pdo_connection.php';

if (!isset($_SESSION['usuario'])) {
    echo "<script>alert('Por favor, faça login primeiro.'); window.location.href = 'login.php';</script>";
    exit();
}

$usuarioId = $_SESSION['usuario']['id_usuarios'];


$dsn = "mysql:host=127.0.0.1;dbname=talentos;charset=utf8";
$user = 'root';
$pass = '';

try {
    $conn = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $conn->beginTransaction();

    
    $stmt = $conn->prepare("DELETE FROM vagas WHERE usuarios_id_empresa_vaga = ?");
    $stmt->execute([$usuarioId]);

    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id_usuarios = ?");
    $stmt->execute([$usuarioId]);

    $conn->commit();

   
    session_destroy();
    echo "<script>alert('Conta excluída com sucesso!'); window.location.href = '../index.php';</script>";
} catch (PDOException $e) {
    $conn->rollBack();
    die("Erro: " . $e->getMessage());
}
?>
