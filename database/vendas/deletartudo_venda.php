<?php
include("../funcoes.php");

$delete = "DELETE FROM vendas WHERE 1";
$stmt = $conexao->prepare($delete);
try {
    if ($stmt) {
        $resultado = $stmt->execute();
        $_SESSION['resposta'] = "Todas as vendas deletada com sucesso!";
        header("Location: ../../admin/vendas/vendas.php");
        $stmt = null;
        exit;
    } else {
        $_SESSION['resposta'] = "Ocorreu um erro!";
        header("Location: ../../admin/vendas/vendas.php");
        $stmt = null;
        exit;
    }
} catch (Exception $erro) {
    registrarErro(trim($_SESSION["id"]), $erro->getCode(), "deletar venda");
    switch ($erro->getCode()) {
        default:
            $_SESSION['resposta'] = "error" . $erro->getCode();
            header("Location: ../../admin/vendas/vendas.php");
            exit;
    }
}

header("Location: ../../admin/vendas/vendas.php");
$stmt = null;
exit;
