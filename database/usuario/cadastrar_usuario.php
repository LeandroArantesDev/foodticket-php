<?php
include("../funcoes.php");

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    // Recebendo os dados do formulários de criar usuário
    $nome = mb_convert_case(trim(strip_tags($_POST["nome"])), MB_CASE_TITLE, "UTF-8");
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $senha = trim(strip_tags($_POST["senha"]));
    $confirmarsenha = trim(strip_tags($_POST["confirmarsenha"]));
    $admin = strip_tags(trim($_POST["admin"]));

    // Verificar email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['resposta'] = "Email inválido!";
        header("Location: ../../admin/usuarios/usuarios.php");
        exit;
    }

    //Verificar token CSRF
    $csrf = trim(strip_tags($_POST["csrf"]));
    if (validarCSRF($csrf) == false) {
        $_SESSION['resposta'] = "E-mail ou senha inválidos!";
        header("Location: ../../admin/usuarios/usuarios.php");
        exit;
    }

    //Validadar senha
    if (validarSenha($senha) == false) {
        $_SESSION['resposta'] = "Digite uma senha com 8 caracteres, uma letra maiúscula, uma letra minúscula, um número e um caractere especial";
        header("Location: ../../admin/usuarios/usuarios.php");
        exit;
    }

    //Validar nome
    if (validarNome($nome) == false) {
        $_SESSION['resposta'] = "Digite um nome válido";
        header("Location: ../../admin/usuarios/usuarios.php");
        exit;
    }

    //Verificar admin
    if (validarAdmin($admin) == false) {
        $_SESSION['resposta'] = "Campo admin inválido";
        header("Location: ../../admin/usuarios/usuarios.php");
        exit;
    }

    // Verificar se os dados chegaram com sucesso para continuar
    if (!empty($nome) && !empty($email) && !empty($senha) && !empty($confirmarsenha)) {

        // Verificar se as senhas são iguais e criptografa-la
        if ($senha === $confirmarsenha) {
            $senha_hash = password_hash($senha, PASSWORD_BCRYPT);
        } else {
            $_SESSION['resposta'] = "As senhas não estão iguais!";
            header("Location: ../../admin/usuarios/usuarios.php");
            exit;
        }

        try {

            // Faz a inserção no banco de dados
            $insert = "INSERT INTO usuarios (nome, email, senha, admin) VALUES (?,?,?,?)";

            $stmt = $conexao->prepare($insert);
            $stmt->bind_param("sssi", $nome, $email, $senha_hash, $admin);

            // Se funcionar a inserção no banco ele retorna para a tela do index falando que funcionou, se não ele retorna erro
            if ($stmt->execute()) {
                $_SESSION['resposta'] = "Usuário cadastrado com sucesso!";
                header("Location: ../../admin/usuarios/usuarios.php");
                exit;
            } else {
                $_SESSION['resposta'] = "Usuário deu erro!";
                header("Location: ../../admin/usuarios/usuarios.php");
                exit;
            }
        } catch (Exception $erro) {
            registrarErro(trim($_SESSION["id"]), $erro->getCode(), "Registrar usuário");
            // Caso houver erro ele retorna
            switch ($erro->getCode()) {
                // erro de email duplicado código 1062
                case 1062:
                    $_SESSION['resposta'] = "Email já cadastrado!";
                    header("Location: ../../admin/usuarios/usuarios.php");
                    exit;

                    // erro de quantidade de paramêtros erro
                case 1136:
                    $_SESSION['resposta'] = "Quantidade de dados inseridos inválida!";
                    header("Location: ../../admin/usuarios/usuarios.php");
                    exit;

                default:
                    $_SESSION['resposta'] = "error" . $erro->getCode();
                    header("Location: ../../admin/usuarios/usuarios.php");
                    exit;
            }
        }
    } else {
        $_SESSION['resposta'] = "Variável POST ínvalida!";
    }
} else {
    $_SESSION['resposta'] = "Método de solicitação ínvalido!";
}

header("Location: ../../admin/usuarios/usuarios.php");
$stmt = null;
exit;
