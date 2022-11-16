<?php
    session_start();

    include('../../../php/connection.php');
    include('../../../php/protect.php');

    if (isset($_GET['e'])) {
        $event_id = $_GET['e'];

        $user = $_SESSION['user'];
        $owner_email = $user['email'];

        $sql_owner_verification_code = "SELECT `id`, `owner_email` FROM `events` WHERE id = $event_id AND owner_email = '$owner_email'";
        $sql_owner_verification_query = $mysqli->query($sql_owner_verification_code) or die("Falha ao executar código SQL: " . $mysqli->error);

        if ($sql_owner_verification_query->num_rows > 0) {
            if (isset($_POST['admin-email'])) {
                if (strlen($_POST['admin-email']) == 0) {
                    $_SESSION['notify_type'] = "error";
                    $_SESSION['notify_message'] = "Insira valores válidos";
                } else {
                    $email = $mysqli->real_escape_string($_POST['admin-email']);
    
                    $sql_admin_verification_code = "SELECT `event_id`, `email` FROM `admins` WHERE event_id = $event_id AND email = '$email'";
                    $sql_admin_verification_query = $mysqli->query($sql_admin_verification_code) or die("Falha ao executar código SQL: " . $mysqli->error);
    
                    if ($sql_admin_verification_query->num_rows > 0) {
                        $_SESSION['notify_type'] = "error";
                        $_SESSION['notify_message'] = "Admin já registrado";
                    } else {
                        $sql_code = "INSERT INTO `admins`(`event_id`, `email`) VALUES ('$event_id','$email')";
                        $sql_query = $mysqli->query($sql_code) or die("Falha ao executar o código SQL: " . $mysqli->error);
    
                        header("Location: manageEvent.php?e=$event_id");
                    }
                }
            }
        } else {
            header("Location: manageEvent.php?e=$event_id");
        }
    } else {
        header("Location: ../../../../index.php");
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Importação de estilos -->
    <link rel="stylesheet" href="../../../styles/config.css">
    <link rel="stylesheet" href="../../../styles/createEvent.css">
    <link rel="stylesheet" href="../../../styles/notify.css">
    <link rel="stylesheet" href="../../../styles/components/header.css">

    <!-- Importação Favicon -->
    <link rel="shortcut icon" href="../../../../assets/favicon.ico" type="image/x-icon">

    <!-- Importação lib de ícones -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        
    <title>Editar evento</title>
</head>
<body>
    <?php
        $indexLink = '../../../../index.php';
        $eventFeedLink = '../../eventFeed.php';
        $aboutLink = '../../about.php';
        $contactLink = '../../contact.php';
        $loginLink = '../../connect/login.php';
        $profileLink = '../../user/profile.php';
        $assetsRoute = '../../../../assets/uploads/';

        global $indexLink, $eventFeedLink, $aboutLink, $contactLink, $loginLink, $profileLink, $assetsRoute;

        include('../../../php/header.php');
    ?>

    <main>
        <section id="register-admin-page">
            <form action="#" method="POST">
                <fieldset>
                    <legend>Registrar Administrador</legend>
                    <label for="admin-email">Email</label>
                    <input type="email" name="admin-email" id="admin-email" class="register-admin-input">
                    <input type="submit" value="Adicionar Administrador" class="submit-button">
                    <a href="./manageEvent.php?e=<?php echo $event_id; ?>" class="cancel">Cancelar Alterações</a>
                </fieldset>
            </form>
        </section>
    </main>

    <section class="notify-section"></section>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="../../../js/jquery.btechco.excelexport.js"></script>
    <script src="../../../js/jquery.base64.js"></script>

    <script src="../../../js/notify.js"></script>
    <script>
        createNotify("<?php echo $_SESSION['notify_type']; unset($_SESSION['notify_type']); ?>", "<?php echo $_SESSION['notify_message']; unset($_SESSION['notify_message']); ?>", 5)
    </script>
</body>
</html>