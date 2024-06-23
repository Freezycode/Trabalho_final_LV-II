<?php
require 'pdo_connection.php'; 

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM usuarios_concorre_vaga WHERE usuarios_id_usuarios = ?");
        $stmt->execute([$id]);
        echo 'success';
    } catch (PDOException $e) {
        echo 'error: ' . $e->getMessage();
    }
} else {
    echo 'error: missing id';
}
?>
