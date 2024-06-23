<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="candidato.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Cadastro de Candidato</title>
</head>
<body>
<div class="container">
    <header>Cadastro de Candidato</header>
    <form action="cadastro_candidato.php" method="POST">
        <div class="form first">
            <div class="details personal">
                <span class="title">Preencha os campos</span>
                <div class="fields">
                    <div class="input-field">
                        <label>Nome completo</label>
                        <input type="text" name="nome" placeholder="Nome completo" required>
                    </div>
                    <div class="input-field">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Coloque seu email" required>
                    </div>
                    <div class="input-field">
                        <label>Senha</label>
                        <input type="password" name="senha" placeholder="Digite sua senha" required>
                    </div>
                    <div class="input-field">
                        <label>Descrição</label>
                        <textarea name="descricao" placeholder="Escreva uma breve descrição sobre você" rows="4" required></textarea>
                    </div>
                    <div class="input-field">
                        <button type="submit" class="submit">Cadastrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="cadastro1.js"></script>
</body>
</html>

