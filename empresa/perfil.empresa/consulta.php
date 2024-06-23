<?php
session_start();


if (!isset($_SESSION['usuario'])) {
    echo "<script>alert('Por favor, faça login primeiro.'); window.location.href = 'login.php';</script>";
    exit();
}

$host = '127.0.0.1';
$dbname = 'talentos';
$user = 'root';
$pass = '';
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

try {
   
    $conn = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

 
    $usuarioId = $_SESSION['usuario']['id_usuarios'];
    $sql = "SELECT u.nome, u.email, u.endereco, u.telefone, v.logotipo_empresa
            FROM usuarios u
            LEFT JOIN vagas v ON u.id_usuarios = v.usuarios_id_empresa_vaga
            WHERE u.id_usuarios = ?
            LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$usuarioId]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$usuario) {
        throw new Exception("Usuário não encontrado!");
    }
} catch (Exception $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>

