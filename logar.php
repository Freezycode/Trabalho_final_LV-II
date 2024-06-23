<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/CSS/login.css">
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="side-image">
                <div class="box">
                    <div class="img-box">
                        <img src="assets/img/logo/medium-shot-kids-enjoying-picnic-day.jpg" width="500px" alt="Login Image">
                    </div>
                </div>
            </div>
            <div class="right">
                <div class="input-box">
                    <header>Entrar</header>
                    
                    <?php if (isset($_GET['message'])): ?>
                        <p class="error-message"><?= htmlspecialchars($_GET['message']) ?></p>
                    <?php endif; ?>
                   
                    <form action="login.php" method="post">
                        <div class="input-field">
                            <input type="email" name="email" class="input" required>
                            <label for="email">E-mail</label>
                        </div>
                        <div class="input-field">
                            <input type="password" name="password" class="input" required>
                            <label for="password">Senha</label>
                        </div>
                        <div class="input-field">
                            <button type="submit" class="submit">Entrar</button>
                        </div>
                        <div class="signin">
                            <span>Não tem uma conta? <a href="selecao.php">Cadastre-se</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
