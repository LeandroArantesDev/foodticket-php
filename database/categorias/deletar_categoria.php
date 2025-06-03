<?php
require_once("../conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = strip_tags(trim($_POST["id_categoria"]));

    $delete = "DELETE FROM categorias WHERE id = ?";
    $stmt = $conexao->prepare($delete);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        $resultado = $stmt->execute();
        $stmt->close();

        $_SESSION['resposta'] = "Categoria deletada com sucesso!";
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
