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
    <link rel="stylesheet" href="../../assets/css/categorias.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/mensagem.css">
    <title>Categorias</title>
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
                    <h1>Gerenciar categorias</h1>
                    <p>Gerencie as categorias dos itens do cardápio</p>
                </div>
                <a href="cadastrar_categoria.php">Adicionar<i class="fa-solid fa-plus"></i></a>
            </div>
            <div class="container-cards">
                <?php
                $select = "SELECT id, nome FROM categorias";
                $resultado = $conexao->query($select);
                if ($resultado->num_rows >= 1):
                    while ($row = $resultado->fetch_assoc()):
                        $id = $row["id"];
                        $nome = $row["nome"];
                ?>
                        <article class="card">
                            <div class="item">
                                <div class="informacoes">
                                    <p class="nome"><?= htmlspecialchars($nome) ?></p>
                                </div>
                            </div>
                            <div class="buttons">
                                <form action="editar_categoria.php" method="post">
                                    <input type="hidden" name="id_categoria" value="<?= htmlspecialchars($id) ?>">
                                    <button type="submit"><i class="fa-solid fa-pen-to-square"></i></button>
                                </form>
                                <form action="../../database/categorias/deletar_categoria.php" method="post"
                                    onclick="return confirm('Tem certeza que quer deletar?')">
                                    <input type="hidden" name="id_categoria" value="<?= htmlspecialchars($id) ?>">
                                    <button type="submit"><i class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </div>
                        </article>
                <?php
                    endwhile;
                else:
                    echo '<p class="nenhum-cadastro">Nenhuma categoria cadastrada!</p>';
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