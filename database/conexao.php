<?php
//Verifica se existe uma sessão ativa e se não houver inicia uma
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function loadEnv($path)
{
    if (!file_exists($path)) {
        throw new Exception("Arquivo não encontrado");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        if (!array_key_exists($name, $_ENV)) {
            $_ENV[$name] = $value;
            putenv("$name=$value");
        }
    }
}
loadEnv(__DIR__ . '/../senhas.env');

if ($_SERVER['HTTP_HOST'] == 'localhost:8000') {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'foodticket';
} else {
    $host = $_ENV['DB_HOST'];
    $username = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASS'];
    $database = $_ENV['DB_NAME'];
}

$conexao = mysqli_connect($host, $username, $password, $database);

if ($conexao->connect_error) {
    die("ERRO! " . $conexao->connect_error);
}
