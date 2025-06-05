<?php
require_once("../conexao.php");
include("../funcoes.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["itens"])) {
    $itens = json_decode($_POST["itens"], true);

    if (!is_array($itens) || count($itens) === 0) {
        $_SESSION['resposta'] = "Nenhum item no carrinho!";
        header("Location: ../../index.php");
        exit;
    }

    $id_usuario = isset($_SESSION["id"]) ? intval($_SESSION["id"]) : null;

    foreach ($itens as $item) {
        $id_comida = intval($item["id"]);
        $nome_comida = strip_tags($item["nome"]);
        $preco_comida = floatval($item["preco"]);
        $quantidade_comida = intval($item["quantidade"]);

        // Salva a venda
        try {
            $insert = "INSERT INTO vendas (id_usuario, id_comida, quantidade, preco_unitario) VALUES (?,?,?,?)";
            $stmt = $conexao->prepare($insert);

            if ($stmt) {
                $stmt->bind_param("iiid", $id_usuario, $id_comida, $quantidade_comida, $preco_comida);
                $stmt->execute();
                $stmt->close();
            }
        } catch (Exception $erro) {
            registrarErro($id_usuario, $erro->getCode(), "Cadastrar venda");
            $_SESSION['resposta'] = "Erro ao registrar venda: " . $erro->getMessage();
            header("Location: ../../index.php");
            exit;
        }
    }

    // Gera todas as etiquetas em um único PDF
    gerarEtiquetasPDF($itens);

    exit;
} else {
    $_SESSION['resposta'] = "Método de solicitação inválido!";
    header("Location: ../../index.php");
    exit;
}
