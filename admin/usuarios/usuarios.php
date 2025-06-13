<?php
include("../../database/funcoes.php");
include("../../auth/validar_sessao.php");
if (isset($_SESSION["admin"]) && $_SESSION["admin"] < 2) {
    header("Location: ../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="Utd-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../assets/img/favicon_foodticket.svg" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/css/usuarios.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <title>FoodTickets | Usuários</title>
</head>

<body>
    <?php include("../../includes/loader.php"); ?>
    <?php include("../../includes/header.php"); ?>
    <main>
        <div class="interface">
            <div class="botoes">
                <div class="nome">
                    <h1>Gerenciar usuários</h1>
                    <p>Gerencie os usuários cadastrados</p>
                </div>
                <a href="cadastrar_usuario.php">Adicionar<i class="fa-solid fa-plus"></i></a>
            </div>
            <?php
            $select = "SELECT id, nome, email, admin, status FROM usuarios";
            $stmt = $conexao->prepare($select);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $nome, $email, $admin, $status);
            if ($stmt->num_rows >= 1):
            ?>
                <div class="container-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Nível de acesso</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($stmt->fetch()): ?>
                                <tr>
                                    <td class=" <?= ($status == 0) ? "desativado" : "" ?>"><?= htmlspecialchars($id) ?></td>
                                    <td class=" <?= ($status == 0) ? "desativado" : "" ?>"><?= htmlspecialchars($nome) ?></td>
                                    <td class=" <?= ($status == 0) ? "desativado" : "" ?>"><?= htmlspecialchars($email) ?></td>
                                    <td class=" <?= ($status == 0) ? "desativado" : "" ?>">
                                        <?= ($admin == 1) ? "Caixa" : (($admin == 2) ? "Admin" : "Usuário") ?></td>
                                    <td class="buttons">
                                        <?php if (($_SESSION["nome"] === "Administrador") && ($_SESSION["id"] === 1)): ?>
                                            <?php if ($_SESSION["id"] !== $id): ?>
                                                <form action="../../database/usuario/desativar_usuario.php" method="post">
                                                    <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($id) ?>">
                                                    <input type="hidden" name="status_usuario" value="<?= htmlspecialchars($status) ?>">
                                                    <button type="submit"><i
                                                            class="fas <?= ($status == 0) ? "fa-eye" : "fa-eye-slash" ?>"></i></button>
                                                </form>
                                            <?php endif; ?>
                                            <form action="editar_usuario.php" method="post">
                                                <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($id) ?>">
                                                <button type="submit"><i class="fa-solid fa-pen-to-square"></i></button>
                                            </form>
                                            <?php if ($_SESSION["id"] !== $id): ?>
                                                <form action="../../database/usuario/deletar_usuario.php" method="post"
                                                    onclick="return confirm('Tem certeza que quer deletar?')">
                                                    <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($id) ?>">
                                                    <button type="submit"><i class="fa-solid fa-trash-can"></i></button>
                                                </form>
                                            <?php endif;
                                        else: ?>
                                            <?php if (($_SESSION["id"] !== $id) && ($id !== 1)): ?>
                                                <form action="../../database/usuario/desativar_usuario.php" method="post">
                                                    <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($id) ?>">
                                                    <input type="hidden" name="status_usuario" value="<?= htmlspecialchars($status) ?>">
                                                    <button type="submit"><i
                                                            class="fas <?= ($status == 0) ? "fa-eye" : "fa-eye-slash" ?>"></i></button>
                                                </form>
                                            <?php endif; ?>
                                            <form action="editar_usuario.php" method="post">
                                                <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($id) ?>">
                                                <button type="submit"><i class="fa-solid fa-pen-to-square"></i></button>
                                            </form>
                                            <?php if (($_SESSION["id"] !== $id) && ($id !== 1)): ?>
                                                <form action="../../database/usuario/deletar_usuario.php" method="post"
                                                    onclick="return confirm('Tem certeza que quer deletar?')">
                                                    <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($id) ?>">
                                                    <button type="submit"><i class="fa-solid fa-trash-can"></i></button>
                                                </form>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                        </tbody>

                <?php
                            endwhile;
                            echo '</table>';
                        else:
                            echo '<p class="erro">Nenhum usuário cadastrada!</p>';
                        endif;
                ?>
                </div>
        </div>
    </main>
    <footer>
        <p class="direitos">© 2025 Sistema de Ficha • Todos os direitos reservados</p>
        <p>Feito com ♥ por <a href="https://leandroarantes.com.br/" target="_blank">Leandro Arantes</a></p>
    </footer>
    <?php
    include("../../includes/mensagem.php");
    ?>
    <script src="../../assets/js/menu-mobile.js"></script>
    <script src="../../assets/js/valida-formulario.js"></script>
</body>

</html>