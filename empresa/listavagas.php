<?php

require 'pdo_connection_vagas.php';
require 'pdo_connection.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "<script>alert('Por favor, faça login primeiro.'); window.location.href = 'login.php';</script>";
    exit();
}


if (!isset($pdo_vagas)) {
    die("Erro: A conexão com o banco de dados não foi estabelecida.");
}

$usuarioId = $_SESSION['usuario']['id_usuarios'];


try {
    $sql = "SELECT id_vagas, titulo FROM vagas WHERE usuarios_id_empresa_vaga = ?";
    $stmt = $pdo_vagas->prepare($sql);
    $stmt->execute([$usuarioId]);
    $vagas = $stmt->fetchAll();
} catch (Exception $e) {
    die("Erro: " . $e->getMessage());
}
?>

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
  <link rel="stylesheet" href="./assets/css/listadevagas.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700;800&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
  <link rel="preload" as="image" href="./assets/images/hero-bg.svg">
  <link rel="preload" as="image" href="./assets/images/hero-banner-1.jpg">
  <link rel="preload" as="image" href="./assets/images/hero-banner-2.jpg">
  <link rel="preload" as="image" href="./assets/images/hero-shape-1.svg">
  <link rel="preload" as="image" href="./assets/images/hero-shape-2.png">

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
    }

    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      max-width: 600px;
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

    .candidate-profile {
        text-align: center;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .profile-image img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ddd;
        margin-bottom: 20px;
    }
    .candidate-details h3 {
        font-size: 24px;
        margin-bottom: 10px;
        color: #333;
    }
    .candidate-details p {
        font-size: 18px;
        margin-bottom: 10px;
        color: #666;
    }
  </style>
</head>
<body>
  <?php include 'menu.php'; ?>

  <div id="search-results" style="display: none;">
      Nenhum dado encontrado
  </div>
  <nav class="topnav">
      <div class="logo">
          <a href="#" class="display-sm display-md" id="menu"><i class="fa fa-list-ul"></i></a>
          <a href="index.html" class="hidden-sm"><h1></h1></a>
      </div>
      <div class="user-menu">
          <form action="#" method="post" class="hidden-sm">
          </form>
          <div>
              <a href="#"><i class="fa fa-user"></i> </a>
          </div>
      </div>
  </nav>
 
  <aside class="sidenav hidden-sm hidden-md" id="nav">
     <div class="list">
         <?php foreach ($vagas as $vaga): ?>
             <a href="#" class="vaga-titulo" data-id="<?= $vaga['id_vagas'] ?>"><?= htmlspecialchars($vaga['titulo']) ?></a>
         <?php endforeach; ?>
     </div>
  </aside>

  <main class="content">
      <div class="grid">
          <div class="mini-reports bg-blue">
              <div class="l">
                  <span id="num-candidatos">0</span>
                  <span>Candidatos</span>
              </div>
              <div class="r">
                  <i class="fa fa-book c-blue"></i>
              </div>
          </div>
          <div class="mini-reports bg-green">
              <div class="l">
                  <span id="num-vagas">0</span>
                  <span>Quantidade de vagas</span>
              </div>
              <div class="r">
                  <i class="fa fa-home c-green"></i>
              </div>
          </div>
      </div>

      <div class="grid">
          <div class="painel">
              <div class="painel-header">
                  <h4 class="painel-title">Tabela dos candidatos</h4>
              </div>
              <div class="painel-body">
                  <table class="zebra" id="tabela-candidatos">
                      <tr>
                          <th>Nome</th>
                          <th>Email</th>
                         
                      </tr>
                  </table>
              </div>
          </div>
      </div>
  </main>


  <div id="candidateModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <div id="candidate-details">
        <div class="candidate-profile">
          <h2>Enviar Convite</h2>
          <p>Envie um email ao candidato informando o local e horário para comparecer com o currículo.</p>
          <button onclick="fecharModal()">OK</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
        $('.vaga-titulo').click(function() {
            var vagaId = $(this).data('id');
            
            $.ajax({
                url: 'load_candidates.php',
                method: 'GET',
                data: { id: vagaId },
                success: function(response) {
                    var data = JSON.parse(response);
                    var candidatos = data.candidatos;
                    var numCandidatos = candidatos.length;
                    var numVagas = data.numVagas;
                    
                    $('#num-candidatos').text(numCandidatos);
                    $('#num-vagas').text(numVagas);
                    
                    var tabelaCandidatos = $('#tabela-candidatos');
                    tabelaCandidatos.find('tr:gt(0)').remove();
                    
                    if (numCandidatos === 0) {
                        tabelaCandidatos.append('<tr><td colspan="2">Nenhum candidato encontrado.</td></tr>');
                    } else {
                        $.each(candidatos, function(index, candidato) {
                            tabelaCandidatos.append('<tr class="candidato" data-id="' + candidato.id_usuarios + '"><td>' + candidato.nome + '</td><td>' + candidato.email + '</td></tr>');
                        });
                    }

                    $('.candidato').click(function() {
                        $('#candidateModal').css('display', 'block');
                    });

                    $('.delete-candidato').click(function() {
                        var candidatoId = $(this).data('id');
                        var vagaId = $(this).data('vaga');
                        var comunicacao = $(this).data('comunicacao');
                        var row = $(this).closest('tr');

                        $.ajax({
                            url: 'delete_candidate.php',
                            method: 'POST',
                            data: { id: candidatoId },
                            success: function(response) {
                                if (response === 'success') {
                                    row.remove();
                                    $('#num-candidatos').text(parseInt($('#num-candidatos').text()) - 1);

                                    $.ajax({
                                        url: 'update_candidate_status.php',
                                        method: 'POST',
                                        data: { id: candidatoId, status: 'Nao contemplado', vaga: vagaId, comunicacao: comunicacao },
                                        success: function(response) {
                                            if (response === 'success') {
                                                alert('Status atualizado para "Você não foi contemplado".');
                                            } else {
                                                console.error('Erro na atualização do status:', response);
                                                alert('Erro ao atualizar status.');
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Erro na chamada AJAX para atualização do status:', error);
                                            alert('Erro na chamada AJAX para atualização do status.');
                                        }
                                    });
                                } else {
                                    console.error('Erro ao deletar candidato:', response);
                                    alert('Erro ao deletar candidato.');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Erro na chamada AJAX para deletar candidato:', error);
                                alert('Erro na chamada AJAX para deletar candidato.');
                            }
                        });
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Erro na chamada AJAX para carregar candidatos:', error);
                    alert('Erro na chamada AJAX para carregar candidatos.');
                }
            });
        });

        $('.close').click(function() {
            $('#candidateModal').css('display', 'none');
        });

        $(window).click(function(event) {
            if (event.target.id === 'candidateModal') {
                $('#candidateModal').css('display', 'none');
            }
        });
    });

    function fecharModal() {
        $('#candidateModal').css('display', 'none');
    }
  </script>
</body>
</html>
