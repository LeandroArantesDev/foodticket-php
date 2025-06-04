<?php
require_once("../conexao.php");
include("../funcoes.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = strip_tags(trim($_POST["id"]));
    $nome = mb_convert_case(trim(strip_tags($_POST["nome"])), MB_CASE_TITLE, "UTF-8");
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $admin = strip_tags(trim($_POST["admin"]));

    //Verificar token CSRF
    $csrf = trim(strip_tags($_POST["csrf"]));
    if (validarCSRF($csrf) == false) {
        $_SESSION['resposta'] = "Token Inválido";
        header("Location: ../../admin/usuarios/editar_usuario.php");
        exit;
    }

    // Verificar o email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['resposta'] = "Email inválido!";
        header("Location: ../../entrar.php");
        exit;
    }

    //Verificar admin
    if (validarAdmin($admin) == false) {
        $_SESSION['resposta'] = "Campo admin inválido";
        header("Location: ../../admin/usuarios/editar_usuario.php");
        exit;
    }


    //Validar nome
    if (validarNome($nome) == false) {
        $_SESSION['resposta'] = "Digite um nome válido";
        header("Location: ../../registrar.php");
        exit;
    }

    try {
        $update = "UPDATE usuarios SET nome = ?, email ?, admin = ? WHERE id = ?";
        $stmt = $conexao->prepare($update);

        if ($stmt) {
            $stmt->bind_param("sssi", $nome, $email, $admin, $id);
            $resultado = $stmt->execute();
            $stmt->close();

            if (trim($_SESSION["id"]) == $id) {
                $_SESSION['resposta'] = "Usuário editado com sucesso! Logue novamente!";
                header("Location: ../../entrar.php");
                $stmt = null;
                exit;
            } else {
                $_SESSION['resposta'] = "Usuário editado com sucesso!";
                header("Location: ../../admin/usuarios/editar_usuario.php");
                $stmt = null;
                exit;
            }
        } else {
            $_SESSION['resposta'] = "Ocorreu um erro!";
            header("Location: ../../admin/usuarios/editar_usuario.php");
            $stmt = null;
            exit;
        }
    } catch (Exception $erro) {
        registrarErro(trim($_SESSION["id"]), $erro->getCode(), "Editar usuario");
        switch ($erro->getCode()) {
            default:
                $_SESSION['resposta'] = "error" . $erro->getCode();
                header("Location: ../../admin/usuarios/editar_usuario.php");
                exit;
        }
    }
} else {
    $_SESSION['resposta'] = "Método de solicitação ínvalido!";
}

header("Location: ../../admin/usuarios/editar_usuario.php");
$stmt = null;
exit;
