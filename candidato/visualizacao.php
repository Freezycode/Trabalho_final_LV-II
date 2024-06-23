<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Talentos - Visualização de Vaga</title>
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/css/card.css">
  <link rel="stylesheet" href="./assets/css/card_vagas.css">
  <link rel="stylesheet" href="./assets/css/tela.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700;800&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f7fa;
    }

    .card1 {
      margin-bottom: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s, box-shadow 0.3s;
      background: #f9f9f9;
      border: 2px solid #20c997;
      position: relative;
      overflow: hidden;
    }

    .card1:hover {
      transform: translateY(-10px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .card1::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle, rgba(32, 201, 151, 0.2) 0%, rgba(32, 201, 151, 0) 60%);
      transition: opacity 0.3s, transform 0.3s;
      opacity: 0;
      pointer-events: none;
    }

    .card1:hover::before {
      opacity: 1;
      transform: scale(1.2);
    }

    .card1 .card-title {
      font-size: 1.5rem;
      font-weight: 700;
      color: #28a745;
      display: flex;
      align-items: center;
    }

    .card1 .card-title i {
      margin-right: 10px;
      color: #20c997;
    }

    .card1 .card-text, .card1 .card-requisitos, .card1 .card-remuneracao, .card1 .card-email {
      font-size: 1.2rem;
      margin: 5px 0;
    }

    .card1 .card-text strong, .card1 .card-requisitos strong, .card1 .card-email strong {
      color: #28a745;
    }

    .card1 .card-remuneracao {
      font-size: 1.5rem;
      color: #20c997;
    }

    .btn-success {
      background-color: #28a745;
      border: none;
      font-size: 1rem;
      padding: 10px 20px;
      border-radius: 5px;
      transition: background-color 0.3s, transform 0.3s;
    }

    .btn-success:hover {
      background-color: #218838;
      transform: scale(1.05);
    }

    .btn-secondary {
      background-color: #6c757d;
      border: none;
      font-size: 1rem;
      padding: 10px 20px;
      border-radius: 5px;
      transition: background-color 0.3s, transform 0.3s;
    }

    .btn-secondary:hover {
      background-color: #5a6268;
      transform: scale(1.05);
    }

    .action-buttons {
      display: flex;
      gap: 10px;
      margin-top: 20px;
    }
  </style>
</head>

