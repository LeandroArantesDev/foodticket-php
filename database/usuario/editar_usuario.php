<?php
require_once("../conexao.php");
include("../funcoes.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = strip_tags(trim($_POST["id"]));
    $nome = mb_convert_case(trim(strip_tags($_POST["nome"])), MB_CASE_TITLE, "UTF-8");
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $admin = strip_tags(trim($_POST["admin"]));
    $senha = trim(strip_tags($_POST["senha"]));
    $checkbox = isset($_POST["alterarsenha"]) ? trim(strip_tags($_POST["alterarsenha"])) : null;

    //Verificar token CSRF
    $csrf = trim(strip_tags($_POST["csrf"]));
    if (validarCSRF($csrf) == false) {
        $_SESSION['resposta'] = "Token Inválido";
        header("Location: ../../admin/usuarios/usuarios.php");
        exit;
    }

    // Verificar o email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['resposta'] = "Email inválido!";
        header("Location: ../../admin/usuarios/usuarios.php");
        exit;
    }

    //Verificar admin
    if (validarAdmin($admin) == false) {
        $_SESSION['resposta'] = "Campo admin inválido";
        header("Location: ../../admin/usuarios/usuarios.php");
        exit;
    }


    //Validar nome
    if (validarNome($nome) == false) {
        $_SESSION['resposta'] = "Digite um nome válido";
        header("Location: ../../admin/usuarios/usuarios.php");
        exit;
    }

    // Se o checkbox de senha não estiver marcado ignorar essa validação
    if ($checkbox === "on") {
        //Validadar senha
        if (validarSenha($senha) == false) {
            $_SESSION['resposta'] = "Digite uma senha com 8 caracteres, uma letra maiúscula, uma letra minúscula, um número e um caractere especial";
            header("Location: ../../admin/usuarios/usuarios.php");
            exit;
        }
        //Criptografar senha
        $senha_hash = password_hash($senha, PASSWORD_BCRYPT);
    }

    try {
        // Se o checkbox de senha não estiver marcado alterar o UPDATE
        if ($checkbox === "on") {
            $update = "UPDATE usuarios SET nome = ?, email = ?, admin = ?, senha = ? WHERE id = ?";
            $stmt = $conexao->prepare($update);
            $stmt->bind_param("ssssi", $nome, $email, $admin, $senha_hash, $id);
        } else {
            $update = "UPDATE usuarios SET nome = ?, email = ?, admin = ? WHERE id = ?";
            $stmt = $conexao->prepare($update);
            $stmt->bind_param("sssi", $nome, $email, $admin, $id);
        }

        if ($stmt->execute()) {
            if ($_SESSION["id"] == $id) {
                $_SESSION = [];
                session_destroy();
                session_start();
                $_SESSION['resposta'] = "Usuário editado com sucesso! Logue novamente!";
                header("Location: ../../entrar.php");
                $stmt = null;
                exit;
            } else {
                $_SESSION['resposta'] = "Usuário editado com sucesso!";
                header("Location: ../../admin/usuarios/usuarios.php");
                $stmt = null;
                exit;
            }
        } else {
            $_SESSION['resposta'] = "Ocorreu um erro!";
            header("Location: ../../admin/usuarios/usuarios.php");
            $stmt = null;
            exit;
        }
    } catch (Exception $erro) {
        registrarErro(trim($_SESSION["id"]), $erro->getCode(), "Editar usuario");
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
