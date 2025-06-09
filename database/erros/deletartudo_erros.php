<?php
include("../funcoes.php");

$delete = "DELETE FROM erros WHERE 1";
$stmt = $conexao->prepare($delete);
try {
    if ($stmt) {
        $resultado = $stmt->execute();
        $_SESSION['resposta'] = "Todas os erros deletados com sucesso!";
        header("Location: ../../admin/erros/erros.php");
        $stmt = null;
        exit;
    } else {
        $_SESSION['resposta'] = "Ocorreu um erro!";
        header("Location: ../../admin/erros/erros.php");
        $stmt = null;
        exit;
    }
} catch (Exception $erro) {
    registrarErro(trim($_SESSION["id"]), $erro->getCode(), "deletar erro");
    switch ($erro->getCode()) {
        default:
            $_SESSION['resposta'] = "error" . $erro->getCode();
            header("Location: ../../admin/erros/erros.php");
            exit;
    }
}

header("Location: ../../admin/erros/erros.php");
$stmt = null;
exit;
