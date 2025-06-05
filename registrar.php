<?php
include("database/funcoes.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/form.css">
    <title>Sistema de Fichas | Registrar-se</title>
</head>

<body>
    <div class="interface">
        <form action="database/usuario/registrar.php" method="post">
            <input type="hidden" name="csrf" value="<?= gerarCSRF() ?>">
            <div class="logo">
                <img src="assets/img/logo_foodticket.svg" alt="Logo do site">
                <p class="acesse">Entrar na conta</p>
            </div>
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" placeholder="Seu nome completo" required
                    pattern="[A-Za-zÀ-ÿ\s]{3,}"
                    title="Digite seu nome completo (mínimo 3 letras, apenas letras e espaços)">
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" placeholder="exemplo@email.com" required
                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                    title="Insira um e-mail válido, como exemplo@dominio.com">
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

            <button type="submit">Registrar-se</button>

            <p>Já tem uma conta? <a href="entrar.php" target="_self">Entrar</a></p>
            <a href="index.php" target="_self" class="voltar"><i class="fa-solid fa-arrow-left"></i>Voltar ao início</a>
        </form>


    </div>
    <?php
    include("includes/mensagem.php");
    ?>
    <script src="assets/js/valida-formulario.js"></script>
</body>

</html>