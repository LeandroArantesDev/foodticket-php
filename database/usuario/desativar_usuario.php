<?php
include("../funcoes.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = strip_tags(trim($_POST["id_usuario"]));
    $status = strip_tags(trim($_POST["status_usuario"]));

    if ($status == 1) {
        $status = 0;
    } else {
        $status = 1;
    }

    try {
        $update = "UPDATE usuarios SET status = ? WHERE id = ?";
        $stmt = $conexao->prepare($update);

        if ($stmt) {
            $stmt->bind_param("si", $status, $id);
            $resultado = $stmt->execute();
            $stmt->close();

            $_SESSION['resposta'] = "Usuário alterado com sucesso!";
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
        registrarErro(trim($_SESSION["id"]), $erro->getCode(), "Desativar usuario");
        switch ($erro->getCode()) {
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
