<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Talentos</title>
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

    .card1.candidated {
      background-color: #e0f7fa;
    }

    .card1 .status-message {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: #ffcc00;
      color: #333;
      padding: 5px 10px;
      border-radius: 5px;
      font-weight: bold;
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

    .card1 .card-text, .card1 .card-requisitos, .card1 .card-remuneracao, .card1 .text-muted {
      font-size: 1.2rem;
      margin: 5px 0;
    }

    .card1 .card-text strong, .card1 .card-requisitos strong, .card1 .text-muted {
      color: #28a745;
    }

    .card1 .card-remuneracao {
      font-size: 1.5rem;
      color: #20c997;
    }

    .card1 .btn-success {
      background-color: #28a745;
      border: none;
      font-size: 1rem;
      padding: 10px 20px;
      border-radius: 5px;
      transition: background-color 0.3s, transform 0.3s;
    }

    .card1 .btn-success:hover {
      background-color: #218838;
      transform: scale(1.05);
    }

    .section-title {
      font-size: 2.5rem; 
      font-weight: 700;
      color: #28a745;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .section-title i {
      margin-right: 10px;
      color: #20c997;
    }

    .highlight-section {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-bottom: 40px;
    }
  </style>
</head>
<body id="top">
  <?php
  session_start();
  require 'pdo_connection.php';


  if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario']['id_usuarios'])) {
      echo "<script>alert('Por favor, faça login primeiro.'); window.location.href = 'login.php';</script>";
      exit();
  }

  $usuarioId = $_SESSION['usuario']['id_usuarios'];

 
  $stmt = $pdo->prepare("SELECT vagas_id_vagas FROM usuarios_concorre_vaga WHERE usuarios_id_usuarios = ?");
  $stmt->execute([$usuarioId]);
  $candidaturas = $stmt->fetchAll(PDO::FETCH_COLUMN);
  ?>

  <?php include 'menu.php'; ?>
  <?php include 'card.php'; ?>

  <section class="container mt-5">
    <div class="row">
      <div class="col-12">
       
      </div>
      <div class="col-12 highlight-section">
        <h3 class="section-title"><i class="fas fa-clipboard-list"></i> Todas as vagas disponíveis</h3>
        <div class="row">
          <?php
          try {
            
              $stmt = $pdo->query("SELECT id_vagas, descricao, requisitos, remuneracao, usuarios_id_empresa_vaga FROM vagas");
              while ($vaga = $stmt->fetch()) {
                 
                  $empresaStmt = $pdo->prepare("SELECT nome FROM usuarios WHERE id_usuarios = ?");
                  $empresaStmt->execute([$vaga['usuarios_id_empresa_vaga']]);
                  $empresa = $empresaStmt->fetch();

                  $isCandidated = in_array($vaga['id_vagas'], $candidaturas);
          ?>
          <div class="col-md-12">
            <div class="card1 <?= $isCandidated ? 'candidated' : '' ?>">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                  <div>
                    <h5 class="card-title"><i class="fas fa-building"></i> <?= htmlspecialchars($empresa['nome']) ?></h5>
                    <p class="card-text"><strong>Descrição:</strong> <?= htmlspecialchars($vaga['descricao']) ?></p>
                    <p class="card-requisitos"><strong>Requisitos:</strong> <?= htmlspecialchars($vaga['requisitos']) ?></p>
                  </div>
                  <div class="text-right">
                    <p class="text-muted"><strong>Remuneração</strong></p>
                    <p class="card-remuneracao">R$ <?= number_format($vaga['remuneracao'], 2, ',', '.') ?></p>
                    <?php if ($isCandidated): ?>
                      <div class="status-message">Você já se candidatou</div>
                    <?php else: ?>
                      <a href="visualizacao.php?vaga_id=<?= $vaga['id_vagas'] ?>" class="btn btn-success">Se Candidatar</a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
              }
          } catch (PDOException $e) {
              echo "Erro: " . $e->getMessage();
          }
          ?>
        </div>
      </div>
    </div>
  </section>

  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
