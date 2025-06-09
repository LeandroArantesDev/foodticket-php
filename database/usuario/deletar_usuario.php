<?php
include("../funcoes.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = strip_tags(trim($_POST["id_usuario"]));

    $delete = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conexao->prepare($delete);
    try {
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $resultado = $stmt->execute();
            $stmt->close();

            $_SESSION['resposta'] = "Usuário deletado com sucesso!";
            header("Location: ../../admin/usuarios/usuarios.php");
            $stmt = null;
            exit;
        } else {
            $_SESSION['resposta'] = "Ocorreu um erro!";
            header("Location: ../../admin/usuarios/usuarios.php");
            $stmt = null;
            exit;
        }
    } catch (Exception $erro) {
        registrarErro(trim($_SESSION["id"]), $erro->getCode(), "deletar usuario");
        switch ($erro->getCode()) {
            case 1451:
                $_SESSION['resposta'] = "O usuário que você está deletando está sendo usado em algum lugar!";
                header("Location: ../../admin/usuarios/usuarios.php");
                exit;
            default:
                $_SESSION['resposta'] = "error" . $erro->getCode();
                header("Location: ../../admin/usuarios/usuarios.php");
                exit;
        }
    }
} else {
    $_SESSION['resposta'] = "Método de solicitação ínvalido!";
}

header("Location: ../../admin/usuarios/usuarios.php");
$stmt = null;
exit;
