<?php
    include('../../php/connection.php');

    if (isset($_GET['e'])) {
        $event_id = $_GET['e'];

        $sql_code = "SELECT * FROM `events` WHERE id = '$event_id'";
        $sql_query = $mysqli->query($sql_code) or die("Falha ao executar código SQL: " . $mysqli->error);

        $event = $sql_query->fetch_assoc();

        if (isset($_POST['confirm-name']) || isset($_POST['confirm-email']) || isset($_POST['confirm-tel']) || isset($_POST['confirm-cpf'])) {
            if (strlen($_POST['confirm-name']) == 0 || strlen($_POST['confirm-email']) == 0 || strlen($_POST['confirm-tel']) == 0 || strlen($_POST['confirm-cpf']) == 0) {
                $_SESSION['notify_type'] = "error";
                $_SESSION['notify_message'] = "Insira valores válidos";
            } else {
                $name = $mysqli->real_escape_string($_POST['confirm-name']);
                $email = $mysqli->real_escape_string($_POST['confirm-email']);
                $tel = $mysqli->real_escape_string($_POST['confirm-tel']);
                $cpf = $mysqli->real_escape_string($_POST['confirm-cpf']);

                $sql_confirmed_verification_code = "SELECT `event_id`, `cpf` FROM `confirmed` WHERE event_id = $event_id AND cpf = '$cpf'";
                $sql_confirmed_verification_query = $mysqli->query($sql_confirmed_verification_code) or die("Falha ao executar código SQL: " . $mysqli->error);

                if ($sql_confirmed_verification_query->num_rows > 0) {
                    $_SESSION['notify_type'] = "error";
                    $_SESSION['notify_message'] = "Pessoa já confirmada";
                } else {
                    $sql_confirmed_code = "INSERT INTO `confirmed`(`event_id`, `name`, `email`, `tel`, `cpf`) VALUES ('$event_id','$name', '$email','$tel','$cpf')";
                    $sql_confirmed_query = $mysqli->query($sql_confirmed_code) or die("Falha ao executar o código SQL: " . $mysqli->error);
    
                    header("Location: ../eventFeed.php");
                }

            }
        }
    } else {
        header("Location: ../eventFeed.php");
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
    <link rel="stylesheet" href="../../styles/eventInfo.css">
    <link rel="stylesheet" href="../../styles/notify.css">
    <link rel="stylesheet" href="../../styles/components/header.css">

    <!-- Importação Favicon -->
    <link rel="shortcut icon" href="../../../assets/favicon.ico" type="image/x-icon">

    <!-- Importação lib de ícones -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Confirme sua presença</title>
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
        <section id="confirm-presence-page">
            <a href="../eventInfo.php?e=<?php echo $event_id; ?>" class="back-button"><i class='bx bx-chevron-left'></i> Voltar</a>
            
            <div class="confirm-event-content">
                <aside id="event-info-page-aside">
                    <h2 class="event-name"><?php echo $event['name']; ?></h2>

                    <img src="../../../assets/uploads/<?php echo $event['banner']; ?>" alt="Banner do evento" class="event-aside-banner">

                    <h4 class="event-aside-title">Valor do ingresso</h4>
                    <p class="event-aside-info event-aside-ticket"><?php echo $event['ticket']; ?></p>
                    <hr>

                    <h4 class="event-aside-title">Idade mínima</h4>
                    <p class="event-aside-info event-aside-age"><?php echo $event['age']; ?></p>
                    <hr>
                
                    <h4 class="event-aside-title">Local</h4>
                    <p class="event-aside-info event-aside-address"><?php echo $event['address']; ?></p>
                    <hr>
                
                    <h4 class="event-aside-title">Data</h4>
                    <p class="event-aside-info event-aside-date"><?php echo $event['date']; ?></p>
                    <hr>
                
                    <h4 class="event-aside-title">Horário</h4>
                    <p class="event-aside-info event-aside-hour"><?php echo $event['hour_start']; ?></p>
                    <hr>
                
                    <h4 class="event-aside-title">Capacidade máxima</h4>
                    <p class="event-aside-info event-aside-capacity"><?php echo $event['capacity']; ?></p>
                    <hr>
                
                    <h4 class="event-aside-title">Email de contato</h4>
                    <p class="event-aside-info event-aside-email"><?php echo $event['contact_email']; ?></p>
                    <hr>
                
                    <h4 class="event-aside-title">Telefone de contato</h4>
                    <p class="event-aside-info event-aside-tel"><?php echo $event['contact_tel']; ?></p>
                </aside>
            
                <form action="#" method="POST" class="page-form">
                    <fieldset>
                        <legend>Confirme sua presença</legend>
            
                        <label for="confirm-name">Nome</label>
                        <input type="text" name="confirm-name" id="confirm-name" class="page-form-input" required>
            
                        <label for="confirm-email">Email</label>
                        <input type="email" name="confirm-email" id="confirm-email" class="page-form-input" required>
            
                        <label for="confirm-tel">Telefone</label>
                        <input type="tel" name="confirm-tel" id="confirm-tel" class="page-form-input" required>
            
                        <label for="confirm-cpf">CPF</label>
                        <input type="text" name="confirm-cpf" id="confirm-cpf" class="page-form-input" required>
            
                        <input type="submit" value="Confirmar Presença" class="page-form-submit">
                        <a href="../eventInfo.php?e=<?php echo $event_id; ?>" class="cancel">Cancelar</a>
                    </fieldset>
                </form>
            </div>
        </section>
    </main>

    <section class="notify-section"></section>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="../../js/jquery.btechco.excelexport.js"></script>
    <script src="../../js/jquery.base64.js"></script>
    <script src="https://unpkg.com/imask"></script>

    <script src="../../js/notify.js"></script>
    <script src="../../js/confirmPresenceMask.js"></script>
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