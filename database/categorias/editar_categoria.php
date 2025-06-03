<?php
require_once("../conexao.php");
include("../funcoes.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = strip_tags(trim($_POST["id"]));
    $nome = strip_tags(trim($_POST["nome"]));

    //Verificar token CSRF
    $csrf = trim(strip_tags($_POST["csrf"]));
    if (validarCSRF($csrf) == false) {
        $_SESSION['resposta'] = "Token Inválido";
        header("Location: ../../admin/categorias/categorias.php");
        exit;
    }

    $update = "UPDATE categorias SET nome = ? WHERE id = ?";
    $stmt = $conexao->prepare($update);

    if ($stmt) {
        $stmt->bind_param("si", $nome, $id);
        $resultado = $stmt->execute();
        $stmt->close();

        $_SESSION['resposta'] = "Categoria editada com sucesso!";
        header("Location: ../../admin/categorias/categorias.php");
        $stmt = null;
        exit;
    } else {
        $_SESSION['resposta'] = "Ocorreu um erro!";
        header("Location: ../../admin/categorias/categorias.php");
        $stmt = null;
        exit;
    }
} else {
    $_SESSION['resposta'] = "Método de solicitação ínvalido!";
}

header("Location: ../../admin/categorias/categorias.php");
$stmt = null;
exit;
