<?php
require 'pdo_connection_status.php';

if (isset($_POST['id']) && isset($_POST['status']) && isset($_POST['vaga']) && isset($_POST['comunicacao'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $vaga = $_POST['vaga'];
    $comunicacao = $_POST['comunicacao'];

    try {
        $stmt = $pdo_status->prepare("UPDATE usuarios_concorre_vaga SET status_vaga = ?, comunicacao = ? WHERE usuarios_id_usuarios = ? AND vagas_id_vagas = ?");
        $stmt->execute([$status, $comunicacao, $id, $vaga]);
        echo 'success';
    } catch (PDOException $e) {
        echo 'error: ' . $e->getMessage();
    }
} else {
    echo 'error: missing parameters';
}
?>
