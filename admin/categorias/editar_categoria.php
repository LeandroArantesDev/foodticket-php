<?php
require_once("../../database/conexao.php");
include("../../auth/validar_sessao.php");
include("../../database/funcoes.php");
$id_categoria = strip_tags(trim($_POST["id_categoria"]));

$select = "SELECT nome FROM categorias WHERE id = ?";
$stmt = $conexao->prepare($select);
$stmt->bind_param("i", $id_categoria);
$stmt->execute();
$stmt->bind_result($nome);
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
    <link rel="stylesheet" href="../../assets/css/comidas_editar.css">
    <link rel="stylesheet" href="../../assets/css/mensagem.css">
    <title>Editar Categoria</title>
</head>

<body>
    <div class="interface">
        <p class="acesse">Editar produto</p>
        <form action="../../database/categorias/editar_categoria.php" method="post">
            <input type="hidden" name="csrf" value="<?= gerarCSRF() ?>">
            <input type="hidden" name="id" value="<?= $id_categoria ?>">

            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" placeholder="Digite o nome do alimento"
                    value="<?= htmlspecialchars($nome) ?>" required pattern="[A-Za-zÀ-ÿ\s]{3,}"
                    title="Digite um nome com pelo menos 3 letras (apenas letras e espaços)">
            </div>

            <button type="submit">Editar</button>
        </form>

        <a href="categorias.php" target="_self" class="voltar"><i class="fa-solid fa-arrow-left"></i>Cancelar edição</a>
    </div>
    <?php
    include("../../includes/mensagem.php");
    ?>
</body>

</html>