<?php
require 'includes/pdo_connection.php'; 
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'Administrador') {
    header('Location: ../login.php');
    exit();
}


$query = 'SELECT v.id_vagas, v.titulo, v.descricao, v.remuneracao, v.quantidade_vagas, u.id_usuarios AS candidato_id, u.nome AS candidato
          FROM vagas v
          LEFT JOIN usuarios_concorre_vaga uv ON v.id_vagas = uv.vagas_id_vagas
          LEFT JOIN usuarios u ON uv.usuarios_id_usuarios = u.id_usuarios';
$stmt = $pdo->prepare($query);
$stmt->execute();
$vagas = $stmt->fetchAll(PDO::FETCH_ASSOC);


$totalVagasQuery = 'SELECT COUNT(*) AS total FROM vagas';
$totalStmt = $pdo->prepare($totalVagasQuery);
$totalStmt->execute();
$totalVagas = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $vagaId = $_POST['delete'];

        try {
           
            $deleteDependenciesQuery = 'DELETE FROM usuarios_concorre_vaga WHERE vagas_id_vagas = ?';
            $deleteDependenciesStmt = $pdo->prepare($deleteDependenciesQuery);
            $deleteDependenciesStmt->execute([$vagaId]);

           
            $deleteQuery = 'DELETE FROM vagas WHERE id_vagas = ?';
            $deleteStmt = $pdo->prepare($deleteQuery);
            $deleteStmt->execute([$vagaId]);

            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        } catch (PDOException $e) {
            $error = 'Erro ao deletar vaga: ' . $e->getMessage();
        }
    }

    if (isset($_POST['delete_candidate'])) {
        $candidatoId = $_POST['delete_candidate'];
        $vagaId = $_POST['vaga_id'];

        try {
           
            $deleteCandidateQuery = 'DELETE FROM usuarios_concorre_vaga WHERE usuarios_id_usuarios = ? AND vagas_id_vagas = ?';
            $deleteCandidateStmt = $pdo->prepare($deleteCandidateQuery);
            $deleteCandidateStmt->execute([$candidatoId, $vagaId]);

            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        } catch (PDOException $e) {
            $error = 'Erro ao deletar candidato da vaga: ' . $e->getMessage();
        }
    }

    if (isset($_POST['save'])) {
        $vagaId = $_POST['vaga_id'];
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $remuneracao = $_POST['remuneracao'];
        $quantidade_vagas = $_POST['quantidade_vagas'];

        try {
            $updateQuery = 'UPDATE vagas SET titulo = ?, descricao = ?, remuneracao = ?, quantidade_vagas = ? WHERE id_vagas = ?';
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->execute([$titulo, $descricao, $remuneracao, $quantidade_vagas, $vagaId]);

            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        } catch (PDOException $e) {
            $error = 'Erro ao atualizar vaga: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração de Vagas</title>
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
            margin-right: 5px;
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

        .btn-red {
            background-color: red;
            color: white;
        }

        .btn-red:hover {
            background-color: darkred;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 5px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="index.php">Página Inicial</a>
      
        <a href="vagas.php">Vagas</a>
     
    </div>

    <div class="main">
        <div class="header">
            <h1>Vagas</h1>
           
        </div>

        <div class="table-container">
            <p>Total de Vagas: <?= htmlspecialchars($totalVagas) ?></p>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Remuneração</th>
                        <th>Quantidade de Vagas</th>
                        <th>Candidato</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vagas as $vaga): ?>
                        <tr>
                            <td><?= htmlspecialchars($vaga['id_vagas']) ?></td>
                            <form method="post">
                                <td><input type="text" class="form-control" name="titulo" value="<?= htmlspecialchars($vaga['titulo']) ?>"></td>
                                <td><input type="text" class="form-control" name="descricao" value="<?= htmlspecialchars($vaga['descricao']) ?>"></td>
                                <td><input type="text" class="form-control" name="remuneracao" value="<?= htmlspecialchars($vaga['remuneracao']) ?>"></td>
                                <td><input type="text" class="form-control" name="quantidade_vagas" value="<?= htmlspecialchars($vaga['quantidade_vagas']) ?>"></td>
                                <td>
                                    <?= htmlspecialchars($vaga['candidato']) ?>
                                </td>
                                <td class="action-buttons">
                                    <input type="hidden" name="vaga_id" value="<?= htmlspecialchars($vaga['id_vagas']) ?>">
                                    <button type="submit" name="save" class="btn btn-blue">Salvar</button>
                                    <button type="submit" name="delete" value="<?= htmlspecialchars($vaga['id_vagas']) ?>" class="btn btn-edit">Excluir</button>
                                    <?php if ($vaga['candidato_id']): ?>
                                        <form method="post" style="display:inline;">
                                            <input type="hidden" name="delete_candidate" value="<?= htmlspecialchars($vaga['candidato_id']) ?>">
                                            <input type="hidden" name="vaga_id" value="<?= htmlspecialchars($vaga['id_vagas']) ?>">
                                            <button type="submit" class="btn btn-red">Candidato</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
