<?php
require 'includes/pdo_connection.php'; 
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'Administrador') {
    header('Location: ../login.php');
    exit();
}


$query = 'SELECT id_usuarios, nome, email, tipo FROM usuarios WHERE tipo != "Administrador"';
$stmt = $pdo->prepare($query);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);


$totalUsuariosQuery = 'SELECT COUNT(*) AS total FROM usuarios WHERE tipo != "Administrador"';
$totalStmt = $pdo->prepare($totalUsuariosQuery);
$totalStmt->execute();
$totalUsuarios = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save'])) {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $tipo = $_POST['tipo'] === 'Candidato' ? 'CANDIDATO' : $_POST['tipo']; 

        try {
            $updateQuery = 'UPDATE usuarios SET nome = ?, email = ?, tipo = ? WHERE id_usuarios = ?';
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->execute([$nome, $email, $tipo, $id]);

            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        } catch (PDOException $e) {
            $error = 'Erro ao salvar usuário: ' . $e->getMessage();
        }
    }

    if (isset($_POST['delete'])) {
        $id = $_POST['delete'];

        try {
         
            $checkEmpresaQuery = 'SELECT COUNT(*) AS total FROM vagas WHERE usuarios_id_empresa_vaga = ?';
            $checkEmpresaStmt = $pdo->prepare($checkEmpresaQuery);
            $checkEmpresaStmt->execute([$id]);
            $empresaHasVagas = $checkEmpresaStmt->fetch(PDO::FETCH_ASSOC)['total'];

          
            $checkCandidatoQuery = 'SELECT COUNT(*) AS total FROM usuarios_concorre_vaga WHERE usuarios_id_usuarios = ?';
            $checkCandidatoStmt = $pdo->prepare($checkCandidatoQuery);
            $checkCandidatoStmt->execute([$id]);
            $candidatoInVaga = $checkCandidatoStmt->fetch(PDO::FETCH_ASSOC)['total'];

            if ($empresaHasVagas > 0) {
                $error = 'Esta empresa tem vagas postadas. Por favor, verifique o campo de vagas.';
            } elseif ($candidatoInVaga > 0) {
                $error = 'Há um candidato concorrendo a esta vaga. Por favor, verifique o campo de vagas.';
            } else {
             
                $deleteDependenciesQuery = 'DELETE FROM usuarios_concorre_vaga WHERE usuarios_id_usuarios = ?';
                $deleteDependenciesStmt = $pdo->prepare($deleteDependenciesQuery);
                $deleteDependenciesStmt->execute([$id]);

             
                $deleteQuery = 'DELETE FROM usuarios WHERE id_usuarios = ?';
                $deleteStmt = $pdo->prepare($deleteQuery);
                $deleteStmt->execute([$id]);

                header('Location: ' . $_SERVER['PHP_SELF']);
                exit();
            }
        } catch (PDOException $e) {
            $error = 'Erro ao deletar usuário.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            background-color: #4caf50;
            padding-top: 20px;
        }

        .sidebar a {
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
        }

        .sidebar a:hover {
            background-color: #45a049;
        }

        .main {
            margin-left: 260px; 
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #ccc;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
        }

        .header .btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .header .btn:hover {
            background-color: #218838;
        }

        .table-container {
            margin-top: 20px;
        }

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table .btn {
            padding: 5px 10px;
            font-size: 14px;
            border-radius: 5px;
        }

        .table .btn-blue {
            background-color: #007bff;
            color: white;
        }

        .table .btn-blue:hover {
            background-color: #0056b3;
        }

        .table .btn-edit {
            background-color: #ffc107;
            color: black;
        }

        .table .btn-edit:hover {
            background-color: #e0a800;
        }

        .exportar {
            background-color: #17a2b8;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .exportar:hover {
            background-color: #138496;
        }

        .adicionar {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .adicionar:hover {
            background-color: #218838;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="#">Página Inicial</a>
        <a href="vagas.php">Vagas</a>
    </div>

    <div class="main">
        <div class="header">
            <h1>Usuários</h1>
            <button class="btn" onclick="window.location.href='../index.php'">Voltar</button>
        </div>

        <div class="table-container">
            <p>Total de Usuários: <?= htmlspecialchars($totalUsuarios) ?></p>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Tipo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <form method="post">
                                <td><?= htmlspecialchars($usuario['id_usuarios']) ?></td>
                                <td><input type="text" class="form-control" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>"></td>
                                <td><input type="email" class="form-control" name="email" value="<?= htmlspecialchars($usuario['email']) ?>"></td>
                                <td>
                                    <select class="form-control" name="tipo">
                                        <option value="Candidato" <?= strtoupper($usuario['tipo']) == 'CANDIDATO' ? 'selected' : '' ?>>Candidato</option>
                                        <option value="Empresa" <?= $usuario['tipo'] == 'Empresa' ? 'selected' : '' ?>>Empresa</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id_usuarios']) ?>">
                                    <button type="submit" name="save" class="btn btn-blue">Salvar</button>
                                    <button type="submit" name="delete" value="<?= htmlspecialchars($usuario['id_usuarios']) ?>" class="btn btn-edit">Excluir</button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

   
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="modal-message">Há um candidato concorrendo a esta vaga. Por favor, verifique o campo de vagas.</p>
            <button class="btn btn-blue" id="close-modal">OK</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('modal');
            var closeModal = document.getElementById('close-modal');
            var span = document.getElementsByClassName('close')[0];

            <?php if (!empty($error)): ?>
                document.getElementById('modal-message').innerText = "<?= htmlspecialchars($error) ?>";
                modal.style.display = 'block';
            <?php endif; ?>

            span.onclick = function() {
                modal.style.display = 'none';
            }

            closeModal.onclick = function() {
                modal.style.display = 'none';
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
        });
    </script>
</body>
</html>
