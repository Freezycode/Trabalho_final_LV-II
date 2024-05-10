<?php
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