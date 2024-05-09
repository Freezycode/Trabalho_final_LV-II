<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Freelancer</title>
   
    
</head>

<body>
    <main>
        <h1>Cadastro de Freelancer</h1>

        <form action="cadastrar_freelancer.php" method="post">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="username">Nome de Usuário:</label>
            <input type="text" id="username" name="username" required>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
            <label for="habilidades">Habilidades:</label>
            <input type="text" id="habilidades" name="habilidades" required>
            <label for="experiencia">Experiência:</label>
            <textarea id="experiencia" name="experiencia" required></textarea>
            <label for="portfolio">Portfolio:</label>
            <input type="text" id="portfolio" name="portfolio">
            <label for="informacoes_pagamento">Informações de Pagamento:</label>
            <textarea id="informacoes_pagamento" name="informacoes_pagamento" required></textarea>
            <button type="submit">Cadastrar</button>
        </form>
    </main>
</body>

</html>
