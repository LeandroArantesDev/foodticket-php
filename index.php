<?php
require_once("database/conexao.php");
include("database/funcoes.php");
?>
<html>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/img/favicon_foodticket.svg" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>FoodTickets | Catálogo</title>
</head>

<body>
    <?php include("includes/header.php"); ?>
    <main>
        <div class="interface">
            <div class="botoes">
                <div class="nome">
                    <h1>Cardápio</h1>
                    <p>Visão de vendas das comidas cadastradas</p>
                </div>
                <?php if ((isset($_SESSION["admin"])) && ($_SESSION["admin"] > 0)): ?>
                    <a href="admin/dashboard.php" target="_self" class="voltar"><i class="fa-solid fa-arrow-left"></i>Voltar
                        a
                        Dashboard</a>
                <?php endif; ?>
            </div>
            <?php
            $selectCategoria = "SELECT id, nome FROM categorias";
            $stmtCategoria = $conexao->prepare($selectCategoria);
            $stmtCategoria->execute();
            $resultCategoria = $stmtCategoria->get_result();

            if ($resultCategoria->num_rows >= 1):
                foreach ($resultCategoria as $categoria):
                    $categoria_id = $categoria["id"];
                    $selectComida = "SELECT id, nome, descricao, preco, imagem, ingredientes FROM comidas WHERE id_categoria = ?";
                    $stmtComida = $conexao->prepare($selectComida);
                    $stmtComida->bind_param("i", $categoria_id);
                    $stmtComida->execute();
                    $stmtComida->store_result(); // necessário para usar num_rows
                    $stmtComida->bind_result($id, $nome, $descricao, $preco, $imagem, $ingredientes);

                    if ($stmtComida->num_rows >= 1):
            ?>
                        <p class="p-erro"><?= htmlspecialchars($categoria["nome"]) ?></p>
                        <div class="container-cards">
                            <?php while ($stmtComida->fetch()): ?>
                                <article class="card">
                                    <div class="item">
                                        <img src="<?= ($imagem) ? htmlspecialchars($imagem) : 'assets/img/img_padrao.jpg' ?>"
                                            alt="<?= htmlspecialchars($imagem ?? 'Imagem do produto') ?>">
                                        <div class="informacoes">
                                            <p class="nome"><?= htmlspecialchars($nome) ?></p>
                                            <p class="descricao"><?= htmlspecialchars($descricao) ?></p>
                                            <p class="preco" data-preco="<?= htmlspecialchars($preco) ?>">
                                                <?= htmlspecialchars(formatarPreco($preco)) ?>
                                            </p>

                                            <p class="ingredientes">
                                                <span>Ingredientes:</span> <?= htmlspecialchars($ingredientes) ?>
                                            </p>
                                        </div>
                                    </div>
                                    <?php if (isset($_SESSION["nome"]) && $_SESSION["admin"] > 0): ?>
                                        <div class="adicionar-carrinho">
                                            <label for="quantidadeComida<?= htmlspecialchars($id) ?>">quantidade</label>
                                            <input type="number" name="quantidadeComida" id="quantidadeComida<?= htmlspecialchars($id) ?>"
                                                required min="1" value="1">
                                            <button type="button" class="btn-adicionar-carrinho" data-id="<?= htmlspecialchars($id) ?>"
                                                data-nome="<?= htmlspecialchars($nome) ?>" data-preco="<?= htmlspecialchars($preco) ?>"><i
                                                    class="fa-solid fa-cart-plus"></i>Adicionar</button>
                                        </div>
                                    <?php endif; ?>
                                </article>
                            <?php endwhile; ?>
                        </div>
            <?php
                    else:
                        echo '<p class="p-erro">Nenhuma comida cadastrada!</p>';
                    endif;
                endforeach;
            else:
                echo '<p class="p-erro">Nenhuma categoria cadastrada!</p>';
            endif;
            ?>
        </div>

    </main>
    <aside id="carrinho-lateral">
        <div class="cabecalho">
            <h2>Produtos Selecionados</h2>
            <button><i class="fa-solid fa-x"></i></button>
        </div>
        <ul id="lista-carrinho"></ul>
        <div class="total-carrinho">
            <span>Total:</span>
            <span id="valor-total">R$ 0,00</span>
        </div>
        <form id="form-imprimir" action="database/usuario/imprimir_etiqueta.php" method="post" target="_blank"
            style="display:none;">
            <input type="hidden" name="itens" id="input-itens">
            <button type="submit" id="btn-imprimir-tudo"><i class="fa-solid fa-print"></i> Imprimir Tudo</button>
        </form>
    </aside>
    <footer>
        <p class="direitos">© 2025 Sistema de Ficha • Todos os direitos reservados</p>
        <p>Feito com ♥ por <a href="https://leandroarantes.com.br/" target="_blank">Leandro Arantes</a></p>
    </footer>
    <?php
    include("includes/mensagem.php");
    ?>
    <script src="assets/js/carrinho.js"></script>
    <script src="assets/js/menu-mobile.js"></script>
</body>

</html>