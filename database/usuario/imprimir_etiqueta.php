<?php
require_once("../conexao.php");
include("../funcoes.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_usuario = strip_tags(trim($_POST["idUsuario"]));
    $id_comida = strip_tags(trim($_POST["idComida"]));
    $nome_comida = strip_tags(trim($_POST["nomeComida"]));
    $preco_comida = strip_tags(trim($_POST["precoComida"]));
    $quantidade_comida = strip_tags(trim($_POST["quantidadeComida"]));

    try {
        $insert = "INSERT INTO vendas (id_usuario, id_comida, quantidade, preco_unitario) VALUE (?,?,?,?)";
        $stmt = $conexao->prepare($insert);

        if ($stmt) {
            $stmt->bind_param("iiis", $id_usuario, $id_comida, $quantidade_comida, $preco_comida);
            $resultado = $stmt->execute();
            $stmt->close();
            gerarEtiquetasPDF($nome_comida, $quantidade_comida);
            $_SESSION['resposta'] = "Venda cadastrado com sucesso!";
            $stmt = null;
            exit;
        } else {
            $_SESSION['resposta'] = "Ocorreu um erro!";
            header("Location: ../../index.php");
            $stmt = null;
            exit;
        }
    } catch (Exception $erro) {
        registrarErro(trim($_SESSION["id"]), $erro->getCode(), "Cadastrar comida");
        switch ($erro->getCode()) {
            default:
                $_SESSION['resposta'] = "error" . $erro->getCode();
                header("Location: ../../index.php");
                exit;
        }
    }
} else {
    $_SESSION['resposta'] = "Método de solicitação ínvalido!";
}

header("Location: ../../index.php");
$stmt = null;
exit;
