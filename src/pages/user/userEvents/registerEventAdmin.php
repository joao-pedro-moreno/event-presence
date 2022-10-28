<?php
    include('../../../php/connection.php');
    include('../../../php/protect.php');

    if (isset($_GET['e'])) {
        $event_id = $_GET['e'];

        if (isset($_POST['admin-email'])) {
            if (strlen($_POST['admin-email']) == 0) {
                echo "Insira um valor válido";
            } else {
                $email = $mysqli->real_escape_string($_POST['admin-email']);

                $sql_admin_verification_code = "SELECT `event_id`, `email` FROM `admins` WHERE event_id = $event_id AND email = '$email'";
                $sql_admin_verification_query = $mysqli->query($sql_admin_verification_code) or die("Falha ao executar código SQL: " . $mysqli->error);

                if ($sql_admin_verification_query->num_rows > 0) {
                    echo "Admin já registrado";
                } else {
                    $sql_code = "INSERT INTO `admins`(`event_id`, `email`) VALUES ('$event_id','$email')";
                    $sql_query = $mysqli->query($sql_code) or die("Falha ao executar o código SQL: " . $mysqli->error);

                    header("Location: manageEventPage.php?e=$event_id");
                }
            }
        }

    } else {
        header("Location: ../../../../index.html");
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
    <link rel="stylesheet" href="../../../styles/components/header.css">

    <!-- Importação Favicon -->
    <link rel="shortcut icon" href="../../../../assets/favicon.ico" type="image/x-icon">
        
    <title>Editar evento</title>
</head>
<body>
    <header>
        <h1 class="header-title"><a href="../../../../index.html" class="index-redirect">Event Presence</a></h1>

        <nav>
            <a href="../../eventFeedPage.php" class="header-links">Eventos</a>
            <a href="../../aboutPage.html" class="header-links">Sobre</a>
            <a href="../../contactPage.html" class="header-links">Contato</a>
            <a href="../../connect/loginPage.php" id="connect-redirect">Já possui uma conta?</a>
        </nav>
    </header>

    <main>
        <form action="#" method="POST">
            <fieldset>
                <legend>Registrar Administrador</legend>

                <label for="admin-email">Email</label>
                <input type="email" name="admin-email" id="admin-email" class="register-admin-input">

                <input type="submit" value="Adicionar Administrador" class="submit-button">
                <a href="./manageEventPage.php" class="cancel-admin">Cancelar Alterações</a>
            </fieldset>
        </form>
    </main>
</body>
</html>