<?php
require_once("../../database/conexao.php");
include("../../auth/validar_sessao.php");
include("../../database/funcoes.php");
$id_usuario = strip_tags(trim($_POST["id_usuario"]));

$select = "SELECT nome, email, admin FROM usuarios WHERE id = ?";
$stmt = $conexao->prepare($select);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$stmt->bind_result($nome, $email, $admin);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/form.css">
    <title>Sistema de Fichas | Entrar</title>
</head>

<body>
    <div class="interface">
        <form action="../../database/usuario/editar_usuario.php" method="post">
            <input type="hidden" name="csrf" value="<?= gerarCSRF() ?>">
            <input type="hidden" name="id" value="<?= $id_usuario ?>">
            <div class="logo">
                <img src="../../assets/img/logo_foodticket.svg" alt="Logo do site">
                <p class="acesse">Editar usuário</p>
            </div>

            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" placeholder="Digite o nome do usuário"
                    value="<?= htmlspecialchars($nome) ?>" required pattern="[A-Za-zÀ-ÿ0-9\s\-]{3,}"
                    title="Nome com pelo menos 3 caracteres. Letras, números, espaços e hífens são permitidos.">
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" placeholder="exemplo@email.com" required
                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                    title="Insira um e-mail válido, como exemplo@dominio.com" value="<?= htmlspecialchars($email) ?>">
            </div>
            <div class="form-group">
                <label for="admin">Admin</label>
                <input type="text" name="admin" id="admin"
                    placeholder="Insira 0 para usuário, 1 para caixa e 2 para administrador" required pattern="^[012]$"
                    title="Insira 0 para usuário, 1 para caixa e 2 para administrador"
                    value="<?= htmlspecialchars($admin) ?>">
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required
                    pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}"
                    title="A senha deve conter no mínimo 8 caracteres, com pelo menos uma letra maiúscula, uma minúscula, um número e um caractere especial">
            </div>

            <button type="submit">Editar</button>
            <a href="usuarios.php" target="_self" class="voltar"><i class="fa-solid fa-arrow-left"></i>Voltar ao
                início</a>
        </form>


    </div>
    <?php
    include("../../includes/mensagem.php");
    ?>
    <script src="assets/js/valida-formulario.js"></script>
</body>

</html>