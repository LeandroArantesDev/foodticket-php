<?php
//Verifica se existe uma sessão ativa e se não houver inicia uma
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION["id"]) and !isset($_SESSION["nome"]) and !isset($_SESSION["email"])) {
    session_unset();
    session_destroy();
    header("Location: ../../database/usuario/entrar.php");
    exit();
}

$email = $_SESSION["email"];
$select = "SELECT id, nome, email, admin, status FROM usuarios WHERE email = ?";
$stmt = $conexao->prepare($select);
$stmt->bind_param("s", $email);

if ($stmt->execute()) {
    $stmt->bind_result($id, $nome, $email_db, $admin, $status);
    $stmt->fetch();

    if ((($id === null) || ($nome === null) || ($email_db === null) || ($admin === null)) || $status = 0) {
        session_unset();
        session_destroy();
        header("Location: ../../database/usuario/entrar.php");
        exit();
    } else {
        $_SESSION["id"] = $id;
        $_SESSION["nome"] = $nome;
        $_SESSION["email"] = $email_db;
        $_SESSION["admin"] = $admin;

        if (isset($_SESSION["admin"]) && $_SESSION["admin"] < 1) {
            header("Location: ../../index.php");
            exit();
        }
    }
}
$stmt->close();
