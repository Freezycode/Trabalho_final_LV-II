<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dsn = 'mysql:host=127.0.0.1;dbname=freelancer_db;charset=utf8;';
    $conn = new PDO($dsn, 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $query = 'INSERT INTO clientes (nome, email, username, senha, informacoes_empresa) VALUES (:nome, :email, :username, :senha, :informacoes_empresa)';
    $stmt = $conn->prepare($query);

    $stmt->bindValue(':nome', $_POST['nome'], PDO::PARAM_STR);
    $stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $stmt->bindValue(':username', $_POST['username'], PDO::PARAM_STR);
    $stmt->bindValue(':senha', $_POST['senha'], PDO::PARAM_STR);
    $stmt->bindValue(':informacoes_empresa', $_POST['informacoes_empresa'], PDO::PARAM_STR);

    if ($stmt->execute()) {
        header('Location: cadastro_sucesso.php');
        exit();
    } else {
        echo "Erro ao cadastrar cliente.";
    }
}
?>
