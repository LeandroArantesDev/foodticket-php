<?php
require_once("../conexao.php");
include("../funcoes.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = strip_tags(trim($_POST["id"]));
    $nome = strip_tags(trim($_POST["nome"]));
    $descricao = strip_tags(trim($_POST["descricao"]));
    $preco = strip_tags(trim($_POST["preco"]));
    $ingredientes = strip_tags(trim($_POST["ingredientes"]));
    $imagem = strip_tags(trim($_POST["imagem"]));

    //Verificar token CSRF
    $csrf = trim(strip_tags($_POST["csrf"]));
    if (validarCSRF($csrf) == false) {
        $_SESSION['resposta'] = "Token Inválido";
        header("Location: ../../admin/comidas/comidas.php");
        exit;
    }

    $update = "UPDATE comidas SET nome = ?, descricao = ?, preco = ?, ingredientes = ?, imagem = ? WHERE id = ?";
    $stmt = $conexao->prepare($update);

    if ($stmt) {
        $stmt->bind_param("sssssi", $nome, $descricao, $preco, $ingredientes, $imagem, $id);
        $resultado = $stmt->execute();
        $stmt->close();

        $_SESSION['resposta'] = "Item editado com sucesso!";
        header("Location: ../../admin/comidas/comidas.php");
        $stmt = null;
        exit;
    } else {
        $_SESSION['resposta'] = "Ocorreu um erro!";
        header("Location: ../../admin/comidas/comidas.php");
        $stmt = null;
        exit;
    }
} else {
    $_SESSION['resposta'] = "Método de solicitação ínvalido!";
}

header("Location: ../../admin/comidas/comidas.php");
$stmt = null;
exit;
