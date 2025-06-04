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
    <link rel="stylesheet" href="../../assets/css/usuarios_editar.css">
    <link rel="stylesheet" href="../../assets/css/mensagem.css">
    <title>Sistema de Fichas | Entrar</title>
</head>

<body>
    <div class="interface">
        <p class="acesse">Editar produto</p>
        <form action="../../database/usuario/editar_usuario.php" method="post">
            <input type="hidden" name="csrf" value="<?= gerarCSRF() ?>">
            <input type="hidden" name="id" value="<?= $id_usuario ?>">

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
                <input type="text" name="admin" id="admin" placeholder="0 ou 1" required pattern="^[01]$"
                    title="Insira 0 para usuário comum ou 1 para administrador" value="<?= htmlspecialchars($admin) ?>">
            </div>

            <button type="submit">Editar</button>
        </form>

        <a href="usuarios.php" target="_self" class="voltar"><i class="fa-solid fa-arrow-left"></i>Cancelar edição</a>
    </div>
    <?php
    include("../../includes/mensagem.php");
    ?>
</body>

</html>