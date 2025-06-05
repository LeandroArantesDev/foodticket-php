<?php
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    define('BASE_URL', '/FOODTICKET/');
} else {
    define('BASE_URL', '/');
} ?>
<header>
    <div class="interface">
        <div class="logo">
            <img src="<?= BASE_URL ?>assets/img/logo_foodticket.svg" alt="Logo do site">
        </div>
        <nav class="menu">
            <?php
            if (isset($_SESSION["admin"])):
                switch ($_SESSION["admin"]):
                    case 2:
            ?>
                        <a href="<?= BASE_URL ?>index.php" target="_self">Cardapio</a>
                        <a href="<?= BASE_URL ?>admin/categorias/categorias.php">Categorias</a>
                        <a href="<?= BASE_URL ?>admin/comidas/comidas.php">Comidas</a>
                        <a href="<?= BASE_URL ?>admin/dashboard.php">Dashboard</a>
                        <a href="<?= BASE_URL ?>admin/erros/erros.php">Erros</a>
                        <a href="<?= BASE_URL ?>admin/usuarios/usuarios.php">Usuários</a>
                        <a href="<?= BASE_URL ?>admin/vendas/vendas.php">Vendas</a>
                        <a href="<?= BASE_URL ?>auth/sair.php" target="_self">Sair</a>

                    <?php
                        break;
                    case 1:
                    ?>
                        <a href="<?= BASE_URL ?>index.php" target="_self">Cardapio</a>
                        <a href="<?= BASE_URL ?>admin/categorias/categorias.php">Categorias</a>
                        <a href="<?= BASE_URL ?>admin/comidas/comidas.php">Comidas</a>
                        <a href="<?= BASE_URL ?>admin/vendas/vendas.php">Vendas</a>
                        <a href="<?= BASE_URL ?>auth/sair.php" target="_self">Sair</a>
                    <?php
                        break;
                    case 0:
                    ?>
                        <a href="<?= BASE_URL ?>index.php" target="_self">Cardapio</a>
                        <a href="<?= BASE_URL ?>auth/sair.php" target="_self">Sair</a>
                        <?php break; ?>
                <?php endswitch;
            else: ?>
                <a href="<?= BASE_URL ?>entrar.php" target="_self">Entre</a>
                <a href="<?= BASE_URL ?>registrar.php" target="_self">Registre-se</a>
            <?php endif; ?>
        </nav>
        <button class="btn-menu" id="btn-menu"><i class="fa-solid fa-bars"></i></button>
    </div>
</header>