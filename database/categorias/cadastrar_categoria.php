<?php
include("../funcoes.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = strip_tags(trim($_POST["nome"]));

    //Verificar token CSRF
    $csrf = trim(strip_tags($_POST["csrf"]));
    if (validarCSRF($csrf) == false) {
        $_SESSION['resposta'] = "Token Inválido";
        header("Location: ../../admin/categorias/categorias.php");
        exit;
    }

    try {
        $insert = "INSERT INTO categorias (nome) VALUE (?)";
        $stmt = $conexao->prepare($insert);

        if ($stmt) {
            $stmt->bind_param("s", $nome);
            $resultado = $stmt->execute();
            $stmt->close();

            $_SESSION['resposta'] = "Categoria cadastrada com sucesso!";
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
        registrarErro(trim($_SESSION["id"]), $erro->getCode(), "Cadastrar categoria");
        switch ($erro->getCode()) {
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
