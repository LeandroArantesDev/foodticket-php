<?php
session_start();
require_once("database/conexao.php");
?>
<html>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/mensagem.css">
    <title>Sistema de Fichas | Catálogo</title>
</head>

<body>
    <header>
        <div class="interface">
            <?php if (isset($_SESSION["nome"]) && isset($_SESSION["admin"]) && $_SESSION["admin"] == 1): ?>
                <a href="admin/dashboard.php" target="_self" class="voltar"><i class="fa-solid fa-arrow-left"></i>Voltar a
                    Dashboard</a>
            <?php else: ?>
                <div class="logo">
                    <div class="icon">
                        <i class="fa-solid fa-ticket"></i>
                    </div>
                    <div class="nome">
                        <p>Sistemas de Fichas</p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!isset($_SESSION["nome"]) && !isset($_SESSION["admin"])): ?>
                <nav class="links">
                    <a href="entrar.php" target="_self">Entrar</a>
                    <a href="registrar.php" target="_self">Registrar-se</a>
                </nav>
            <?php else: ?>
                <nav class="links">
                    <a href="../auth/sair.php" target="_self">Sair</a>
                </nav>
            <?php endif; ?>


        </div>
    </header>
    <main>
        <div class="interface">
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
                                            <p class="preco">R$<?= htmlspecialchars($preco) ?></p>
                                            <p class="ingredientes">
                                                <span>Ingredientes:</span> <?= htmlspecialchars($ingredientes) ?>
                                            </p>
                                        </div>
                                    </div>
                                    <?php if (isset($_SESSION["nome"])): ?>
                                        <form action="database/usuario/imprimir_etiqueta.php" method="post" target="_blank">
                                            <input type="hidden" name="idUsuario" value="<?= htmlspecialchars($_SESSION["id"]) ?>">
                                            <input type="hidden" name="idComida" value="<?= htmlspecialchars($id) ?>">
                                            <input type="hidden" name="nomeComida" value="<?= htmlspecialchars($nome) ?>">
                                            <input type="hidden" name="precoComida" value="<?= htmlspecialchars($preco) ?>">
                                            <label for="quantidadeComida">quantidade</label>
                                            <input type="number" name="quantidadeComida" id="quantidadeComida" required min="1" value="1">
                                            <button><i class="fa-solid fa-print"></i>Imprimir</button>
                                        </form>
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
    <footer>
        <p class="direitos">© 2025 Sistema de Ficha • Todos os direitos reservados</p>
        <p>Feito com ♥ por <a href="https://leandroarantes.com.br/" target="_blank">Leandro Arantes</a></p>
    </footer>
    <?php
    include("includes/mensagem.php");
    ?>
</body>

</html>