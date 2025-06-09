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
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/form.css">
    <title>Sistema de Fichas | </title>
</head>

<body>
    <?php include("../../includes/loader.php"); ?>
    <div class="interface">
        <form action="../../database/comidas/cadastrar_comida.php" method="post">
            <input type="hidden" name="csrf" value="<?= gerarCSRF() ?>">
            <div class="logo">
                <img src="../../assets/img/logo_foodticket.svg" alt="Logo do site">
                <p class="acesse">Cadastrar categoria</p>
            </div>
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" placeholder="Digite o nome do alimento" required
                    pattern="^(?=.{3,18}$)[A-Za-zÀ-ÖØ-öø-ÿ]+(?: [A-Za-zÀ-ÖØ-öø-ÿ]+)*$"
                    title="Digite um nome com pelo menos 3 letras (no máximo 18 caractéres)">
            </div>

            <div class="form-group">
                <label for="descricao">Descrição</label>
                <input type="text" name="descricao" id="descricao" placeholder="Digite a descrição do alimento" required
                    pattern="^(?=.{1,100}$)[A-Za-zÀ-ÖØ-öø-ÿ0-9 !?,.]+$"
                    title="Ingredientes com pelo entre 1 e 100 caracteres">
            </div>

            <div class="form-group">
                <label for="preco">Preço</label>
                <input type="text" name="preco" id="preco" placeholder="Digite o preço do alimento" required
                    pattern="^\d{1,4}(.\d{1,2})?$" title="Informe um valor válido (mínimo: 0.01 e máximo 9999.99)">
            </div>

            <div class="form-group">
                <label for="id_categoria">Categoria</label>
                <select name="id_categoria" id="id_categoria" required>
                    <option value="">Selecione uma categoria</option>
                    <?php
                    $sqlCategoria = "SELECT id, nome FROM categorias";
                    $resultadoCategoria = $conexao->query($sqlCategoria);
                    while ($rowCategoria = $resultadoCategoria->fetch_assoc()):
                    ?>
                        <option value="<?= htmlspecialchars($rowCategoria["id"]) ?>">
                            <?= htmlspecialchars($rowCategoria["nome"]) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="ingredientes">Ingredientes</label>
                <input type="text" name="ingredientes" id="ingredientes"
                    placeholder="Digite os ingredientes do alimento" required
                    pattern="^(?=.{1,100}$)[A-Za-zÀ-ÖØ-öø-ÿ0-9,]+(?: [A-Za-zÀ-ÖØ-öø-ÿ0-9,]+)*$"
                    title="Ingredientes com pelo entre 1 e 100 caracteres">
            </div>

            <div class="form-group">
                <label for="imagem">URL da imagem</label>
                <input type="url" name="imagem" id="imagem" placeholder="Coloque a URL da imagem" required
                    pattern="https?://[^\s/$.?#].[^\s]*"
                    title="Informe uma URL válida (ex: https://exemplo.com/imagem.jpg)">
            </div>

            <button type="submit">Cadastrar</button>
            <a href="comidas.php" target="_self" class="voltar"><i class="fa-solid fa-arrow-left"></i>Voltar ao
                início</a>
        </form>


    </div>
    <?php
    include("../../includes/mensagem.php");
    ?>
    <script src="../../assets/js/valida-formulario.js"></script>
</body>

</html>