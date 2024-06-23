<?php
session_start();
require 'pdo_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuarioId = $_SESSION['usuario']['id_usuarios'];

  
    $dsn = "mysql:host=127.0.0.1;dbname=talentos;charset=utf8";
    $conn = new PDO($dsn, 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    if (isset($_POST['delete_photo'])) {
      
        $sql = "UPDATE usuarios SET logotipo_empresa = NULL WHERE id_usuarios = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$usuarioId]);
        if (!empty($_POST['current_image'])) {
            unlink('../../Cadastro_empresa/' . $_POST['current_image']); 
        }
        echo "<script>alert('Foto deletada com sucesso!'); window.location.href = 'index.php';</script>";
    } else {
        if ($_FILES['logotipo']['error'] == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['logotipo']['tmp_name'];
            $filename = basename($_FILES['logotipo']['name']);
            $destination = "../../Cadastro_empresa/" . $filename;
            if (move_uploaded_file($tmp_name, $destination)) {
                $logotipo_empresa = $filename;
                $sql = "UPDATE usuarios SET logotipo_empresa = ? WHERE id_usuarios = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$logotipo_empresa, $usuarioId]);
                echo "<script>alert('Foto atualizada com sucesso!'); window.location.href = 'index.php';</script>";
            }
        }
    }
} else {
    echo "<script>alert('Acesso inválido'); window.location.href = 'login.php';</script>";
}
?>
