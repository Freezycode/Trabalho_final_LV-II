<?php
require 'pdo_connection.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "<script>alert('Por favor, faça login primeiro.'); window.location.href = 'login.php';</script>";
    exit();
}

$usuarioId = $_SESSION['usuario']['id_usuarios'];

try {
    $sql = "SELECT u.nome, u.email, c.conteudo 
            FROM usuarios u 
            LEFT JOIN curriculo c ON u.id_usuarios = c.usuarios_id_usuarios 
            WHERE u.id_usuarios = ?";
    $stmt = $pdo->prepare($sql); 
    $stmt->execute([$usuarioId]);
    $usuario = $stmt->fetch();
    
    if (!$usuario) {
        throw new Exception("Usuário não encontrado!");
    }
} catch (Exception $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>

  
    <link rel="stylesheet" href="./assets/css/portifolio.css">
    <link rel="stylesheet" href="responsive.css">

    
    <link rel="stylesheet" href="fonts/remixicon.css">
    <style>
        .btn {
            display: inline-block;
            padding: 5px 10px;
            font-size: 14px;
            font-weight: 500;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin: 10px 0;
            text-decoration: none;
        }

        .btn-voltar {
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1000;
        }

        .btn-voltar:hover {
            background-color: #45a049;
        }

        .btn-curriculo {
            background-color: #00ccad;
            color: white;
            text-decoration: none;
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 500;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin: 10px 0;
        }

        .btn-curriculo:hover {
            background-color: #00b89a;
        }

        .btn-escolher-arquivo {
            background-color: #007bff;
            color: white;
            text-decoration: none;
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 500;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin: 10px 0;
        }

        .btn-escolher-arquivo:hover {
            background-color: #0056b3;
        }

        .success-message {
            margin: 20px 0;
            padding: 15px;
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
            border-radius: 4px;
        }

        .profile {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile img {
            width: 150px;
            height: 150px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid #ddd;
        }

        .pdf-preview {
            width: 100%;
            height: 400px;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
  
    <span class="main_bg"></span>

   
    <div class="container">
       
        <a href="index.php" class="btn btn-voltar">Voltar</a>

     
        <header>
            <div class="brandLogo">
                <span>Freelancer</span>
            </div>
        </header>

     
        <section class="userProfile card">
            <div class="profile">
                <figure>
                    <img src="user.png" alt="Sua foto">
                </figure>
            </div>
        </section>

      
        <section class="work_skills card">
       
            <div class="skills">
                <h1 class="heading">Seu esforço gera</h1>
                <ul>
                    <li style="--i:0">criatividade</li>
                    <li style="--i:1">crescimento</li>
                    <li style="--i:2">sucesso</li>
                </ul>
            </div>
        </section>

      
        <section class="userDetails card">
            <div class="userName">
                <h1 class="name"><?= htmlspecialchars($usuario['nome']); ?></h1>
                <div class="map">
                    <i class="ri-map-pin-fill ri"></i>
                    <span></span>
                </div>
                <p>Talento</p>
                <div class="btns">
                    <button class="btn btn-escolher-arquivo">Escolher Arquivo</button>
                    <button class="btn btn-curriculo">Olhar Currículo</button>
                </div>
            </div>
        </section>

        <section class="timeline_about card">
            <div class="tabs">
                <ul>
                    <li class="about active">
                        <i class="ri-user-3-fill ri"></i>
                        <span>Sobre</span>
                    </li>
                </ul>
            </div>

            <div class="contact_Info">
                <h1 class="heading">Informação para contato</h1>
                <ul>
                    <li class="email">
                        <h1 class="label">E-mail:</h1>
                        <span class="info"><?= htmlspecialchars($usuario['email']); ?></span>
                    </li>
                </ul>
            </div>

            <div class="basic_info">
                <h1 class="heading">Sobre mim:</h1>
                <ul>
                    <li class="birthday">
                        <h1 class="label">Descrição: <?= htmlspecialchars($usuario['conteudo']); ?></h1>
                    </li>
                </ul>
            </div>

            <div class="pdf-preview">
                <img src="curriculo.png" alt="Currículo" style="width:100%; height:100%; object-fit:cover;">
            </div>
        </section>
    </div>
</body>
</html>

