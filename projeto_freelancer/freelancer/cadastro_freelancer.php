<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $dsn = 'mysql:host=127.0.0.1;dbname=seu_banco_de_dados;charset=utf8;';
    $conn = new PDO($dsn, 'seu_usuario', 'sua_senha', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    
    $query = 'INSERT INTO freelancers (nome, email, username, senha, habilidades, experiencia, portfolio, informacoes_pagamento) 
              VALUES (:nome, :email, :username, :senha, :habilidades, :experiencia, :portfolio, :informacoes_pagamento)';
    $stmt = $conn->prepare($query);

    
    $stmt->bindValue(':nome', $_POST['nome'], PDO::PARAM_STR);
    $stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $stmt->bindValue(':username', $_POST['username'], PDO::PARAM_STR);
    $stmt->bindValue(':senha', $_POST['senha'], PDO::PARAM_STR);
    $stmt->bindValue(':habilidades', $_POST['habilidades'], PDO::PARAM_STR);
    $stmt->bindValue(':experiencia', $_POST['experiencia'], PDO::PARAM_STR);
    $stmt->bindValue(':portfolio', $_POST['portfolio'], PDO::PARAM_STR);
    $stmt->bindValue(':informacoes_pagamento', $_POST['informacoes_pagamento'], PDO::PARAM_STR);

 
    if ($stmt->execute()) {
        header('Location: cadastro_sucesso.php');
        exit();
    } else {
        echo "Erro ao cadastrar freelancer.";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sucesso no Cadastro</title>
    <link rel="stylesheet" href="assets/CSS/cadfre.css">
</head>

<body>
    <main>
        <h1>Cadastro realizado com sucesso!</h1>
        <p>Obrigado por se cadastrar como freelancer. Agora você pode fazer login e começar a usar nosso site.</p>
        <a href="login.php" class="btn">Fazer Login</a>
    </main>
</body>

</html>
