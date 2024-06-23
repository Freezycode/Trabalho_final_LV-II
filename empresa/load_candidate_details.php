<?php
require 'pdo_connection.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "Por favor, faça login primeiro.";
    exit();
}

if (!isset($_GET['id'])) {
    echo "Candidato não especificado.";
    exit();
}

$candidatoId = $_GET['id'];

if (!isset($pdo_candidato)) {
    die("Erro: A conexão com o banco de dados não foi estabelecida.");
}

try {
    $sql = "SELECT u.nome, u.email, c.conteudo 
            FROM usuarios u 
            LEFT JOIN curriculo c ON u.id_usuarios = c.usuarios_id_usuarios 
            WHERE u.id_usuarios = ?";
    $stmt = $pdo_candidato->prepare($sql);
    $stmt->execute([$candidatoId]);
    $candidato = $stmt->fetch();
    
    if (!$candidato) {
        throw new Exception("Candidato não encontrado!");
    }
} catch (Exception $e) {
    die("Erro: " . $e->getMessage());
}
?>

<div class="candidate-profile">
    <h2>Perfil do Candidato</h2>
    <div class="profile-image">
        <img src="moca portifolio.webp" alt="Foto do Candidato" class="candidate-img">
    </div>
    <div class="candidate-details">
        <h3><?= htmlspecialchars($candidato['nome']); ?></h3>
        <p><strong>E-mail:</strong> <?= htmlspecialchars($candidato['email']); ?></p>
        <p><strong>Descrição:</strong> <?= htmlspecialchars($candidato['conteudo']); ?></p>
    </div>
</div>

<style>
.candidate-profile {
    text-align: center;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.profile-image img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ddd;
    margin-bottom: 20px;
}
.candidate-details h3 {
    font-size: 24px;
    margin-bottom: 10px;
    color: #333;
}
.candidate-details p {
    font-size: 18px;
    margin-bottom: 10px;
    color: #666;
}
</style>
