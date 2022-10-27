<?php   
    include('../../../php/connection.php');
    include('../../../php/protect.php');

    if (isset($_POST['event-name']) || isset($_POST['event-desc']) || isset($_POST['event-ticket']) || isset($_POST['event-attraction']) || isset($_POST['event-address']) || isset($_POST['event-date']) || isset($_POST['event-hour-start']) || isset($_POST['event-hour-end']) || isset($_FILES['event-banner']) || isset($_POST['event-capacity']) || isset($_POST['event-age']) || isset($_POST['event-rules']) || isset($_POST['event-email']) || isset($_POST['event-tel'])) {
        if (strlen($_POST['event-name']) || strlen($_POST['event-desc']) || strlen($_POST['event-ticket']) || strlen($_POST['event-attraction']) || strlen($_POST['event-address']) || strlen($_POST['event-date']) || strlen($_POST['event-hour-start']) || strlen($_POST['event-hour-end']) || strlen($_POST['event-capacity']) || strlen($_POST['event-age']) || strlen($_POST['event-rules']) || strlen($_POST['event-email']) || strlen($_POST['event-tel'])) {

            $event_banner = $_FILES['event-banner'];

            if ($event_banner['error']) {
                die("Falha ao enviar arquivo");
            }

            $dir = "../../../../assets/uploads/";
            $new_file_name = uniqid();
            $extension = strtolower(pathinfo($event_banner['name'], PATHINFO_EXTENSION));

            if ($extension != "jpg" && $extension != "png" && $extension != "jpeg") {
                die("Tipo de arquivo não aceito");
            }

            $right_extension = move_uploaded_file($event_banner['tmp_name'], $dir . $new_file_name . "." . $extension);
            $file_path = $new_file_name . "." . $extension;

            $user = $_SESSION['user'];
            
            $owner_email = $user['email'];
            $event_name = $mysqli->real_escape_string($_POST['event-name']);
            $event_desc = $mysqli->real_escape_string($_POST['event-desc']);
            $event_ticket = $mysqli->real_escape_string($_POST['event-ticket']);
            $event_attraction = $mysqli->real_escape_string($_POST['event-attraction']);
            $event_address = $mysqli->real_escape_string($_POST['event-address']);
            $event_date = $mysqli->real_escape_string($_POST['event-date']);
            $event_hour_start = $mysqli->real_escape_string($_POST['event-hour-start']);
            $event_hour_end = $mysqli->real_escape_string($_POST['event-hour-end']);
            $event_capacity = $mysqli->real_escape_string($_POST['event-capacity']);
            $event_age = $mysqli->real_escape_string($_POST['event-age']);
            $event_rules = $mysqli->real_escape_string($_POST['event-rules']);
            $event_email = $mysqli->real_escape_string($_POST['event-email']);
            $event_tel = $mysqli->real_escape_string($_POST['event-tel']);

            $sql_code = "INSERT INTO `events`(`owner_email`, `name`, `description`, `ticket`, `attractions`, `address`, `date`, `hour_start`, `hour_end`,`capacity`, `age`, `rules`, `contact_email`, `contact_tel`, `banner`) VALUES ('$owner_email','$event_name','$event_desc', '$event_ticket','$event_attraction','$event_address','$event_date','$event_hour_start','$event_hour_end','$event_capacity','$event_age','$event_rules','$event_email','$event_tel', '$file_path')";
            $sql_query = $mysqli->query($sql_code) or die("Falha ao executar código SQL: " . $mysqli->error);

            header("Location: ../profilePage.php");
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
    <link rel="stylesheet" href="../../../styles/config.css">
    <link rel="stylesheet" href="../../../styles/createEvent.css">
    <link rel="stylesheet" href="../../../styles/components/header.css">

    <!-- Importação Favicon -->
    <link rel="shortcut icon" href="../../../../assets/favicon.ico" type="image/x-icon">

    <title>Criar um novo evento</title>
</head>
<body>
    <header>
        <h1 class="header-title"><a href="../../../../index.html" class="index-redirect">Event Presence</a></h1>

        <nav>
            <a href="../../eventFeedPage.php" class="header-links">Eventos</a>
            <a href="../../aboutPage.html" class="header-links">Sobre</a>
            <a href="../../contactPage.html" class="header-links">Contato</a>
            <a href="../../connect/registerPage.php" id="connect-redirect">Não possui uma conta?</a>
        </nav>
    </header>

    <main>
        <form action="#" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Criar um novo Evento</legend>

                <label for="event-name">Nome do Evento</label>
                <input type="text" name="event-name" id="event-name" class="create-event-input" required>

                <label for="event-desc">Descrição</label>
                <textarea name="event-desc" id="event-desc" cols="30" rows="10" class="create-event-input" required></textarea>

                <label for="event-ticket">Valor do ingresso</label>
                <input type="text" name="event-ticket" id="event-ticket" class="create-event-input" required>

                <label for="event-attractions">Atrações</label>
                <input type="text" name="event-attraction" id="event-attraction" class="create-event-input" placeholder="Separe cada atração com virgulas" required>

                <label for="event-address">Local</label>
                <input type="text" name="event-address" id="event-address" class="create-event-input" required>

                <label for="event-date">Data</label>
                <input type="date" name="event-date" id="event-date" class="create-event-input" required>

                <label for="event-hour-start">Inicio</label>
                <input type="text" name="event-hour-start" id="event-hour-start" class="create-event-input" required>

                <label for="event-hour-end">Encerramento</label>
                <input type="text" name="event-hour-end" id="event-hour-end" class="create-event-input" required>

                <label for="event-banner">Banner</label>
                <input type="file" name="event-banner" id="event-banner" class="create-event-input" accept="image/x-png,image/gif,image/jpeg" required>
                
                <label for="event-capacity">Capacidade Máxima</label>
                <input type="number" name="event-capacity" id="event-capacity" class="create-event-input" min="0" required>

                <label for="event-age">Idade Mínima</label>
                <input type="number" name="event-age" id="event-age" min="0" class="create-event-input" required>

                <label for="event-rules">Regras</label>
                <textarea name="event-rules" id="event-rules" cols="30" rows="10" class="create-event-input" required></textarea>

                <label for="event-email">Email de contato</label>
                <input type="email" name="event-email" id="event-email" class="create-event-input" required>

                <label for="event-tel">Telefone de contato</label>
                <input type="tel" name="event-tel" id="event-tel" class="create-event-input" required>

                <input type="submit" value="Criar Evento">
                <a href="../profilePage.php" class="cancel-event">Cancelar</a>
            </fieldset>
        </form>
    </main>
</body>
</html>