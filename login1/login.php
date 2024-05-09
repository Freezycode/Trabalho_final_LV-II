<?php require_once "conexao.php"; 
 if (isset($_POST['acessar'])) {
    login($connect);
}
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="vieport" content="width=device-width, initial-scale=1">
    <title>Formulário de acesso ao site</title>
</head>
<body>
    <form action="" method="post">
        <fieldset>
            <legend>Painel de login</legend>
            <input type="email" name="email" placeholder="Informe seu e-mail">

            <input type="password" name="senha" planceholder="Insira sua senha" required>
            <input type="submit" name="acessar" value="acessar">
        </fieldset>
    </form>
</body>
</html>

//Estilizar esta página