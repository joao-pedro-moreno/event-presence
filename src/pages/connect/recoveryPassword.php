<?php
    session_start();

    if (isset($_SESSION['user'])) {
        header("Location: ../user/profile.php");
    }

    include('../../php/connection.php');

    if (isset($_POST['recovery-email'])) {
        if (strlen($_POST['recovery-email']) == 0) {
            $_SESSION['notify_type'] = "error";
            $_SESSION['notify_message'] = "Insira valores válidos";
        } else {
            $email = $mysqli->real_escape_string($_POST['recovery-email']);

            $sql_code = "SELECT 'email' FROM `users` WHERE `email` = '$email' LIMIT 1";
            $sql_query = $mysqli->query($sql_code) or die("Falha ao executar o código SQL: " . $mysqli->error);

            if ($sql_query->num_rows > 0) {
                $token = md5(time());

                if (mail($email, "Solicitação para alterar senha", "Link para alterar senha https://devs.nexusnx.com/moreno/event-presence/src/pages/connect/changePassword.php?token=$token")) {
                    $recovery_token_sql_code = "INSERT INTO `recovery_password`(`email`, `token`) VALUES ('$email','$token')";
                    $recovery_token_sql_query = $mysqli->query($recovery_token_sql_code) or die("Falha ao executar código SQL: " . $mysqli->error);
                
                    $_SESSION['notify_type'] = "success";
                    $_SESSION['notify_message'] = "Caso o e-mail informado seja válido, você receberá um link de recuperação. Cheque sua caixa de entrada (e spam).";
                } else {
                    $_SESSION['notify_type'] = "success";
                    $_SESSION['notify_message'] = "Caso o e-mail informado seja válido, você receberá um link de recuperação. Cheque sua caixa de entrada (e spam).";
                }

            } else {
                $_SESSION['notify_type'] = "success";
                $_SESSION['notify_message'] = "Caso o e-mail informado seja válido, você receberá um link de recuperação. Cheque sua caixa de entrada (e spam).";
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

    <title>Recuperação de Senha</title>
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
        <section id="recovery-password-page">
            <form action="#" method="POST">
                <fieldset>
                    <legend>Recuperar Senha</legend>
            
                    <label for="recovery-email">Email</label>
                    <input type="email" name="recovery-email" id="recovery-email" class="connect-input" required>
            
                    <input type="submit" value="Recuperar" class="connect-submit">
                    <a href="./login.php" class="cancel">Cancelar</a>
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