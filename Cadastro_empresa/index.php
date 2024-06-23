<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylecad.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Cadastro de Empresa</title>
</head>
<body>
<div class="container">
    <header>Cadastro de Empresa</header>
    <form action="cadastro_empresa.php" method="POST" enctype="multipart/form-data">
        <div class="form first">
            <div class="details personal">
                <div class="fields">
                    <div class="input-field">
                        <label>Nome da Empresa</label>
                        <input type="text" name="nome" placeholder="Nome da Empresa" required>
                    </div>
                    <div class="input-field">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Email da Empresa" required>
                    </div>
                    <div class="input-field">
                        <label>Senha</label>
                        <input type="password" name="senha" placeholder="Crie uma Senha" required>
                    </div>
                    <div class="input-field">
                        <label>Endereço</label>
                        <input type="text" name="endereco" placeholder="Endereço Completo" required>
                    </div>
                    <div class="input-field">
                        <label>Telefone</label>
                        <input type="text" name="telefone" placeholder="Telefone da Empresa" required>
                    </div>
                    <!-- <div class="input-field">
                        <label>Logotipo da Empresa (JPG, PNG)</label>
                        <input type="file" name="logotipo_empresa" accept="image/jpeg, image/png" class="file-upload">
                    </div> -->
                    <div class="input-field" style="margin-top: 20px;">
                        <button type="submit" class="submit">Cadastrar Empresa</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>

