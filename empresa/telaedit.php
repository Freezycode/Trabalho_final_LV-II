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

  if (!isset($_SESSION['usuario'])) {
      echo "<script>alert('Por favor, faça login primeiro.'); window.location.href = 'login.php';</script>";
      exit();
  }

  $usuarioId = $_SESSION['usuario']['id_usuarios'];
  $nomeUsuario = $_SESSION['usuario']['nome'];

  $vagaId = isset($_GET['vaga_id']) ? intval($_GET['vaga_id']) : 0;

  $sql = "SELECT u.nome AS nome_usuario, u.email, v.descricao, v.requisitos, v.remuneracao, v.quantidade_vagas, v.logotipo_empresa 
          FROM usuarios u 
          JOIN vagas v ON u.id_usuarios = v.usuarios_id_empresa_vaga 
          WHERE u.id_usuarios = ? AND v.id_vagas = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$usuarioId, $vagaId]);
  $vaga = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$vaga) {
      echo "<script>alert('Você não tem permissão para visualizar esta vaga.'); window.location.href = 'index.php';</script>";
      exit();
  }

  // Verificar se há candidatos inscritos nesta vaga
  $candidatosStmt = $conn->prepare("SELECT COUNT(*) FROM usuarios_concorre_vaga WHERE vagas_id_vagas = ?");
  $candidatosStmt->execute([$vagaId]);
  $candidatosCount = $candidatosStmt->fetchColumn();


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
              
            </div>
            <div class="job-info">
              <h2>Descrição sobre a vaga</h2>
              <div class="job-meta">
                
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
              <button class="btn btn-success" onclick="showDeleteModal(<?= $candidatosCount; ?>)">Excluir Vaga</button>
            </div>
            <div class="job-sidebar-item">
              <div class="job-profile">
            
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


  <div id="deleteModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="hideDeleteModal()">&times;</span>
      <h2>Tem certeza que deseja excluir esta vaga?</h2>
      <form action="excluir_vaga.php" method="post">
        <input type="hidden" name="vaga_id" value="<?= $vagaId; ?>">
        <button type="submit" class="btn btn-danger">Sim, excluir </button>
        <button type="button" class="btn btn-default" onclick="hideDeleteModal()">Não, cancelar</button>
      </form>
    </div>
  </div>

 
  <div id="alertModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="hideAlertModal()">&times;</span>
      <h2>Não é possível excluir a vaga</h2>
      <p>Há candidatos inscritos nesta vaga. Você não pode excluir uma vaga com candidatos inscritos.</p>
      <button type="button" class="btn btn-default" onclick="hideAlertModal()">Fechar</button>
    </div>
  </div>

  <style>
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

    .btn {
      margin: 10px;
    }
  </style>

  <script>
    function showDeleteModal(candidatosCount) {
      if (candidatosCount > 0) {
        document.getElementById("alertModal").style.display = "block";
      } else {
        document.getElementById("deleteModal").style.display = "block";
      }
    }

    function hideDeleteModal() {
      document.getElementById("deleteModal").style.display = "none";
    }

    function hideAlertModal() {
      document.getElementById("alertModal").style.display = "none";
    }
  </script>

  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
