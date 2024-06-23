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
  ?>

  <header class="header" data-header>
    <div class="container">
      <a href="#" class="logo">
        
      </a>

      <nav class="navbar" data-navbar>
        <div class="wrapper">
          <a href="#" class="logo">
          
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
            <a href="visualizacao_vagas.php" class="navbar-link" data-nav-link>Minhas Vagas</a>
          </li>
          
          <li class="navbar-item">
            <a href="trabalhos.php" class="navbar-link" data-nav-link>vagas</a>
          </li>
          <li class="navbar-item">
            <a href="listavagas.php" class="navbar-link" data-nav-link>Candidatos</a>
          </li>

          

          <li class="navbar-item">
            <a href="perfil.empresa/index.php" class="navbar-link" data-nav-link>Editar Perfil e Nova Vaga</a>
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

  <main>
    <article>
      <section class="section hero has-bg-image" id="home" aria-label="home"
        style="background-image: url('img/fundo-verde-suave-com-alta-qualidade.jpg')">
        <div class="container">
          <div class="hero-content">
            <h1 class="h1 section-title">
              Bem vindo <span class="span"><?= htmlspecialchars($nomeUsuario) ?></span> Vamos começar
            </h1>
            <p class="hero-text">
              Tenha as melhores experiências aqui!
            </p>
          </div>

          <figure class="hero-banner">
            <div class="img-holder one" style="--width: 270; --height: 300;">
              <img src="img/wendyyes-928x1232-7703244 (1).png" width="270" height="300" alt="hero banner" class="img-cover">
            </div>
            <div class="img-holder two" style="--width: 240; --height: 370;">
              <img src="img/rajesh-1770x1332-7529998.png" width="240" height="370" alt="hero banner" class="img-cover">
            </div>
            <img src="./assets/images/hero-shape-2.png" width="622" height="551" alt="" class="shape hero-shape-2">
          </figure>
        </div>
      </section>

      <section class="section category" aria-label="category">
        <div class="container">
          <p class="section-subtitle">Sobre as vagas</p>
          <h2 class="h2 section-title">
            Divulgue <span class="span">Novas</span> Vagas de emprego
          </h2>
          <p class="section-text">
            Como funciona as vagas para a empresa          </p>
          <ul class="grid-list">
            <li>
             
            </li>
            <li>
              <div class="category-card" style="--color: 351, 83%, 61%">
                <div class="card-icon">
                  <img src="./assets/images/category-2.svg" width="40" height="40" loading="lazy"
                    alt="Non-Degree Programs" class="img">
                </div>
                <h3 class="h3">
                  <a href="#" class="card-title">Basca apenas da um clique</a>
                </h3>
                <p class="card-text">
                  Edite seu perfil
                </p>
                <span class="card-badge">Edite seu perfil atualize e cadastre uma nova vaga</span>
              </div>
            </li>
            <li>
              <div class="category-card" style="--color: 229, 75%, 58%">
                <div class="card-icon">
                  <img src="./assets/images/category-3.svg" width="40" height="40" loading="lazy"
                    alt="Off-Campus Programs" class="img">
                </div>
                <h3 class="h3">
                  <a href="#" class="card-title">Cadastre vagas</a>
                </h3>
                <p class="card-text">
                  Poste novas vagas e veja seus candidatos concorrentes aquela vaga.
                </p>
                <span class="card-badge">Talentos foi feito para você</span>
              </div>
            </li>
            <li>
            
            </li>
          </ul>
        </div>
      </section>
    </article>
  </main>

  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>









      

      





     

  <script src="./assets/js/script.js" defer></script>


  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>