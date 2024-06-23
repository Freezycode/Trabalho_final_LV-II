<?php
session_start();
require 'pdo_connection.php'; 
require 'pdo_connection_foto.php'; 


if (!isset($_SESSION['usuario'])) {
    echo "<script>alert('Por favor, faça login primeiro.'); window.location.href = 'login.php';</script>";
    exit();
}

$usuarioId = $_SESSION['usuario']['id_usuarios'];
$finalDir = '../../Cadastro_empresa/'; 


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'] ?? null;
    $endereco = $_POST['endereco'] ?? null;
    $telefone = $_POST['telefone'] ?? null;
    $email = $_POST['email'] ?? null;

 
    $sql = "UPDATE usuarios SET nome = ?, endereco = ?, telefone = ?, email = ? WHERE id_usuarios = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $endereco, $telefone, $email, $usuarioId]);


    if (!empty($_FILES['logotipo']['name'])) {
        $finalFile = $finalDir . basename($_FILES['logotipo']['name']);
        $imageFileType = strtolower(pathinfo($finalFile, PATHINFO_EXTENSION));

   
        $check = getimagesize($_FILES['logotipo']['tmp_name']);
        if ($check !== false) {
         
            if (move_uploaded_file($_FILES['logotipo']['tmp_name'], $finalFile)) {
                $sql = "UPDATE vagas SET logotipo_empresa = ? WHERE usuarios_id_empresa_vaga = ?";
                $stmt = $pdo_foto->prepare($sql);
                $stmt->execute([basename($_FILES['logotipo']['name']), $usuarioId]);
                $_SESSION['logotipo_empresa'] = basename($_FILES['logotipo']['name']);
            } else {
                echo "<script>alert('Desculpe, ocorreu um erro ao fazer upload da sua imagem.');</script>";
            }
        } else {
            echo "<script>alert('O arquivo não é uma imagem.');</script>";
        }
    }

    if (isset($_POST['delete_photo'])) {
        $sql = "UPDATE vagas SET logotipo_empresa = NULL WHERE usuarios_id_empresa_vaga = ?";
        $stmt = $pdo_foto->prepare($sql);
        $stmt->execute([$usuarioId]);
        $_SESSION['logotipo_empresa'] = null; 
    }

    echo "<script>alert('Perfil atualizado com sucesso!'); window.location.href = 'index.php';</script>";
}
?>
