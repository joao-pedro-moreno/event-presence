<?php
    session_start();

    if (isset($_SESSION['user'])) {
        header("Location: ../user/profile.php");
    }

    if (!isset($_GET['token'])) {
        header("Location: ./login.php");
    } else {
        include('../../php/connection.php');

        $token = $_GET['token'];

        $sql_code = "SELECT * FROM `recovery_password` WHERE token = '$token'";
        $sql_query = $mysqli->query($sql_code) or die("Falha ao executar código SQL: " . $mysqli->error);

        $recovery_information = $sql_query->fetch_assoc();

        if ($sql_query->num_rows > 0) {
            $email = $recovery_information['email'];
    
            if (isset($_POST['change-password']) && isset($_POST['confirm-change-password'])) {
                if (strlen($_POST['change-password']) == 0 || strlen($_POST['confirm-change-password']) == 0) {
                    $_SESSION['notify_type'] = "error";
                    $_SESSION['notify_message'] = "Insira valores válidos";
                } else {
                    $new_password = $mysqli->real_escape_string($_POST['change-password']);
                    $confirm_new_password = $mysqli->real_escape_string($_POST['confirm-change-password']);
    
                    if ($new_password != $confirm_new_password) {
                        $_SESSION['notify_type'] = "error";
                        $_SESSION['notify_message'] = "As senhas são diferentes";
                    } else {
                        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                        
                        $update_password_sql_code = "UPDATE `users` SET `pass`='$new_password_hash' WHERE email = '$email'";
                        $update_password_sql_query = $mysqli->query($update_password_sql_code) or die("Falha ao executar código SQL: " . $mysqli->error);
    
                        $_SESSION['notify_type'] = "success";
                        $_SESSION['notify_message'] = "Senha alterada com sucesso";
    
                        $delete_token_sql_code = "DELETE FROM `recovery_password` WHERE token = '$token'";
                        $delete_token_sql_query = $mysqli->query($delete_token_sql_code) or die("Falha ao executar código SQL: " . $mysqli->error);
    
                        header("Location: ./login.php");
                    }
                }
            }
        } else {
            header("Location: ./login.php");
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
                    <legend>Trocar senha</legend>
            
                    <label for="change-password">Nova senha</label>
                    <input type="password" name="change-password" id="change-password" class="connect-input" required>

                    <label for="confirm-change-password">Confirmar nova senha</label>
                    <input type="password" name="confirm-change-password" id="confirm-change-password" class="connect-input" required>
            
                    <input type="submit" value="Trocar senha" class="connect-submit">
                    <a href="./login.php" class="cancel">Cancelar</a>
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