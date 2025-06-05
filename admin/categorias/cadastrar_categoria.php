<?php
include("../../database/conexao.php");
include("../../auth/validar_sessao.php");
include("../../database/funcoes.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../assets/img/favicon_foodticket.svg" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/css/form.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <title>FoodTickets | Cadastrar categoria</title>
</head>

<body>
    <div class="interface">
        <form action="../../database/categorias/cadastrar_categoria.php" method="post">
            <div class="logo">
                <img src="../../assets/img/logo_foodticket.svg" alt="Logo do site">
                <p class="acesse">Cadastrar categoria</p>
            </div>
            <input type="hidden" name="csrf" value="<?= gerarCSRF() ?>">

            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" placeholder="Digite o nome do alimento" required
                    pattern="[A-Za-zÀ-ÿ\s]{3,}"
                    title="Digite um nome com pelo menos 3 letras (apenas letras e espaços)">
            </div>

            <button type="submit">Cadastrar</button>
            <a href="categorias.php" target="_self" class="voltar"><i class="fa-solid fa-arrow-left"></i>Voltar ao
                início</a>
        </form>
    </div>
    <?php
    include("../../includes/mensagem.php");
    ?>
    <script src="../../assets/js/valida-formulario.js"></script>
</body>

</html>