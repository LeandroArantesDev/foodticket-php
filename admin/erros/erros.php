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
    <link rel="stylesheet" href="../../assets/css/erros.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/mensagem.css">
    <title>Sistema de Fichas | Categorias</title>
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
                    <h1>Gerenciar erros</h1>
                    <p>Gerencie as erros acusados</p>
                </div>
                <a href="../../database/erros/deletartudo_erros.php"
                    onclick="return confirm('Tem certeza que quer deletar TUDO?')">Deletar tudo<i
                        class="fa-solid fa-trash"></i></a>
            </div>
            <?php
            $select = "SELECT id, id_usuario, erro, origem, data_ocorrido FROM erros";
            $stmt = $conexao->prepare($select);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $id_usuario, $erro, $origem, $data_ocorrido);
            if ($stmt->num_rows >= 1):
            ?>
                <div class="container-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuário</th>
                                <th>Erro</th>
                                <th>Origem</th>
                                <th>Data do ocorrido</th>
                            </tr>
                        </thead>
                        <?php
                        while ($stmt->fetch()):
                        ?>
                            <tbody>
                                <tr>
                                    <td><?= htmlspecialchars($id) ?></td>
                                    <td><?= htmlspecialchars(buscarNomeUsuário($id_usuario)) ?></td>
                                    <td><?= htmlspecialchars($erro) ?></td>
                                    <td><?= htmlspecialchars($origem) ?></td>
                                    <td><?= htmlspecialchars($data_ocorrido) ?></td>
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