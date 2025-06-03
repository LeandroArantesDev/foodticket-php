<?php
require_once("../conexao.php");
include("../funcoes.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = strip_tags(trim($_POST["nome"]));
    $descricao = strip_tags(trim($_POST["descricao"]));
    $preco = strip_tags(trim($_POST["preco"]));
    $ingredientes = strip_tags(trim($_POST["ingredientes"]));
    $imagem = strip_tags(trim($_POST["imagem"]));
    $id_usuario = strip_tags(trim($_SESSION["id"]));
    $id_categoria = strip_tags(trim($_POST["id_categoria"]));


    //Verificar token CSRF
    $csrf = trim(strip_tags($_POST["csrf"]));
    if (validarCSRF($csrf) == false) {
        $_SESSION['resposta'] = "Token Inválido";
        header("Location: ../../admin/comidas/comidas.php");
        exit;
    }


    $insert = "INSERT INTO comidas (nome, descricao, preco, ingredientes, imagem, id_usuario, id_categoria) VALUE (?,?,?,?,?,?,?)";
    $stmt = $conexao->prepare($insert);

    if ($stmt) {
        $stmt->bind_param("sssssii", $nome, $descricao, $preco, $ingredientes, $imagem, $id_usuario, $id_categoria);
        $resultado = $stmt->execute();
        $stmt->close();

        $_SESSION['resposta'] = "Produto cadastrado com sucesso!";
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
