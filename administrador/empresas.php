<?php
require 'includes/pdo_connection.php';
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'Administrador') {
    header('Location: ../login.php');
    exit();
}


$query = 'SELECT v.id_vagas, v.descricao, v.remuneracao, u.nome AS empresa_nome, v.titulo, c.nome AS candidato_nome
          FROM vagas v
          LEFT JOIN usuarios u ON v.usuarios_id_empresa_vaga = u.id_usuarios
          LEFT JOIN usuarios_concorre_vaga uc ON v.id_vagas = uc.vagas_id_vagas
          LEFT JOIN usuarios c ON uc.usuarios_id_usuarios = c.id_usuarios';
$stmt = $pdo->prepare($query);
$stmt->execute();
$vagas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração - Empresas</title>
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
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="index.php">Página Inicial</a>
        <a href="empresas.php">Empresas</a>
        <a href="#">Candidatos</a>
    </div>

    <div class="main">
        <div class="header">
            <h1>Vagas das Empresas</h1>
            <button class="btn adicionar">Adicionar Vaga</button>
        </div>

        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Título</th>
                        <th>Remuneração</th>
                        <th>Nome da Empresa</th>
                        <th>Descrição da Vaga</th>
                        <th>Candidato</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vagas as $vaga): ?>
                        <tr>
                            <td><?= htmlspecialchars($vaga['id_vagas']) ?></td>
                            <td><?= htmlspecialchars($vaga['titulo']) ?></td>
                            <td><?= htmlspecialchars($vaga['remuneracao']) ?></td>
                            <td><?= htmlspecialchars($vaga['empresa_nome']) ?></td>
                            <td><?= htmlspecialchars($vaga['descricao']) ?></td>
                            <td><?= htmlspecialchars($vaga['candidato_nome']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
