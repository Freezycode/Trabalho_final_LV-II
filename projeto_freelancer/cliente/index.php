<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente</title>
    <link rel="stylesheet" href="/assets/CSS/cadfre.css">
</head>

<body>
    <main>
        <h1>Cadastro de Cliente</h1>

        <form action="cadastrar_cliente.php" method="post">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="username">Nome de Usuário:</label>
            <input type="text" id="username" name="username" required>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
            <label for="informacoes_empresa">Informações da Empresa:</label>
            <textarea id="informacoes_empresa" name="informacoes_empresa" required></textarea>
            <button type="submit">Cadastrar</button>
        </form>
    </main>
</body>

