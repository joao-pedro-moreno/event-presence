<?php 
    include('../../php/connection.php');

    if (isset($_POST['register-user']) || isset($_POST['register-email']) || isset($_POST['register-password']) || isset($_POST['register-confirm-password'])) {
        if (strlen($_POST['register-user']) == 0 || strlen($_POST['register-email']) == 0 || strlen($_POST['register-password']) == 0 || strlen($_POST['register-confirm-password']) == 0) {
            $_SESSION['notify_type'] = "error";
            $_SESSION['notify_message'] = "Insira valores válidos";
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

                    header("Location: ../user/profile.php");
                } else {
                    $_SESSION['notify_type'] = "error";
                    $_SESSION['notify_message'] = "Senhas não coincidem";
                }
            } else {
                $_SESSION['notify_type'] = "error";
                $_SESSION['notify_message'] = "Email já cadastrado";
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
    <link rel="stylesheet" href="../../styles/home.css">
    <link rel="stylesheet" href="../../styles/notify.css">
    <link rel="stylesheet" href="../../styles/components/header.css">
    <link rel="stylesheet" href="../../styles/components/connectForm.css">

    <!-- Importação Favicon -->
    <link rel="shortcut icon" href="../../../assets/favicon.ico" type="image/x-icon">

    <!-- Importação lib de ícones -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Criar conta</title>
</head>
<body>
    <?php
        $indexLink = '../../../index.php';
        $eventFeedLink = '../eventFeed.php';
        $aboutLink = '../about.php';
        $contactLink = '../contact.php';
        $loginLink = '../connect/login.php';
        $profileLink = '../user/profile.php';
        $assetsRoute = '../../../assets/uploads/';

        global $indexLink, $eventFeedLink, $aboutLink, $contactLink, $loginLink, $profileLink, $assetsRoute;

        include('../../php/header.php');
    ?>

    <main>
        <section class="connect-form-page">
            <section>
                <h2 class="index-subtitle">Crie sua conta para administrar seus eventos</h2>
            
                <img src="../../../assets/ball.svg" alt="" class="index-image">
            </section>
            
            <form action="#" method="POST">
                <fieldset>
                    <legend>Criar conta</legend>
            
                    <label for="register-user">Usuário</label>
                    <input type="text" name="register-user" id="register-user" class="connect-input" required>
            
                    <label for="register-email">Email</label>
                    <input type="email" name="register-email" id="register-email" class="connect-input" required>
            
                    <label for="register-password">Senha</label>
                    <input type="password" name="register-password" id="register-password" class="connect-input" required>
            
                    <label for="register-confirm-password">Confirmar Senha</label>
                    <input type="password" name="register-confirm-password" id="register-confirm-password" class="connect-input" required>
            
                    <input type="submit" value="Criar conta" class="connect-submit">
            
                    <span class="redirect-connect">Já possui uma conta? <a href="./login.php" class="redirect-connect-link">Faça login</a></span>
                </fieldset>
            </form>
        </section>
    </main>

    <section class="notify-section"></section>

    <script src="../../js/notify.js"></script>
    <script>
        createNotify("<?php echo $_SESSION['notify_type']; unset($_SESSION['notify_type']); ?>", "<?php echo $_SESSION['notify_message']; unset($_SESSION['notify_message']); ?>", 5)
    </script>
</body>
</html>