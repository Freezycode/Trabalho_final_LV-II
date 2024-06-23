<?php
require 'pdo_connection.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "<script>alert('Por favor, faça login primeiro.'); window.location.href = 'login.php';</script>";
    exit();
}

$usuarioId = $_SESSION['usuario']['id_usuarios'];

try {
    $sql = "SELECT u.nome, u.email, c.conteudo AS descricao, c.foto 
            FROM usuarios u 
            LEFT JOIN curriculo c ON u.id_usuarios = c.usuarios_id_usuarios 
            WHERE u.id_usuarios = ? 
            AND u.tipo = 'Candidato' 
            LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$usuarioId]);
    $usuario = $stmt->fetch();

    if (!$usuario) {
        throw new Exception("Usuário não encontrado ou não é um candidato!");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $descricao = $_POST['descricao'];
        $foto = $_FILES['foto']['name'];

        $updateSql = "UPDATE usuarios u JOIN curriculo c ON u.id_usuarios = c.usuarios_id_usuarios SET u.nome = ?, u.email = ?, c.conteudo = ? WHERE u.id_usuarios = ?";
        $stmt = $pdo->prepare($updateSql);
        $stmt->execute([$nome, $email, $descricao, $usuarioId]);

        if ($foto) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($foto);
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                $updateFotoSql = "UPDATE curriculo SET foto = ? WHERE usuarios_id_usuarios = ?";
                $stmt = $pdo->prepare($updateFotoSql);
                $stmt->execute([$target_file, $usuarioId]);
                $usuario['foto'] = $target_file; 
            }
        }

        
        echo "<script>alert('Perfil atualizado com sucesso!'); window.location.href = 'perfil_candidato.php';</script>";
    }
} catch (Exception $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Candidato</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f7fa;
            margin-top: 20px;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        .form-control, .btn {
            border-radius: 8px;
        }
        .btn-file {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
        }
        .btn-file:hover {
            background-color: #0056b3;
        }
        #profile-img {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            object-fit: cover;
            margin-right: 10px;
        }
        .image-preview {
            width: 100px;
            height: 100px;
            border: 1px solid #ddd;
            display: inline-block;
            border-radius: 10px;
            object-fit: cover;
        }
    </style>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('profile-img');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</head>
<body>
    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">Perfil do Candidato</h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="account-general">
                            <div class="card-body">
                                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Foto</label>
                                        <div class="d-flex align-items-center">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Nome</label>
                                        <input type="text" class="form-control" name="nome" value="<?= htmlspecialchars($usuario['nome']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($usuario['email']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Descrição</label>
                                        <textarea class="form-control" name="descricao"><?= htmlspecialchars($usuario['descricao']); ?></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                    <a href="index.php" class="btn btn-secondary">Voltar</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
