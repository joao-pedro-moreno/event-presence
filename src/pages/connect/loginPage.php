<?php
    include('../../php/connection.php');

    if (isset($_POST['login-email']) || isset($_POST['login-password'])) {
        if (strlen($_POST['login-email']) == 0 || strlen($_POST['login-password']) == 0) {
            echo "Insira valores válidos";
        } else {
            $email = $mysqli->real_escape_string($_POST['login-email']);
            $password = $mysqli->real_escape_string($_POST['login-password']);

            $sql_code = "SELECT * FROM `users` WHERE `email` = '$email' LIMIT 1";
            $sql_query = $mysqli->query($sql_code) or die("Falha ao executar o código SQL: " . $mysqli->error);

            $user = $sql_query->fetch_assoc();

            if (password_verify($password, $user['pass'])) {
                if (!isset($_SESSION)) {
                    session_start();
                }

                $_SESSION['user'] = $user;

                header("Location: ../user/profilePage.php");
            } else {
                echo "Falha ao se conectar! Email ou senha incorretos";
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

    <title>Login</title>
</head>
<body>
    <header>
        <h1 class="header-title"><a href="../../../index.html" class="index-redirect">Event Presence</a></h1>

        <nav>
            <a href="../eventFeedPage.php" class="header-links">Eventos</a>
            <a href="../aboutPage.html" class="header-links">Sobre</a>
            <a href="../contactPage.html" class="header-links">Contato</a>
            <a href="./registerPage.php" id="connect-redirect">Não possui uma conta?</a>
        </nav>
    </header>

    <main>
        <section>
            <h2 class="content-subtitle">Conecte-se para administrar seus eventos</h2>

            <img src="../../../assets/ball.svg" alt="" class="main-image">
        </section>

        <form action="#" method="POST">
            <fieldset>
                <legend>Login</legend>

                <label for="login-email">Email</label>
                <input type="email" name="login-email" id="login-email" class="connect-input" required>

                <label for="login-password">Senha</label>
                <input type="password" name="login-password" id="login-password" class="connect-input" required>

                <a href="./forgotPassword.php" class="forgot-password">Esqueceu a senha?</a>

                <input type="submit" value="Logar" class="submit-button">

                <span class="form-redirect">Não possui uma conta? <a href="./registerPage.php" class="form-redirect-link">Registre-se</a></span>
            </fieldset>
        </form>
    </main>
</body>
</html>