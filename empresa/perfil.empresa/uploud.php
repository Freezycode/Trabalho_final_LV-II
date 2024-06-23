<?php
session_start();
require 'pdo_connection.php';

if (!isset($_SESSION['usuario'])) {
    echo "<script>alert('Por favor, faça login primeiro.'); window.location.href = 'login.php';</script>";
    exit;
}

$usuarioId = $_SESSION['usuario']['id_usuarios'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];

    if (isset($_FILES['logotipo']) && $_FILES['logotipo']['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['logotipo']['tmp_name'];
        $filename = basename($_FILES['logotipo']['name']);
        $destination = "../../Cadastro_empresa/" . $filename;

        if (move_uploaded_file($tmp_name, $destination)) {
            $logotipo_empresa = $filename;
            $sql = "UPDATE usuarios SET nome = ?, endereco = ?, telefone = ?, email = ?, logotipo_empresa = ? WHERE id_usuarios = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nome, $endereco, $telefone, $email, $logotipo_empresa, $usuarioId]);
        }
    } elseif (isset($_POST['delete_photo'])) { 
        $sql = "UPDATE usuarios SET logotipo_empresa = NULL WHERE id_usuarios = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$usuarioId]);

   
        // unlink("../../Cadastro_empresa/" . $oldFilename);
    } else {
       
        $sql = "UPDATE usuarios SET nome = ?, endereco = ?, telefone = ?, email = ? WHERE id_usuarios = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nome, $endereco, $telefone, $email, $usuarioId]);
    }

    echo "<script>alert('Perfil atualizado com sucesso!'); window.location.href = 'profile.php';</script>";
} else {
    echo "<script>alert('Método de acesso inválido.');</script>";
}
?>
