<?php
$host = '127.0.0.1';
$dbname = 'talentos';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

session_start();

if (!isset($_SESSION['usuario'])) {
    echo "<script>alert('Por favor, faça login primeiro.'); window.location.href = 'login.php';</script>";
    exit();
}

$usuarioId = $_SESSION['usuario']['id_usuarios'];

try {
  
    $sql = "SELECT u.nome, u.email, v.descricao, v.remuneracao 
            FROM usuarios u
            JOIN usuarios_concorre_vaga uv ON u.id_usuarios = uv.usuarios_id_usuarios
            JOIN vagas v ON uv.vagas_id_vagas = v.id_vagas
            WHERE u.tipo = 'Candidato' AND v.usuarios_id_empresa_vaga = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$usuarioId]);
    $candidatos = $stmt->fetchAll();
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

  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/css/card.css">
  <link rel="stylesheet" href="./assets/css/card_vagas.css">
  <link rel="stylesheet" href="./assets/css/tela.css">
  <link rel="stylesheet" href="./assets/css/concorrentes.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700;800&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
  <link rel="preload" as="image" href="./assets/images/hero-bg.svg">
  <link rel="preload" as="image" href="./assets/images/hero-banner-1.jpg">
  <link rel="preload" as="image" href="./assets/images/hero-banner-2.jpg">
  <link rel="preload" as="image" href="./assets/images/hero-shape-1.svg">
  <link rel="preload" as="image" href="./assets/images/hero-shape-2.png">
</head>
<body>
<?php include 'menu.php'; ?>

<section class="new-section">
    <div class="container">
        <section class="hero">
            <div class="hero-content">
                <h1>Olhe todos que se candidataram a vaga</h1>
                <p>Se candidataram a vaga</p>
            </div>
        </section>

        <section class="tables">
            <div class="history-table">
                <div class="table-header">
                    <h3>Candidatos</h3>
                    <a href="#"></a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Descrição da Vaga</th>
                            <th>Remuneração</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (!empty($candidatos)) {
                            $counter = 1;
                            foreach ($candidatos as $candidato) {
                                echo "<tr>
                                    <td>{$counter}</td>
                                    <td>{$candidato['nome']}</td>
                                    <td>{$candidato['email']}</td>
                                    <td>{$candidato['descricao']}</td>
                                    <td>R$ " . number_format($candidato['remuneracao'], 2, ',', '.') . "</td>
                                </tr>";
                                $counter++;
                            }
                        } else {
                            echo "<tr><td colspan='5'>Nenhum candidato encontrado.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</section>

<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
