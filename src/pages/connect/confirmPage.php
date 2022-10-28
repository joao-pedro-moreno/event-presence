<?php
    include('../../php/connection.php');

    if (isset($_GET['e'])) {
        $event_id = $_GET['e'];

        $sql_code = "SELECT * FROM `events` WHERE id = '$event_id'";
        $sql_query = $mysqli->query($sql_code) or die("Falha ao executar código SQL: " . $mysqli->error);

        $event = $sql_query->fetch_assoc();

        if (isset($_POST['confirm-name']) || isset($_POST['confirm-email']) || isset($_POST['confirm-tel']) || isset($_POST['confirm-cpf'])) {
            if (strlen($_POST['confirm-name']) == 0 || strlen($_POST['confirm-email']) == 0 || strlen($_POST['confirm-tel']) == 0 || strlen($_POST['confirm-cpf']) == 0) {
                echo "Insira valores válidos";
            } else {
                $name = $mysqli->real_escape_string($_POST['confirm-name']);
                $email = $mysqli->real_escape_string($_POST['confirm-email']);
                $tel = $mysqli->real_escape_string($_POST['confirm-tel']);
                $cpf = $mysqli->real_escape_string($_POST['confirm-cpf']);

                $sql_confirmed_code = "INSERT INTO `confirmed`(`event_id`, `name`, `email`, `tel`, `cpf`) VALUES ('$event_id','$name', '$email','$tel','$cpf')";
                $sql_confirmed_query = $mysqli->query($sql_confirmed_code) or die("Falha ao executar o código SQL: " . $mysqli->error);

                header("Location: ../eventFeedPage.php");
            }
        }
    } else {
        header("Location: ../eventFeedPage.php");
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
    <link rel="stylesheet" href="../../styles/confirmPage.css">
    <link rel="stylesheet" href="../../styles/components/header.css">

    <!-- Importação Favicon -->
    <link rel="shortcut icon" href="../../../assets/favicon.ico" type="image/x-icon">

    <title>Confirme sua presença</title>
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
        <div class="event-content">
            <aside>
                <h2 class="event-name"><?php echo $event['name']; ?></h2>

                <img src="../../../assets/uploads/<?php echo $event['banner']; ?>" alt="Banner do evento" class="event-banner">

                <h3 class="event-aside-title">Valor do ingresso</h3>
                <p class="event-aside-info event-aside-ticket"><?php echo $event['ticket']; ?></p>
                <hr>

                <h3 class="event-aside-title">Idade mínima</h3>
                <p class="event-aside-info event-aside-age"><?php echo $event['age']; ?></p>
                <hr>
            
                <h3 class="event-aside-title">Local</h3>
                <p class="event-aside-info event-aside-address"><?php echo $event['address']; ?></p>
                <hr>
            
                <h3 class="event-aside-title">Data</h3>
                <p class="event-aside-info event-aside-date"><?php echo $event['date']; ?></p>
                <hr>
            
                <h3 class="event-aside-title">Horário</h3>
                <p class="event-aside-info event-aside-hour"><?php echo $event['hour_start']; ?></p>
                <hr>
            
                <h3 class="event-aside-title">Capacidade máxima</h3>
                <p class="event-aside-info event-aside-capacity"><?php echo $event['capacity']; ?></p>
                <hr>
            
                <h3 class="event-aside-title">Email de contato</h3>
                <p class="event-aside-info event-aside-email"><?php echo $event['contact_email']; ?></p>
                <hr>
            
                <h3 class="event-aside-title">Telefone de contato</h3>
                <p class="event-aside-info event-aside-tel"><?php echo $event['contact_tel']; ?></p>
            </aside>
            
            <form action="#" method="POST">
                <fieldset>
                    <legend>Confirme sua presença</legend>

                    <label for="confirm-name">Nome</label>
                    <input type="text" name="confirm-name" id="confirm-name" class="confirm-input" required>

                    <label for="confirm-email">Email</label>
                    <input type="email" name="confirm-email" id="confirm-email" class="confirm-input" required>

                    <label for="confirm-tel">Telefone</label>
                    <input type="tel" name="confirm-tel" id="confirm-tel" class="confirm-input" required>

                    <label for="confirm-cpf">CPF</label>
                    <input type="text" name="confirm-cpf" id="confirm-cpf" class="confirm-input" required>

                    <input type="submit" value="Confirmar Presença" class="submit-button">
                    <a href="../eventFeedPage.php" class="cancel-confirm">Cancelar</a>
                </fieldset>
            </form>
        </div>
    </main>
</body>
</html>