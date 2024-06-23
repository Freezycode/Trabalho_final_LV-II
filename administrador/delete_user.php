<?php
require 'includes/pdo_connection.php';
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'Administrador') {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {

        $query = 'DELETE FROM usuarios WHERE id_usuarios = ?';
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);

        header('Location: index.php');
        exit();
    } catch (Exception $e) {
        die("Erro: " . $e->getMessage());
    }
}
?>
