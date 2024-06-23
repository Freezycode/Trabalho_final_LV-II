<?php
require 'pdo_connection.php'; // Ajuste o caminho conforme necessário
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "<script>alert('Por favor, faça login primeiro.'); window.location.href = 'login.php';</script>";
    exit();
}

$usuarioId = $_SESSION['usuario']['id_usuarios'];

try {
    $sql = "SELECT u.nome, u.email, u.endereco, u.telefone, v.logotipo_empresa 
            FROM usuarios u 
            LEFT JOIN vagas v ON u.id_usuarios = v.usuarios_id_empresa_vaga 
            WHERE u.id_usuarios = ? 
            ORDER BY v.id_vagas DESC 
            LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$usuarioId]);
    $usuario = $stmt->fetch();

    if (!$usuario) {
        throw new Exception("Usuário não encontrado!");
    }
} catch (Exception $e) {
    die("Erro: " . $e->getMessage());
}

// Atualiza a imagem de logotipo se estiver presente na sessão
if (isset($_SESSION['logotipo_empresa'])) {
    $usuario['logotipo_empresa'] = $_SESSION['logotipo_empresa'];
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil da Empresa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('profile-img');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function showSuccessMessage() {
            var successMessage = document.getElementById('successMessage');
            successMessage.style.display = 'block';
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 3000);
        }

        function formatCurrency(input) {
            let value = input.value.replace(/\D/g, '');
            value = (value / 100).toFixed(2) + '';
            value = value.replace('.', ',');
            value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
            input.value = value;
        }
    </script>
</head>
<body>
    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">Editar e Cadastrar Vagas</h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">Perfil</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-info">Postar Nova Vaga</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="account-general">
                            <div class="card-body media align-items-center">
                                
                                <div class="media-body ml-4">
                                    <form action="update_profile.php" method="post" enctype="multipart/form-data">
                                     
                                       
                                    </form>
                                </div>
                                <div class="ml-auto">
                                    <form action="../index.php" method="get">
                                        <button type="submit" class="btn btn-secondary">Voltar para a Página Inicial</button>
                                    </form>
                                </div>
                            </div>
                            <hr class="border-light m-0">
                            <form action="update_profile.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="logotipo" id="hidden-logotipo">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">Nome da empresa</label>
                                        <input type="text" class="form-control mb-1" name="nome" value="<?= htmlspecialchars($usuario['nome']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Endereço</label>
                                        <input type="text" class="form-control" name="endereco" value="<?= htmlspecialchars($usuario['endereco']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Telefone</label>
                                        <input type="text" class="form-control" name="telefone" value="<?= htmlspecialchars($usuario['telefone']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">E-mail</label>
                                        <input type="email" class="form-control mb-1" name="email" value="<?= htmlspecialchars($usuario['email']); ?>">
                                    </div>
                                    <label class="btn btn-outline-primary">
                                        <input type="file" name="logotipo" class="account-settings-fileinput" onchange="previewImage(event)">
                                    </label>
                                    <button type="submit" class="btn btn-primary" onclick="showSuccessMessage()">Salvar alterações</button>
                                    <button type="button" class="btn btn-default" onclick="window.location.href='../index.php'">Cancelar</button>
                                    <div id="successMessage" class="alert alert-success" style="display:none;">
                                        Perfil atualizado com sucesso!
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="account-info">
                            <form action="post_vaga.php" method="post">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Título da Vaga</label>
                                        <input type="text" class="form-control" name="titulo" placeholder="Insira o título da vaga">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Descrição da Vaga</label>
                                        <textarea class="form-control" name="descricao" rows="5" placeholder="Insira a descrição da vaga aqui..."></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Requisitos</label>
                                        <input type="text" class="form-control" name="requisitos" placeholder="Especifique os requisitos necessários">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Número de Vagas</label>
                                        <select class="custom-select" name="quantidade_vagas">
                                            <?php for ($i = 1; $i <= 1000; $i++) {
                                                echo "<option value='$i'>$i</option>";
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Remuneração</label>
                                        <input type="text" class="form-control" name="remuneracao" oninput="formatCurrency(this);" placeholder="R$">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Postar Vaga</button>
                                    <button type="button" class="btn btn-default" onclick="window.location.href='index.php'">Cancelar</button>
                                    <div id="successMessage" class="alert alert-success" style="display:none;">
                                        Vaga postada com sucesso!
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
