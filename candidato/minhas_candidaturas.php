<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Minhas Candidaturas</title>
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/css/card.css">
  <link rel="stylesheet" href="./assets/css/card_vagas.css">
  <link rel="stylesheet" href="./assets/css/tela.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700;800&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.0/css/bootstrap.min.css">
  <style>
    .card1 {
      position: relative;
    }
    .em-analise {
      background-color: rgba(255, 255, 0, 0.2); 
    }
    .nao-contemplado {
      background-color: rgba(255, 0, 0, 0.2); 
    }
    .btn-status {
      margin-top: 10px;
    }
    .btn-arredondado {
      border-radius: 20px;
      padding: 5px 10px;
    }
    .btn-verde-agua {
      background-color: #00cc8b;
      color: white;
    }
    .btn-verde-agua:hover {
      background-color: #009973;
    }
    .btn-verde {
      background-color: #33cc33;
      color: white;
    }
    .btn-verde:hover {
      background-color: #28a745;
    }
    .btn-vermelho {
      background-color: #ff3333;
      color: white;
    }
    .btn-vermelho:hover {
      background-color: #cc0000;
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
  ?>

  <?php include 'menu.php'; ?>
  <?php include 'card.php'; ?>

  <section class="container mt-5">
    <div class="row">
      <h2>Minhas Candidaturas</h2>
      <?php
      try {
        
          $stmt = $pdo->prepare("SELECT v.id_vagas, v.descricao, v.requisitos, v.remuneracao, u.nome AS empresa_nome, uc.status_vaga, uc.comunicacao 
                                 FROM usuarios_concorre_vaga uc 
                                 JOIN vagas v ON uc.vagas_id_vagas = v.id_vagas 
                                 JOIN usuarios u ON v.usuarios_id_empresa_vaga = u.id_usuarios 
                                 WHERE uc.usuarios_id_usuarios = ?");
          $stmt->execute([$usuarioId]);
          while ($vaga = $stmt->fetch()) {
              $statusClasse = 'em-analise';
              $statusTexto = 'Em análise';
              $btnTexto = '';
              if ($vaga['status_vaga'] == 'Nao contemplado') {
                  $statusClasse = 'nao-contemplado';
                  $statusTexto = 'Você não foi contemplado';
                  $btnTexto = '<button class="btn btn-vermelho btn-arredondado btn-status remover-card">Poxa que pena!</button>';
              }
      ?>
      <div class="col-md-12">
        <div class="card1 <?= $statusClasse ?>">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h5 class="card-title"><?= htmlspecialchars($vaga['empresa_nome']) ?></h5>
                <p class="card-text"><strong>Descrição:</strong> <?= htmlspecialchars($vaga['descricao']) ?></p>
                <p class="card-requisitos"><strong>Requisitos:</strong> <?= htmlspecialchars($vaga['requisitos']) ?></p>
                <p class="card-status"><strong>Status:</strong> <?= $statusTexto ?></p>
              </div>
              <div class="text-right">
                <p class="text-muted">Remuneração</p>
                <p class="card-remuneracao">R$ <?= number_format($vaga['remuneracao'], 2, ',', '.') ?></p>
                <?= $btnTexto ?>
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
  </section>

  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function() {
        $('.remover-card').click(function() {
            $(this).closest('.card1').remove();
        });
    });
  </script>
</body>
</html>

