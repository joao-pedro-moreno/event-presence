<?php 
    include('../../php/connection.php');

    if (isset($_POST['register-user']) || isset($_POST['register-email']) || isset($_POST['register-password']) || isset($_POST['register-confirm-password'])) {
        if (strlen($_POST['register-user']) == 0 || strlen($_POST['register-email']) == 0 || strlen($_POST['register-password']) == 0 || strlen($_POST['register-confirm-password']) == 0) {
            echo "Insira valores válidos";
        } else {
            $user = $mysqli->real_escape_string($_POST['register-user']);
            $email = $mysqli->real_escape_string($_POST['register-email']);
            $password = $mysqli->real_escape_string($_POST['register-password']);
            $confirm_password = $mysqli->real_escape_string($_POST['register-confirm-password']);
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $sql_email_verification_code = "SELECT `email` FROM `users` WHERE `email` = '$email' LIMIT 1";
            $sql_email_verification_exec = $mysqli->query($sql_email_verification_code) or die("Falha ao executar código SQL: " . $mysqli->error);
            $email_verification = $sql_email_verification_exec->fetch_assoc();

            if (empty($email_verification)) {
                if ($password == $confirm_password) {
                    $sql_register_user_code = "INSERT INTO users(user,email,pass) VALUES ('$user','$email','$password_hash')";
                    $sql_query = $mysqli->query($sql_register_user_code) or die("Falha ao executar código SQL: " . $mysqli->error);

                    $sql_session_code = "SELECT * FROM `users` WHERE `email` = '$email' LIMIT 1";
                    $sql_session_query = $mysqli->query($sql_session_code) or die("Falha ao executar o código SQL: " . $mysqli->error);

                    $user = $sql_session_query->fetch_assoc();

                    if (!isset($_SESSION)) {
                        session_start();
                    }
    
                    $_SESSION['user'] = $user;

                    header("Location: ../user/profilePage.php");
                } else {
                    echo "Suas senhas são diferentes";
                }
            } else {
                echo "Email já cadastrado";
            }

        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Importação de estilos -->
    <link rel="stylesheet" href="../../styles/config.css">
    <link rel="stylesheet" href="../../styles/defaultPage.css">
    <link rel="stylesheet" href="../../styles/components/header.css">
    <link rel="stylesheet" href="../../styles/components/connectForm.css">

    <!-- Importação Favicon -->
    <link rel="shortcut icon" href="../../../assets/favicon.ico" type="image/x-icon">

    <title>Criar conta</title>
</head>
<body>
    <header>
        <h1 class="header-title"><a href="../../../index.html" class="index-redirect">Event Presence</a></h1>

        <nav>
            <a href="../eventFeedPage.php" class="header-links">Eventos</a>
            <a href="../aboutPage.html" class="header-links">Sobre</a>
            <a href="../contactPage.html" class="header-links">Contato</a>
            <a href="./loginPage.php" id="connect-redirect">Já possui uma conta?</a>
        </nav>
    </header>

    <main>
        <section>
            <h2 class="content-subtitle">Crie sua conta para administrar seus eventos</h2>

            <img src="../../../assets/ball.svg" alt="" class="main-image">
        </section>

        <form action="#" method="POST">
            <fieldset>
                <legend>Criar conta</legend>

                <label for="register-user">Usuário</label>
                <input type="text" name="register-user" id="register-user" class="connect-input" required>

                <label for="register-email">Email</label>
                <input type="email" name="register-email" id="register-email" class="connect-input" required>

                <label for="register-password">Senha</label>
                <input type="password" name="register-password" id="register-password" class="connect-input" required onkeyup="verifyPassword()">

                <label for="register-confirm-password">Confirmar Senha</label>
                <input type="password" name="register-confirm-password" id="register-confirm-password" class="connect-input" required onkeyup="verifyPassword()">

                <input type="submit" value="Criar conta" class="submit-button">

                <span class="form-redirect">Já possui uma conta? <a href="./loginPage.php" class="form-redirect-link">Faça login</a></span>
            </fieldset>
        </form>
    </main>
</body>
</html>