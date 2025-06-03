<?php
require_once("conexao.php");
require_once(__DIR__ . '/../fpdf/fpdf.php');

function buscarComida()
{
    global $conexao;
    $select = "SELECT COUNT(id) FROM comidas";
    $stmt = $conexao->prepare($select);
    $stmt->execute();
    $qComida = 0;
    $stmt->bind_result($qComida);
    $stmt->fetch();
    $stmt = null;

    if ($qComida == '' || $qComida == 0) {
        $qComida = "N/A Cadastrado";
    }

    return ($qComida);
}

function buscarCategoria()
{
    global $conexao;
    $select = "SELECT COUNT(id) FROM categorias";
    $stmt = $conexao->prepare($select);
    $stmt->execute();
    $qCategoria = 0;
    $stmt->bind_result($qCategoria);
    $stmt->fetch();
    $stmt = null;

    if ($qCategoria == '' || $qCategoria == 0) {
        $qCategoria = "N/A Cadastrado";
    }

    return ($qCategoria);
}

function buscarMaisVendido()
{
    global $conexao;
    $select = "SELECT c.nome FROM vendas v JOIN comidas c ON v.id_comida = c.id GROUP BY v.id_comida ORDER BY SUM(v.quantidade) DESC LIMIT 1;";
    $stmt = $conexao->prepare($select);
    $stmt->execute();
    $pMaisVendido = 0;
    $stmt->bind_result($pMaisVendido);
    $stmt->fetch();
    $stmt = null;

    if ($pMaisVendido == '' || $pMaisVendido == 0) {
        $pMaisVendido = "Nenhuma venda";
    }

    return ($pMaisVendido);
}

function buscarTotalVendido()
{
    global $conexao;
    $select = "SELECT FORMAT(SUM(quantidade * preco_unitario), 2, 'pt_BR') FROM vendas";
    $stmt = $conexao->prepare($select);
    $stmt->execute();
    $tVendido = 0;
    $stmt->bind_result($tVendido);
    $stmt->fetch();
    $stmt = null;

    if ($tVendido == '' || $tVendido == null) {
        $tVendido = "Nenhuma venda";
    } else {
        $tVendido = "R$" . $tVendido;
    }

    return ($tVendido);
}

function deletarItem($id, $tabela)
{
    global $conexao;

    // Lista de tabelas permitidas — prevenção contra SQL Injection
    $tabelasPermitidas = ['usuarios', 'comidas', 'categorias', 'vendas', 'itens_venda'];

    if (!in_array($tabela, $tabelasPermitidas)) {
        $_SESSION['resposta'] = "Tabela inválida!";
        return false;
    }

    $query = "DELETE FROM $tabela WHERE id = ?";
    $stmt = $conexao->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        $resultado = $stmt->execute();
        $stmt->close();

        $_SESSION['resposta'] = $resultado ? "Item deletado com sucesso!" : "Erro ao deletar item.";
        return $resultado;
    } else {
        $_SESSION['resposta'] = "Erro na preparação da query.";
        return false;
    }
}

function gerarEtiquetasPDF(string $nome, int $quantidade)
{
    if ($quantidade < 1) $quantidade = 1;

    $width = 43; // caracteres por linha
    $larguraEtiqueta = 80; // mm
    $alturaEtiqueta = 30; // mm

    $pdf = new FPDF("P", "mm", [$larguraEtiqueta, $alturaEtiqueta]);
    $pdf->SetMargins(0, 0, 0);
    $pdf->SetAutoPageBreak(false);

    for ($i = 0; $i < $quantidade; $i++) {
        $pdf->AddPage();
        $pdf->SetFont("Courier", "", 8);

        $borderLine = str_repeat('*', $width);
        $pdf->Cell(0, 3, converte($borderLine), 0, 1, "C");

        printComBorda($pdf, "ARRAIA ETEC", $width);
        printComBorda($pdf, $nome, $width);

        $pdf->Cell(0, 3, converte($borderLine), 0, 1, "C");
    }

    $pdf->Output("I", "etiqueta_" . preg_replace('/[^a-zA-Z0-9]/', '', $nome) . ".pdf");
}

function converte($str)
{
    return mb_convert_encoding($str, 'ISO-8859-1', 'UTF-8');
}

function printComBorda($pdf, $text, $width)
{
    $text = strtoupper($text);
    $textLen = strlen($text);
    $innerWidth = $width - 2;

    if ($textLen > $innerWidth) {
        $text = substr($text, 0, $innerWidth);
        $textLen = strlen($text);
    }

    $leftSpaces = floor(($innerWidth - $textLen) / 2);
    $rightSpaces = $innerWidth - $textLen - $leftSpaces;

    $line = '*' . str_repeat(' ', $leftSpaces) . $text . str_repeat(' ', $rightSpaces) . '*';
    $pdf->Cell(0, 3, converte($line), 0, 1, "C");
}

function buscarNomeUsuário($id)
{
    global $conexao;
    $select = "SELECT nome FROM usuarios WHERE id = ?";
    $stmt = $conexao->prepare($select);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $nUsuario = 0;
    $stmt->bind_result($nUsuario);
    $stmt->fetch();
    $stmt = null;

    if ($nUsuario == '' || $nUsuario == null) {
        $nUsuario = "N/A Cadastrado";
    }

    return ($nUsuario);
}

function buscarNomeComida($id)
{
    global $conexao;
    $select = "SELECT nome FROM comidas WHERE id = ?";
    $stmt = $conexao->prepare($select);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $nComida = 0;
    $stmt->bind_result($nComida);
    $stmt->fetch();
    $stmt = null;

    if ($nComida == '' || $nComida == null) {
        $nComida = "N/A Cadastrado";
    }

    return ($nComida);
}

function gerarCSRF()
{
    $_SESSION["csrf"] = (isset($_SESSION["csrf"])) ? $_SESSION["csrf"] : hash('sha256', random_bytes(32));

    return ($_SESSION["csrf"]);
}

function validarCSRF($csrf)
{
    if (!isset($_SESSION["csrf"])) {
        return (false);
    }
    if ($_SESSION["csrf"] !== $csrf) {
        return (false);
    }
    if (!hash_equals($_SESSION["csrf"], $csrf)) {
        return (false);
    }

    return (true);
}

function validarNome($nome)
{
    // Remove espaços no início/fim e valida com regex
    $nome = trim($nome);

    // Regex: letras (com acento), espaço, mínimo 3 e máximo 50 caracteres
    if (!preg_match('/^[\p{L} ]{3,50}$/u', $nome)) {
        return false;
    }

    return true;
}


function validarSenha($senha)
{
    // Pelo menos 8 caracteres, uma letra maiúscula, uma letra minúscula, um número e um caractere especial
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $senha)) {
        return false;
    }

    return true;
}

function formatarPreco($numero)
{
    return 'R$ ' . number_format($numero, 2, ',', '.');
}


function registrarErro($id_usuario, $erro, $origem)
{
    global $conexao;
    $insert = "INSERT INTO erros (id_usuario, erro, origem) VALUES (?,?,?)";
    $stmt = $conexao->prepare($insert);
    $stmt->bind_param("iss", $id_usuario, $erro, $origem);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
