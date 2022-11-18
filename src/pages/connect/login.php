<?php
    session_start();

    if (isset($_SESSION['user'])) {
        header("Location: ../user/profile.php");
    }

    include('../../php/connection.php'); 


    if (isset($_POST['login-email']) && isset($_POST['login-password'])) {
        if (strlen($_POST['login-email']) == 0 || strlen($_POST['login-password']) == 0) {
            $_SESSION['notify_type'] = "error";
            $_SESSION['notify_message'] = "Insira valores válidos";
        } else {
            $email = $mysqli->real_escape_string($_POST['login-email']);
            $password = $mysqli->real_escape_string($_POST['login-password']);

            $sql_code = "SELECT * FROM `users` WHERE `email` = '$email' LIMIT 1";
            $sql_query = $mysqli->query($sql_code) or die("Falha ao executar o código SQL: " . $mysqli->error);

            $user = $sql_query->fetch_assoc();

            if ($sql_query->num_rows > 0) {
                if (password_verify($password, $user['pass'])) {
                    if (!isset($_SESSION)) {
                        session_start();
                    }
    
                    $_SESSION['user'] = $user;
    
                    header("Location: ../user/profile.php");
                } else {
                    $_SESSION['notify_type'] = "error";
                    $_SESSION['notify_message'] = "Email ou senha incorretos";
                }
            } else {
                $_SESSION['notify_type'] = "error";
                $_SESSION['notify_message'] = "Email ou senha incorretos";
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

    <title>Login</title>
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
                <h2 class="index-subtitle">Conecte-se para administrar seus eventos</h2>

                <img src="../../../assets/ball.svg" alt="" class="index-image">
            </section>

            <form action="#" method="POST">
                <fieldset>
                    <legend>Login</legend>

                    <label for="login-email">Email</label>
                    <input type="email" name="login-email" id="login-email" class="connect-input" required>

                    <label for="login-password">Senha</label>
                    <input type="password" name="login-password" id="login-password" class="connect-input" required>

                    <a href="./recoveryPassword.php" class="forgot-password">Esqueceu a senha?</a>

                    <input type="submit" value="Logar" class="connect-submit">

                    <span class="redirect-connect">Não possui uma conta? <a href="./register.php" class="redirect-connect-link">Registre-se</a></span>
                </fieldset>
            </form>
        </section>
    </main>

    <section class="notify-section"></section>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="../../js/jquery.btechco.excelexport.js"></script>
    <script src="../../js/jquery.base64.js"></script>

    <script src="../../js/notify.js"></script>

    <?php
        if (isset($_SESSION['notify_type'])) {
    ?>
        <script>
            createNotify("<?php echo $_SESSION['notify_type']; unset($_SESSION['notify_type']); ?>", "<?php echo $_SESSION['notify_message']; unset($_SESSION['notify_message']); ?>", 5)
        </script>
    <?php
        }
    ?>
</body>
</html>