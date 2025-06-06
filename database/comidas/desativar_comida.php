<?php
require_once("../conexao.php");
include("../funcoes.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = strip_tags(trim($_POST["id_comida"]));
    $status = strip_tags(trim($_POST["status_comida"]));

    if ($status == 1) {
        $status = 0;
    } else {
        $status = 1;
    }

    try {
        $update = "UPDATE comidas SET status = ? WHERE id = ?";
        $stmt = $conexao->prepare($update);

        if ($stmt) {
            $stmt->bind_param("si", $status, $id);
            $resultado = $stmt->execute();
            $stmt->close();

            $_SESSION['resposta'] = "Comida alterada com sucesso!";
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
        registrarErro(trim($_SESSION["id"]), $erro->getCode(), "Desativar comida");
        switch ($erro->getCode()) {
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