<body id="top">
  <?php
  session_start();
  require 'pdo_connection.php'; // Ajuste o caminho conforme necessário

  // Verifica se o usuário está logado
  if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario']['id_usuarios'])) {
      echo "<script>alert('Por favor, faça login primeiro.'); window.location.href = 'login.php';</script>";
      exit();
  }

  // Verificar se o ID da vaga foi passado
  if (!isset($_GET['vaga_id'])) {
      echo "<script>alert('Vaga não especificada.'); window.location.href = 'vagas.php';</script>";
      exit();
  }

  $vagaId = $_GET['vaga_id'];
  $usuarioId = $_SESSION['usuario']['id_usuarios'];

  $vaga = null;
  $jaCandidatado = false;

  try {
      // Buscar detalhes da vaga
      $stmt = $pdo->prepare("SELECT v.descricao, v.requisitos, v.remuneracao, u.nome AS empresa_nome, v.logotipo_empresa, u.email
                             FROM vagas v 
                             JOIN usuarios u ON v.usuarios_id_empresa_vaga = u.id_usuarios 
                             WHERE v.id_vagas = ?");
      $stmt->execute([$vagaId]);
      $vaga = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($vaga) {
          // Verificar se o candidato já se candidatou à vaga
          $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios_concorre_vaga WHERE usuarios_id_usuarios = ? AND vagas_id_vagas = ?");
          $checkStmt->execute([$usuarioId, $vagaId]);
          $jaCandidatado = $checkStmt->fetchColumn() > 0;

          // Candidatar-se à vaga
          if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$jaCandidatado) {
              $insertStmt = $pdo->prepare("INSERT INTO usuarios_concorre_vaga (usuarios_id_usuarios, vagas_id_vagas) VALUES (?, ?)");
              $insertStmt->execute([$usuarioId, $vagaId]);
              echo "<script>alert('Candidatura realizada com sucesso!'); window.location.href = 'vagas.php';</script>";
          }
      } else {
          echo "<script>alert('Vaga não encontrada.'); window.location.href = 'vagas.php';</script>";
          exit();
      }
  } catch (PDOException $e) {
      echo "Erro: " . $e->getMessage();
  }

  //$imagePath = '../Cadastro_empresa/' . (isset($vaga['logotipo_empresa']) ? htmlspecialchars($vaga['logotipo_empresa']) : 'default-logo.png');
  //?>

  <?php include 'menu.php'; ?>
  <?php include 'card.php'; ?>

  <header class="header" data-header>
    <div class="container">
      <a href="#" class="logo">
        <img src="../img/logo tipo.PNG" width="90" height="50" alt="">
      </a>

      <nav class="navbar" data-navbar>
        <div class="wrapper">
          <a href="#" class="logo">
      <!-- <img src="" width="162" height="50" alt="EduWeb logo"> -->
          </a>

          <button class="nav-close-btn" aria-label="close menu" data-nav-toggler>
            <ion-icon name="close-outline" aria-hidden="true"></ion-icon>
          </button>
        </div>

        <ul class="navbar-list">
          <li class="navbar-item">
            <a href="index.php" class="navbar-link" data-nav-link>Inicio</a>
          </li>
          <li class="navbar-item">
            <a href="minhas_candidaturas.php" class="navbar-link" data-nav-link>Minhas Vagas</a>
          </li>
          <li class="navbar-item">
            <a href="trabalhos.php" class="navbar-link" data-nav-link>Vagas</a>
          </li>
          <li class="navbar-item">
            <a href="concorrentes.php" class="navbar-link" data-nav-link>Concorrentes</a>
          </li>
          <li class="navbar-item">
            <a href="perfil.php" class="navbar-link" data-nav-link>Perfil</a>
          </li>
        </ul>
      </nav>

      <div class="header-actions">
        <a href="../index.php" class="btn has-before">
          <span class="span">Sair</span>
        </a>
        <button class="header-action-btn" aria-label="open menu" data-nav-toggler>
          <ion-icon name="menu-outline" aria-hidden="true"></ion-icon>
        </button>
      </div>

      <div class="overlay" data-nav-toggler data-overlay></div>
    </div>
  </header>

  <section class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card1">
          <div class="card-body">
            <?php if ($vaga): ?>
              <h5 class="card-title"><i class="fas fa-building"></i> <?= htmlspecialchars($vaga['empresa_nome']) ?></h5>
              <!--<img src="<?= $imagePath; ?>" alt="Logo da empresa" class="img-fluid mb-3"> -->
          <p class="card-text"><strong>Descrição:</strong> <?= htmlspecialchars($vaga['descricao']) ?></p> 
              <p class="card-requisitos"><strong>Requisitos:</strong> <?= htmlspecialchars($vaga['requisitos']) ?></p>
              <p class="card-remuneracao"><strong>Remuneração:</strong> R$ <?= number_format($vaga['remuneracao'], 2, ',', '.') ?></p>
              <p class="card-email"><strong>Email para contato:</strong> <?= htmlspecialchars($vaga['email']) ?></p>
              <?php if ($jaCandidatado): ?>
                <p class="text-success">Você já se candidatou a esta vaga.</p>
              <?php else: ?>
                <form method="post" class="action-buttons">
                  <button type="submit" class="btn btn-success">Candidatar</button>
                  <a href="vagas.php" class="btn btn-secondary">Cancelar</a>
                </form>
              <?php endif; ?>
            <?php else: ?>
              <p class="text-danger">Detalhes da vaga não disponíveis.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
