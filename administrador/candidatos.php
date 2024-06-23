<?php
require 'includes/pdo_connection.php'; 
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'Administrador') {
    header('Location: ../login.php');
    exit();
}


$query = 'SELECT id_usuarios, nome, email, endereco, telefone, status FROM usuarios WHERE tipo = "Candidato"';
$stmt = $pdo->prepare($query);
$stmt->execute();
$candidatos = $stmt->fetchAll(PDO::FETCH_ASSOC);


$totalCandidatosQuery = 'SELECT COUNT(*) AS total FROM usuarios WHERE tipo = "Candidato"';
$totalStmt = $pdo->prepare($totalCandidatosQuery);
$totalStmt->execute();
$totalCandidatos = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração - Candidatos</title>
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
        <a href="candidatos.php">Candidatos</a>
    </div>

    <div class="main">
        <div class="header">
            <h1>Candidatos</h1>
            <button class="btn adicionar">Adicionar Candidato</button>
        </div>

        <div class="table-container">
            <p>Total de Candidatos: <?= htmlspecialchars($totalCandidatos) ?></p>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Endereço</th>
                        <th>Telefone</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($candidatos as $candidato): ?>
                        <tr>
                            <td><?= htmlspecialchars($candidato['id_usuarios']) ?></td>
                            <td><?= htmlspecialchars($candidato['nome']) ?></td>
                            <td><?= htmlspecialchars($candidato['email']) ?></td>
                            <td><?= htmlspecialchars($candidato['endereco']) ?></td>
                            <td><?= htmlspecialchars($candidato['telefone']) ?></td>
                            <td><?= htmlspecialchars($candidato['status']) ? 'Ativo' : 'Inativo' ?></td>
                            <td>
                                <button class="btn btn-blue">Editar</button>
                                <button class="btn btn-edit">Excluir</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
