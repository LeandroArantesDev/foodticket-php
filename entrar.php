<?php
include("database/funcoes.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/img/favicon_foodticket.svg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/form.css">
    <title>FoodTickets | Entrar</title>
</head>

<body>
    <?php include("includes/loader.php"); ?>
    <div class="interface">
        <form action="database/usuario/entrar.php" method="post">
            <input type="hidden" name="csrf" value="<?= gerarCSRF() ?>">
            <div class="logo">
                <img src="assets/img/logo_foodticket.svg" alt="Logo do site">
                <p class="acesse">Entrar na conta</p>
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" placeholder="exemplo@email.com" required
                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                    title="Insira um e-mail válido, como exemplo@dominio.com">
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required pattern=".{6,}"
                    title="A senha deve conter no mínimo 6 caracteres">
            </div>

            <button type="submit">Entrar</button>

            <p>Não tem uma conta? <a href="registrar.php" target="_self">Registre-se</a></p>
            <a href="index.php" target="_self" class="voltar"><i class="fa-solid fa-arrow-left"></i>Voltar ao início</a>
        </form>
    </div>
    <?php
    include("includes/mensagem.php");
    ?>
    <script src="assets/js/valida-formulario.js"></script>
</body>

</html>