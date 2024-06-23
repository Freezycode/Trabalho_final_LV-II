<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Talentos</title>
  <meta name="title" content="">
  <meta name="" content="">


  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/css/card.css">
  <link rel="stylesheet" href="./assets/css/card_vagas.css">
  <link rel="stylesheet" href="./assets/css/tela.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700;800&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
  <link rel="preload" as="image" href="./assets/images/hero-bg.svg">
  <link rel="preload" as="image" href="./assets/images/hero-banner-1.jpg">
  <link rel="preload" as="image" href="./assets/images/hero-banner-2.jpg">
  <link rel="preload" as="image" href="./assets/images/hero-shape-1.svg">
  <link rel="preload" as="image" href="./assets/images/hero-shape-2.png">
</head>
<body id="top">
  <?php
  session_start();
  require 'pdo_connection.php';

  // Verifica se o usuário está logado
  if (!isset($_SESSION['usuario'])) {
      echo "<script>alert('Por favor, faça login primeiro.'); window.location.href = 'login.php';</script>";
      exit();
  }

  $usuarioId = $_SESSION['usuario']['id_usuarios'];
  $nomeUsuario = $_SESSION['usuario']['nome'];

  $sql = "SELECT u.nome AS nome_usuario, u.email, v.descricao, v.requisitos, v.remuneracao, v.quantidade_vagas, v.logotipo_empresa 
          FROM usuarios u 
          JOIN vagas v ON u.id_usuarios = v.usuarios_id_empresa_vaga 
          WHERE u.id_usuarios = ? 
          ORDER BY v.id_vagas DESC 
          LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$usuarioId]);
  $vaga = $stmt->fetch(PDO::FETCH_ASSOC);

  $imagePath = '../../Cadastro_empresa/' . htmlspecialchars($vaga['logotipo_empresa']);
  ?>

  <?php include 'menu.php'; ?>
  <?php include 'card.php'; ?>

  <section class="job-details-section">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="job-details-main">
            <div class="job-banner">
              <img src="<?= $imagePath; ?>" alt="Trusted currency exchange" class="img-fluid">
            </div>
            <div class="job-info">
              <h2>Descrição sobre a vaga</h2>
              <div class="job-meta">
                <span class="job-meta-item"><ion-icon name="time-outline"></ion-icon> </span>
                <span class="job-meta-item"><ion-icon name="bar-chart-outline"></ion-icon> </span>
                <span class="job-meta-item"><ion-icon name="location-outline"></ion-icon> </span>
              </div>
              <p class="job-description">
                Descrição detalhada sobre a vaga:
              </p>
              <p class="job-description">
                <?= htmlspecialchars($vaga['descricao']); ?>
              </p>
            </div>
          
          </div>
        </div>
        <div class="col-lg-4">
          <div class="job-sidebar">
            <div class="job-sidebar-item">
              <h3>R$<?= number_format($vaga['remuneracao'], 2, ',', '.'); ?></h3>
              <p>Remuneração</p>
              <p>Vagas</p>
              <ul class="job-sidebar-info">
                <li><ion-icon name="checkmark-circle-outline"></ion-icon>Vagas: <?= htmlspecialchars($vaga['quantidade_vagas']); ?></li>
               
              </ul>
              <a href="#" class="btn btn-success">Excluir Vaga</a>
            </div>
            <div class="job-sidebar-item">
              <div class="job-profile">
                <img src="<?= $imagePath; ?>" alt="Logo da empresa" class="img-fluid">
                <h4><?= htmlspecialchars($nomeUsuario); ?></h4>
                <p>Empresa</p>
                <ul class="job-profile-info">
                  <li><ion-icon name="location-outline"></ion-icon> Brasil</li>
                  
                  <li><ion-icon name="checkmark-circle-outline"></ion-icon>Empresa confiável</li>
                  <li><ion-icon name="checkmark-circle-outline"></ion-icon>Email para contato: <?= htmlspecialchars($vaga['email']); ?></li>
                 
                </ul>
                <a href="perfil.empresa/index.php" class="btn btn-primary">Editar perfil</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
