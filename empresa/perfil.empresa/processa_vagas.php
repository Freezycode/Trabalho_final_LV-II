<?php
session_start();


if (!isset($_SESSION['usuario'])) {
    echo "<script>alert('Por favor, faça login primeiro.'); window.location.href = 'login.php';</script>";
    exit;
}


require 'pdo_connection.php';  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
    $descricao = $_POST['descricao'];
    $requisitos = $_POST['requisitos'];
    $quantidade_vagas = $_POST['quantidade_vagas'];
    $remuneracao = str_replace(['R$', '.', ','], ['', '', '.'], $_POST['remuneracao']); // Converte o formato R$ 1.234,56 para 1234.56

   
    $usuarioId = $_SESSION['usuario']['id_usuarios'];

    try {
        $sql = "INSERT INTO vagas (descricao, requisitos, remuneracao, quantidade_vagas, usuarios_id_empresa_vaga) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$descricao, $requisitos, $remuneracao, $quantidade_vagas, $usuarioId]);

        echo "<script>alert('Vaga cadastrada com sucesso!'); window.location.href = 'profile.php';</script>";
    } catch (PDOException $e) {
        die("Erro ao cadastrar a vaga: " . $e->getMessage());
    }
} else {
    echo "<script>alert('Acesso inválido.'); window.location.href = 'index.php';</script>";
}
?>
