<?php
include("../funcoes.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = strip_tags(trim($_POST["id_venda"]));

    $delete = "DELETE FROM vendas WHERE id = ?";
    $stmt = $conexao->prepare($delete);
    try {
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $resultado = $stmt->execute();
            $stmt->close();

            $_SESSION['resposta'] = "Venda deletada com sucesso!";
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
} else {
    $_SESSION['resposta'] = "Método de solicitação ínvalido!";
}

header("Location: ../../admin/vendas/vendas.php");
$stmt = null;
exit;
