<?php
include("../funcoes.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = strip_tags(trim($_POST["id_comida"]));

    $delete = "DELETE FROM comidas WHERE id = ?";
    $stmt = $conexao->prepare($delete);
    try {
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $resultado = $stmt->execute();
            $stmt->close();

            $_SESSION['resposta'] = "Item deletado com sucesso!";
            header("Location: ../../admin/comidas/comidas.php");
            $stmt = null;
            exit;
        } else {
            $_SESSION['resposta'] = "Ocorreu um erro!";
            header("Location: ../../admin/comidas/comidas.php");
            $stmt = null;
            exit;
        }
    } catch (Exception $erro) {
        registrarErro(trim($_SESSION["id"]), $erro->getCode(), "deletar comida");
        switch ($erro->getCode()) {
            case 1451:
                $_SESSION['resposta'] = "O item que você está deletando está na tabela de vendas!";
                header("Location: ../../admin/comidas/comidas.php");
                exit;
            default:
                $_SESSION['resposta'] = "error" . $erro->getCode();
                header("Location: ../../admin/comidas/comidas.php");
                exit;
        }
    }
} else {
    $_SESSION['resposta'] = "Método de solicitação ínvalido!";
}

header("Location: ../../admin/comidas/comidas.php");
$stmt = null;
exit;
