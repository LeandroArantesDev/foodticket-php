<?php
include("../../auth/validar_sessao.php");
include("../../database/funcoes.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="Utd-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/usuarios.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/mensagem.css">
    <title>FoodTickets | Usuários</title>
</head>

<body>
    <header>
        <div class="interface">
            <a href="../dashboard.php" target="_self" class="voltar"><i class="fa-solid fa-arrow-left"></i>Voltar
                para Dashboard</a>
            <nav class="links">
                <a href="../../auth/sair.php" target="_self">Sair</a>
            </nav>
        </div>
    </header>
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
            $select = "SELECT id, nome, email, admin FROM usuarios";
            $stmt = $conexao->prepare($select);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $nome, $email, $admin);
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
                    <?php
                        while ($stmt->fetch()):
                        ?>
                    <tbody>
                        <tr>
                            <td><?= htmlspecialchars($id) ?></td>
                            <td><?= htmlspecialchars($nome) ?></td>
                            <td><?= htmlspecialchars($email) ?></td>
                            <td><?= ($admin == 1) ? "Caixa" : (($admin == 2) ? "Admin" : "Usuário") ?></td>
                            <td class="buttons">
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
                                <?php endif; ?>
                            </td>
                        </tr>
                    </tbody>

                    <?php
                        endwhile;
                        echo '</table>';
                    else:
                        echo '<p class="p-erro">Nenhuma venda cadastrada!</p>';
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
</body>

</html>