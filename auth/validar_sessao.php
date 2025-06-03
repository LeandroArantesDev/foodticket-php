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

if (isset($_SESSION["admin"]) && $_SESSION["admin"] == 0) {
    header("Location: /index.php");
    exit();
}
