<?php
require_once("../../database/conexao.php");
include("../../auth/validar_sessao.php");
include("../../database/funcoes.php");
$id_comida = strip_tags(trim($_POST["id_comida"]));

$select = "SELECT nome, descricao, preco, ingredientes, imagem, id_categoria FROM comidas WHERE id = ?";
$stmt = $conexao->prepare($select);
$stmt->bind_param("i", $id_comida);
$stmt->execute();
$stmt->bind_result($nome, $descricao, $preco, $ingredientes, $imagem, $id_categoria);
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
    <?php include("../../includes/loader.php"); ?>
    <div class="interface">
        <form action="../../database/comidas/editar_comida.php" method="post">
            <input type="hidden" name="csrf" value="<?= gerarCSRF() ?>">
            <input type="hidden" name="id" value="<?= $id_comida ?>">
            <div class="logo">
                <img src="../../assets/img/logo_foodticket.svg" alt="Logo do site">
                <p class="acesse">Cadastrar categoria</p>
            </div>
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" placeholder="Digite o nome do alimento"
                    value="<?= htmlspecialchars($nome) ?>" required pattern="[A-Za-zÀ-ÿ0-9\s\-]{3,}"
                    title="Nome com pelo menos 3 caracteres. Letras, números, espaços e hífens são permitidos.">
            </div>

            <div class="form-group">
                <label for="descricao">Descrição</label>
                <input type="text" name="descricao" id="descricao" placeholder="Digite a descrição do alimento"
                    value="<?= htmlspecialchars($descricao) ?>" required pattern=".{10,}"
                    title="Descrição com pelo menos 10 caracteres">
            </div>

            <div class="form-group">
                <label for="preco">Preço</label>
                <input type="number" name="preco" id="preco" placeholder="Digite o preço do alimento"
                    value="<?= htmlspecialchars($preco) ?>" required min="0.01" step="0.01"
                    title="Informe um valor válido (mínimo: 0.01)">
            </div>

            <div class="form-group">
                <label for="id_categoria">Categoria</label>
                <select name="id_categoria" id="id_categoria" required>
                    <?php
                    $sqlCategoria = "SELECT id, nome FROM categorias";
                    $resultadoCategoria = $conexao->query($sqlCategoria);
                    while ($rowCategoria = $resultadoCategoria->fetch_assoc()):
                    ?>
                    <option value="<?= htmlspecialchars($rowCategoria["id"]) ?>"
                        <?= ($id_categoria == $rowCategoria["id"]) ? "selected" : "" ?>>
                        <?= htmlspecialchars($rowCategoria["nome"]) ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="ingredientes">Ingredientes</label>
                <input type="text" name="ingredientes" id="ingredientes"
                    placeholder="Digite os ingredientes do alimento" value="<?= htmlspecialchars($ingredientes) ?>"
                    required pattern=".{5,}" title="Ingredientes com pelo menos 5 caracteres">
            </div>

            <div class="form-group">
                <label for="imagem">URL da imagem</label>
                <input type="url" name="imagem" id="imagem" placeholder="Coloque a URL da imagem"
                    value="<?= htmlspecialchars($imagem) ?>" required
                    title="Informe uma URL válida (ex: https://exemplo.com/imagem.jpg)">
            </div>

            <button type="submit">Editar</button>
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