<?php
include("../../database/funcoes.php");
include("../../auth/validar_sessao.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../assets/img/favicon_foodticket.svg" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/css/comidas.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <title>FoodTickets | Comidas</title>
</head>

<body>
    <?php include("../../includes/loader.php"); ?>
    <?php include("../../includes/header.php"); ?>
    <main>
        <div class="interface">
            <div class="botoes">
                <div class="nome">
                    <h1>Gerenciar de Cardápio</h1>
                    <p>Gerencie os itens do seu cardápio</p>
                </div>
                <a href="cadastrar_comida.php">Adicionar<i class="fa-solid fa-plus"></i></a>
            </div>
            <div class="container-cards">
                <?php
                $select = "SELECT id, nome, descricao, preco, ingredientes, imagem, status FROM comidas ORDER BY status DESC;";
                $resultado = $conexao->query($select);
                if ($resultado->num_rows >= 1):
                    while ($row = $resultado->fetch_assoc()):
                        $nome = $row["nome"];
                        $descricao = $row["descricao"];
                        $preco = $row["preco"];
                        $ingredientes = $row["ingredientes"];
                        $id = $row["id"];
                        $imagem = $row["imagem"];
                        $status = $row["status"];

                ?>
                        <article class="card">
                            <div class="item">
                                <img class="imagem <?= ($status == 0) ? "desativado" : "" ?>"
                                    src="<?= ($imagem) ? htmlspecialchars($imagem) : 'assets/img/img_padrao.jpg' ?>">
                                <div class="informacoes">
                                    <p class="nome <?= ($status == 0) ? "desativado" : "" ?>"><?= htmlspecialchars($nome) ?></p>
                                    <p class="descricao"><?= htmlspecialchars($descricao) ?></p>
                                    <p class="ingredientes"><span>Ingredientes: </span><?= htmlspecialchars($ingredientes) ?>
                                    <p class="preco <?= ($status == 0) ? "desativado" : "" ?>">
                                        <?= htmlspecialchars(formatarPreco($preco)) ?></p>
                                    </p>
                                </div>
                            </div>
                            <div class="buttons">
                                <?php if ($_SESSION["admin"] == 2): ?>
                                    <form action="../../database/comidas/desativar_usuario.php" method="post">
                                        <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($id) ?>">
                                        <input type="hidden" name="status_usuario" value="<?= htmlspecialchars($status) ?>">
                                        <button type="submit"><i
                                                class="fas <?= ($status == 0) ? "fa-eye" : "fa-eye-slash" ?>"></i></button>
                                    </form>
                                    <form action="editar_comida.php" method="post">
                                        <input type="hidden" name="id_comida" value="<?= htmlspecialchars($id) ?>">
                                        <button type="submit"><i class="fa-solid fa-pen-to-square"></i></button>
                                    </form>
                                    <form action="../../database/comidas/deletar_comida.php" method="post"
                                        onclick="return confirm('Tem certeza que quer deletar?')">
                                        <input type="hidden" name="id_comida" value="<?= htmlspecialchars($id) ?>">
                                        <button type="submit"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                <?php else: ?>
                                    <form action="../../database/comidas/desativar_comida.php" method="post">
                                        <input type="hidden" name="id_comida" value="<?= htmlspecialchars($id) ?>">
                                        <input type="hidden" name="status_comida" value="<?= htmlspecialchars($status) ?>">
                                        <button type="submit"><i
                                                class="fas <?= ($status == 0) ? "fa-eye" : "fa-eye-slash" ?>"></i></button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </article>
                <?php endwhile;
                else:
                    echo '<p class="erro">Nenhuma comida cadastrada!</p>';
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
</body>

</html>