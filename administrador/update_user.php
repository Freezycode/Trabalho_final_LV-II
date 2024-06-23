<?php
require 'includes/pdo_connection.php'; 
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'Administrador') {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_usuarios'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $tipo = $_POST['tipo'];

    try {
       
        $query = 'UPDATE usuarios SET nome = ?, email = ?, tipo = ? WHERE id_usuarios = ?';
        $stmt = $pdo->prepare($query);
        $stmt->execute([$nome, $email, $tipo, $id]);

        header('Location: index.php');
        exit();
    } catch (Exception $e) {
        die("Erro: " . $e->getMessage());
    }
}
?>
