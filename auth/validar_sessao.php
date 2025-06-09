<?php
//Verifica se existe uma sessão ativa e se não houver inicia uma
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION["id"]) and !isset($_SESSION["nome"]) and !isset($_SESSION["email"])) {
    session_unset();
    session_destroy();
    header("Location: /entrar.php");
    exit();
}

if (isset($_SESSION["admin"]) && $_SESSION["admin"] < 1) {
    header("Location: /index.php");
    exit();
}

$email = $_SESSION["email"];
$select = "SELECT id, nome, email, admin FROM usuarios WHERE email = ?";
$stmt = $conexao->prepare($select);
$stmt->bind_param("s", $email);

if ($stmt->execute()) {
    $stmt->bind_result($id, $nome, $email_db, $admin);
    $stmt->fetch();

    if (($id === null) || ($nome === null) || ($email_db === null) || ($admin === null)) {
        session_unset();
        session_destroy();
        header("Location: /entrar.php");
        exit();
    }
}
$stmt->close();
