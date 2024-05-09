<?php session_start();?>
<!DOCTYPE html>
<html><head>
    <meta charset="utf-8">
    <meta name="vieport" content="width=device-width, initial-scale=1">
    <title>Painel admin</title>
</head>
<body>
    <?php if (isset($_session['ativa'])) {?>

    <h1> Painel administrativo do site</h1>
    <h3>Bem vindo, <?php echo $_session['nome']; ?></h3>

    <?php } else{
        header("location: login.php"); 
    } ?>
</body>
</html>