<?php
<<<<<<< HEAD
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$database = "talentos";

$conn = new mysqli($servername, $username, $password, $database);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtém os dados do formulário
$username = $_POST['username'];
$password = $_POST['password'];

// Consulta SQL para verificar se o usuário existe
$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Usuário autenticado com sucesso
    echo "<script>alert('Login realizado com sucesso!');</script>";
    echo "<script>window.location.href = 'index.html';</script>";
    exit; // Certifique-se de sair do script após o redirecionamento
} else {
    // Falha na autenticação
    echo "Usuário ou senha inválidos.";
}

$conn->close();
?>
=======
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['password'];

    $dsn = 'mysql:host=127.0.0.1;dbname=talentos;charset=utf8';
    $conn = new PDO($dsn, 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $query = 'SELECT * FROM usuarios WHERE email = :email;';
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    $isSenhaValida = $senha == $usuario['senha'];
    
    if ($usuario && $isSenhaValida) {
        $_SESSION['usuario'] = [
            'id_usuarios' => $usuario['id_usuarios'],
            'nome' => $usuario['nome'],
            'tipo' => $usuario['tipo'],
        ];

        if ($usuario['tipo'] === 'CANDIDATO') {
            header('Location: candidato/index.php');
        } else if ($usuario['tipo'] === 'Empresa') {
            header('Location: empresa/index.php');
        } else if ($usuario['tipo'] === 'Administrador') {
            header('Location: administrador/index.php');
        } else {
            header('Location: index.php'); 
        }
        exit();
    } else {
        header('Location: logar.php?message=Usuário ou senha inválidos.');
        exit();
    }
}
?>
>>>>>>> 831621a (atualizando o projeto final)
