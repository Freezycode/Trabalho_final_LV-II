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

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700;800&family=Poppins:wght@400;500&display=swap"
    rel="stylesheet">

  <link rel="preload" as="image" href="./assets/images/hero-bg.svg">
  <link rel="preload" as="image" href="./assets/images/hero-banner-1.jpg">
  <link rel="preload" as="image" href="./assets/images/hero-banner-2.jpg">
  <link rel="preload" as="image" href="./assets/images/hero-shape-1.svg">
  <link rel="preload" as="image" href="./assets/images/hero-shape-2.png">
</head>

<body id="top">
  <header class="header" data-header>
    <div class="container">
      <a href="#" class="logo">
       
      </a>

      <nav class="navbar" data-navbar>
        <div class="wrapper">
          <a href="#" class="logo">
            <img src="" width="162" height="50" alt="EduWeb logo">
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
            <a href="perfil.empresa/index.php" class="navbar-link" data-nav-link>Perfil</a>
          </li>
          
          <li class="navbar-item">
            <a href="listavagas.php" class="navbar-link" data-nav-link>Candidatos</a>
          </li>

          <li class="navbar-item">
            <a href="trabalhos.php" class="navbar-link" data-nav-link>Trabalhos</a>
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

  <section>
  <div class="card">
            <div class="card-content">
                <h2>SUAS VAGAS</h2>
                <p>Transforme suas habilidades em oportunidades e construa o futuro que você sempre sonhou</p>
                <a href="#" class="how-it-works">
                    <span class="play-icon">▶</span>
                    Toddas as vagas
                </a>
            </div>
            <div class="card-image">
                <img src="img/Learning-pana-removebg-preview.png" alt="Character Image" class="first-card-img">
            </div>
        </div>
  </section>
<section>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <p><strong>Delivery Time</strong></p>
                    <p>1-3 Days</p>
                </div>
                <div>
                    <p><strong>English Level</strong></p>
                    <p>Professional</p>
                </div>
                <div>
                    <p><strong>Location</strong></p>
                    <p>New York</p>
                </div>
            </div>
            <div class="img-gallery">
                <img src="img/trusted-currency-exchange.png" alt="Project Image" class="img-fluid main-img mb-3">
                <div class="d-flex">
                    <img src="img/trusted-currency-exchange-thumb.png" alt="Project Thumbnail" class="img-thumbnail">
                    <img src="img/trusted-currency-exchange-thumb.png" alt="Project Thumbnail" class="img-thumbnail">
                    <img src="img/trusted-currency-exchange-thumb.png" alt="Project Thumbnail" class="img-thumbnail">
                    <img src="img/trusted-currency-exchange-thumb.png" alt="Project Thumbnail" class="img-thumbnail">
                </div>
            </div>
            <div class="mt-4">
                <h4>About</h4>
                <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>
                <h4>Services I provide:</h4>
                <ul>
                    <li>Service 1</li>
                    <li>Service 2</li>
                    <li>Service 3</li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">$50</h5>
                    <p class="card-text">High-converting Landing Pages</p>
                    <p>I will redesign your current landing page or create one for you (up to 4 sections).</p>
                    <ul class="list-unstyled">
                        <li>3 Days Delivery</li>
                        <li>2 Revisions</li>
                        <li>2 Page / Screen</li>
                        <li>Source file</li>
                    </ul>
                    <a href="#" class="btn btn-success">Continue $50</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body text-center">
                    <img src="img/kristin-watson.jpg" alt="Kristin Watson" class="rounded-circle mb-3" width="80">
                    <h5 class="card-title">Kristin Watson</h5>
                    <p class="card-text">Dog Trainer</p>
                    <p><strong>4.9 (595 reviews)</strong></p>
                    <p>Location: London</p>
                    <p>Rate: $90/hr</p>
                    <p>Job Success: 98%</p>
                    <a href="#" class="btn btn-outline-success">Contact Me</a>
                </div>
            </div>
        </div>
    </div>
</div>

</section>





  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
