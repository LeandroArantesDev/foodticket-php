<?php
require_once("../conexao.php");
include("../funcoes.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = strip_tags(trim($_POST["id_categoria"]));

    $delete = "DELETE FROM categorias WHERE id = ?";
    $stmt = $conexao->prepare($delete);

    try {
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $resultado = $stmt->execute();
            $stmt->close();

            $_SESSION['resposta'] = "Categoria deletada com sucesso!";
            header("Location: ../../admin/categorias/categorias.php");
            $stmt = null;
            exit;
        } else {
            $_SESSION['resposta'] = "Ocorreu um erro!";
            header("Location: ../../admin/categorias/categorias.php");
            $stmt = null;
            exit;
        }
    } catch (Exception $erro) {
        registrarErro(trim($_SESSION["id"]), $erro->getCode(), "deletar categoria");
        switch ($erro->getCode()) {
            case 1451:
                $_SESSION['resposta'] = "O item que você está deletando está na tabela de vendas!";
                header("Location: ../../admin/categorias/categorias.php");
                exit;
            default:
                $_SESSION['resposta'] = "error" . $erro->getCode();
                header("Location: ../../admin/categorias/categorias.php");
                exit;
        }
    }
} else {
    $_SESSION['resposta'] = "Método de solicitação ínvalido!";
}

header("Location: ../../admin/categorias/categorias.php");
$stmt = null;
exit;
