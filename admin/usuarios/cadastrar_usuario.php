<?php
include("../../auth/validar_sessao.php");
include("../../database/funcoes.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/comidas_editar.css">
    <link rel="stylesheet" href="../../assets/css/form.css">
    <title>Sistema de Fichas | </title>
</head>

<body>
    <?php include("../../includes/loader.php"); ?>
    <div class="interface">
        <form action="../../database/usuario/cadastrar_usuario.php" method="post">
            <input type="hidden" name="csrf" value="<?= gerarCSRF() ?>">
            <div class="logo">
                <img src="../../assets/img/logo_foodticket.svg" alt="Logo do site">
                <p class="acesse">Cadastrar usuário</p>
            </div>

            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" placeholder="Digite o nome do alimento" required
                    pattern="^(?=.{3,18}$)[A-Za-zÀ-ÖØ-öø-ÿ]+(?: [A-Za-zÀ-ÖØ-öø-ÿ]+)*$"
                    title="Digite um nome com pelo menos 3 letras (no máximo 18 caractéres)">
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" placeholder="exemplo@email.com" required
                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                    title="Insira um e-mail válido, como exemplo@dominio.com">
            </div>

            <div class="form-group">
                <label for="admin">Admin</label>
                <input type="text" name="admin" id="admin"
                    placeholder="Insira 0 para usuário, 1 para caixa e 2 para administrador" required pattern="^[012]$"
                    title="Insira 0 para usuário, 1 para caixa e 2 para administrador">
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required
                    pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}"
                    title="A senha deve conter no mínimo 8 caracteres, com pelo menos uma letra maiúscula, uma minúscula, um número e um caractere especial">
            </div>

            <div class="form-group">
                <label for="confirmarsenha">Confirme a senha</label>
                <input type="password" name="confirmarsenha" id="confirmarsenha"
                    placeholder="Digite sua senha novamente" required
                    pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}"
                    title="Repita a senha com os mesmos critérios">
            </div>

            <button type="submit">Cadastrar</button>
            <a href="usuarios.php" target="_self" class="voltar"><i class="fa-solid fa-arrow-left"></i>Voltar ao
                início</a>
        </form>
    </div>
    <?php
    include("../../includes/mensagem.php");
    ?>
    <script src="../../assets/js/valida-formulario.js"></script>
</body>

</html>