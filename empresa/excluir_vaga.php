<?php
session_start();
require 'pdo_connection.php';

if (!isset($_SESSION['usuario'])) {
    echo "<script>alert('Por favor, faça login primeiro.'); window.location.href = 'login.php';</script>";
    exit();
}

$vagaId = isset($_POST['vaga_id']) ? intval($_POST['vaga_id']) : 0;
$usuarioId = $_SESSION['usuario']['id_usuarios'];

try {

    $stmt = $conn->prepare("SELECT id_vagas FROM vagas WHERE id_vagas = ? AND usuarios_id_empresa_vaga = ?");
    $stmt->execute([$vagaId, $usuarioId]);
    $vaga = $stmt->fetch();

    if (!$vaga) {
        echo "<script>alert('Você não tem permissão para excluir esta vaga.'); window.location.href = 'trabalhos.php';</script>";
        exit();
    }

    $stmt = $conn->prepare("DELETE FROM vagas WHERE id_vagas = ? AND usuarios_id_empresa_vaga = ?");
    $stmt->execute([$vagaId, $usuarioId]);

    echo "<script>alert('Vaga excluída com sucesso!'); window.location.href = 'trabalhos.php';</script>";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
