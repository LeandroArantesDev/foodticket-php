<?php
include("../database/funcoes.php");
include("../auth/validar_sessao.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/img/favicon_foodticket.svg" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <title>FoodTickets | Dashboard</title>
</head>

<body>
    <?php include("../includes/loader.php"); ?>
    <?php include("../includes/header.php"); ?>
    <main>
        <div class="interface">
            <div class="botoes">
                <div class="nome">
                    <h1>Dashboard</h1>
                    <p>Visão geral do seu restaurante</p>
                </div>
                <a href="../index.php" target="_self" class="voltar"><i class="fa-solid fa-arrow-left"></i>Voltar ao
                    início</a>
            </div>
            <div class="grid-container">
                <a href="comidas/comidas.php" target="_self">
                    <article class="grid-item">
                        <div class="conteudo">
                            <p class="titulo">Comidas</p>
                            <p class="descricao"><?= htmlspecialchars(buscarComida()) ?></p>
                        </div>
                        <i class="fa-solid fa-utensils"></i>
                    </article>
                </a>
                <a href="categorias/categorias.php" target="_self">
                    <article class="grid-item">
                        <div class="conteudo">
                            <p class="titulo">Categorias</p>
                            <p class="descricao"><?= htmlspecialchars(buscarCategoria()) ?></p>
                        </div>
                        <i class="fa-solid fa-layer-group"></i>
                    </article>
                </a>
                <article class="grid-item">
                    <div class="conteudo">
                        <p class="titulo">Produto mais vendido</p>
                        <p class="descricao"><?= htmlspecialchars(buscarMaisVendido()) ?></p>
                    </div>
                    <i class="fa-solid fa-award"></i>
                </article>
                <article class="grid-item">
                    <div class="conteudo">
                        <p class="titulo">Total vendido</p>
                        <p class="descricao"><?= htmlspecialchars(buscarTotalVendido()) ?></p>
                    </div>
                    <i class="fa-solid fa-dollar-sign"></i>
                </article>
                <article class="grid-item row-2">
                    <p class="titulo-article">Ações Rápidas</p>
                    <a href="comidas/comidas.php" class="link">
                        <div class="card">
                            <i class="fa-solid fa-utensils"></i>
                            <div class="conteudo">
                                <p class="titulo">Gerenciar Cardápio</p>
                                <p class="descricao">Ver e editar comidas do cardápio</p>
                            </div>
                        </div>
                    </a>
                    <a href="categorias/categorias.php" class="link">
                        <div class="card">
                            <i class="fa-solid fa-layer-group"></i>
                            <div class="conteudo">
                                <p class="titulo">Gerenciar Categorias</p>
                                <p class="descricao">Ver e editar categorias do cardápio</p>
                            </div>
                        </div>
                    </a>
                    <a href="../index.php" class="link">
                        <div class="card">
                            <i class="fa-solid fa-user"></i>
                            <div class="conteudo">
                                <p class="titulo">Ver Cardápio</p>
                                <p class="descricao">Ver cardápio público</p>
                            </div>
                        </div>
                    </a>
                </article>
                <article class="grid-item row-2">
                    <div class="titulo-artique-group">
                        <p class="titulo-article">Resumo de vendas</p>
                        <a href="vendas/vendas.php"><span>Gerenciar vendas</span><i
                                class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <?php
                    $select = "SELECT c.nome AS produto, SUM(v.quantidade) AS quantidade_vendida FROM vendas v JOIN comidas c ON v.id_comida = c.id GROUP BY v.id_comida ORDER BY quantidade_vendida DESC LIMIT 5";
                    $resultado = $conexao->query($select);
                    while ($row = $resultado->fetch_assoc()):
                        $produto = $row["produto"];
                        $qVendida = $row["quantidade_vendida"];
                    ?>
                        <div class="produtos">
                            <p class="item"><?= htmlspecialchars($produto) ?></p>
                            <p class="vendas"><?= htmlspecialchars($qVendida) ?> vendas</p>
                        </div>
                    <?php endwhile; ?>
                </article>
            </div>
        </div>
    </main>
    <footer>
        <p class="direitos">© 2025 FoodTicket • Todos os direitos reservados</p>
        <p>Feito com ♥ por <a href="https://leandroarantes.com.br/" target="_blank">Leandro Arantes</a></p>
    </footer>

    <script src="../assets/js/menu-mobile.js"></script>
</body>

</html>