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
    <link rel="shortcut icon" href="../../assets/img/favicon_foodticket.svg" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/css/vendas.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/mensagem.css">
    <title>FoodTickets | Vendas</title>
</head>

<body>
    <?php include("../../includes/loader.php"); ?>
    <?php include("../../includes/header.php"); ?>
    <main>
        <div class="interface">
            <div class="botoes">
                <div class="nome">
                    <h1>Gerenciar vendas</h1>
                    <p>Gerencie as vendas feitas</p>
                </div>
                <a href="../../database/vendas/deletartudo_venda.php"
                    onclick="return confirm('Tem certeza que quer deletar TUDO?')">Deletar tudo<i
                        class="fa-solid fa-trash"></i></a>
            </div>
            <?php
            $select = "SELECT id, id_usuario, id_comida, quantidade, preco_unitario, data_venda FROM vendas";
            $stmt = $conexao->prepare($select);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $id_usuario, $id_comida, $quantidade, $preco_unitario, $data_venda);
            if ($stmt->num_rows >= 1):
            ?>
                <div class="container-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuário</th>
                                <th>Comida</th>
                                <th>Quantidade</th>
                                <th>Preço vendido</th>
                                <th>Data da venda</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <?php
                        while ($stmt->fetch()):
                        ?>
                            <tbody>
                                <tr>
                                    <td><?= htmlspecialchars($id) ?></td>
                                    <td><?= htmlspecialchars(buscarNomeUsuário($id_usuario)) ?></td>
                                    <td><?= htmlspecialchars(buscarNomeComida($id_comida)) ?></td>
                                    <td><?= htmlspecialchars($quantidade) ?></td>
                                    <td><?= htmlspecialchars(formatarPreco($preco_unitario)) ?></td>
                                    <td><?= htmlspecialchars($data_venda) ?></td>
                                    <td class="buttons">
                                        <?php if ($_SESSION["admin"] == 2): ?>
                                            <form action="../../database/vendas/deletar_venda.php" method="post"
                                                onclick="return confirm('Tem certeza que quer deletar?')">
                                                <input type="hidden" name="id_venda" value="<?= htmlspecialchars($id) ?>">
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
    <script src="../../assets/js/menu-mobile.js"></script>
    <script src="../../assets/js/valida-formulario.js"></script>
    <script src="../../assets/js/limitar-formulario.js"></script>
</body>

</html>