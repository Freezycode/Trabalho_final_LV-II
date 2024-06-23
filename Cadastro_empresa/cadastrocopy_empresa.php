<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $host = '127.0.0.1';
    $dbname = 'talentos';
    $user = 'root';
    $pass = '';
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

    try {
        $conn = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

       
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $endereco = $_POST['endereco'];
        $telefone = $_POST['telefone'];

       
        $sql = "INSERT INTO usuarios (nome, email, senha, tipo, endereco, telefone) VALUES (?, ?, ?, 'Empresa', ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nome, $email, $senha, $endereco, $telefone]);
        $empresa_id = $conn->lastInsertId();

        
        if (isset($_FILES['logotipo_empresa']) && $_FILES['logotipo_empresa']['error'] == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['logotipo_empresa']['tmp_name'];
            $logotipo_path = "uploads/logos/" . basename($_FILES['logotipo_empresa']['name']);
            move_uploaded_file($tmp_name, $logotipo_path);
        } else {
            $logotipo_path = null; 
        }

        
        if (!empty($_POST['descricao'])) {
            $descricao = $_POST['descricao'];
            $requisitos = $_POST['requisitos'];
            $remuneracao = $_POST['remuneracao'] ?: 0.00;

           
            $sql_vaga = "INSERT INTO vagas (descricao, requisitos, remuneracao, situacao, logotipo_empresa, quantidade_vagas, usuarios_id_empresa_vaga) VALUES (?, ?, ?, 'Aberta', ?, 1, ?)";
            $stmt_vaga = $conn->prepare($sql_vaga);
            $stmt_vaga->execute([$descricao, $requisitos, $remuneracao, $logotipo_path, $empresa_id]);
        }

       
        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href = '/talentos08/index.php';</script>";
    } catch (PDOException $e) {
        die("Erro de conexão: " . $e->getMessage());
    }
} else {
    
    header('Location: form_cadastro_empresa.html'); 
    exit();
}
?>