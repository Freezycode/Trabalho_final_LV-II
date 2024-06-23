<?php
$host = 'localhost';
$dbname = 'talentos';
$user = 'root';
$pass = '';

try {
    include '../src/models/database/database.php';
    include '../src/models/dao/candidatodao.php';
    $conn = Database::getConexao();
    $candidatoDAO = new CandidatoDAO($conn);

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha']; 
    $descricao = $_POST['descricao'];
    $tipo = "CANDIDATO"; 
    $endereco = "";
    $telefone = "";

   
    $usuario_id = $candidatoDAO->create(
        $nome,
        $email,
        $senha,
        $endereco,
        $telefone,
        $tipo 
    );

    $stmt = $conn->prepare("INSERT INTO curriculo (conteudo, usuarios_id_usuarios) VALUES (?, ?)");
    $stmt->execute([$descricao, $usuario_id]);

    echo "<script type='text/javascript'>
        alert('Seu cadastro foi realizado com sucesso!');
        window.location.href = '/talentos08/index.php'; 
    </script>";

} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
} catch (Exception $e) {
    die("Erro: " . $e->getMessage());
}
?>
