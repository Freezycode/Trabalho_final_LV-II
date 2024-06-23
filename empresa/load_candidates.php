<?php
require 'pdo_connection_vagas.php';

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'ID da vaga não fornecido.']);
    exit();
}

$vagaId = $_GET['id'];

try {
    $sql = "SELECT u.nome, u.email FROM usuarios u
            INNER JOIN usuarios_concorre_vaga uv ON u.id_usuarios = uv.usuarios_id_usuarios
            WHERE uv.vagas_id_vagas = ?";
    $stmt = $pdo_vagas->prepare($sql); 
    $stmt->execute([$vagaId]);
    $candidatos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT quantidade_vagas FROM vagas WHERE id_vagas = ?";
    $stmt = $pdo_vagas->prepare($sql);
    $stmt->execute([$vagaId]);
    $numVagas = $stmt->fetchColumn();

    echo json_encode(['candidatos' => $candidatos, 'numVagas' => $numVagas]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>

