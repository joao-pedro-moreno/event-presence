<?php
    include('../php/connection.php');

    if (isset($_GET['e'])) {
        $event_id = $_GET['e'];

        $sql_code = "SELECT * FROM `events` WHERE id = '$event_id'";
        $sql_query = $mysqli->query($sql_code) or die("Falha ao executar código SQL: " . $mysqli->error);

        $event = $sql_query->fetch_assoc();
    } else {
        header("Location: eventFeed.php");
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Importação de estilos -->
    <link rel="stylesheet" href="../styles/config.css">
    <link rel="stylesheet" href="../styles/components/header.css">
    <link rel="stylesheet" href="../styles/eventInfo.css">

    <!-- Importação Favicon -->
    <link rel="shortcut icon" href="../../assets/favicon.ico" type="image/x-icon">

    :<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Importação biblioteca de ícones -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Informações do evento</title>
</head>
<body>
    <?php
        $indexLink = '../../index.php';
        $eventFeedLink = './eventFeed.php';
        $aboutLink = './about.php';
        $contactLink = './contact.php';
        $loginLink = './connect/login.php';
        $profileLink = './user/profile.php';
        $assetsRoute = '../../assets/uploads/';

        global $indexLink, $eventFeedLink, $aboutLink, $contactLink, $loginLink, $profileLink, $assetsRoute;

        include('../php/header.php');
    ?>

    <main>
        <section id="event-info-page">
            <a href="./eventFeed.php" class="back-button"><i class='bx bx-chevron-left'></i> Voltar</a>
            <img src="../../assets/uploads/<?php echo $event['banner']; ?>" alt="Banner do evento" class="event-banner">
            <div class="event-content">
                <section id="event-info-page-section" >
                    <h2 class="event-name"><?php echo $event['name']; ?></h2>
                    <h3 class="event-info-title">Descrição</h3>
                    <p class="event-info event-desc"><?php echo $event['description']; ?></p>
                    <h3 class="event-info-title">Atrações</h3>
                    <ul>
                        <?php
                            $attractions = explode("," ,$event['attractions']);
                            $number_of_attractions = count($attractions);

                            for ($i = 0; $i < $number_of_attractions; $i++) {
                        ?>
                                <li class='event-attractions'><?php echo $attractions[$i]; ?></li>
                        <?php
                            }
                        ?>
                    </ul>
                    <h3 class="event-info-title">Regras</h3>
                    <p class="event-info event-rules"><?php echo $event['rules']; ?></p>

                    <a href="./connect/confirmPresence.php?e=<?php echo $event_id; ?>" class="redirect-confirm-page">Confirmar Presença</a>
                </section>
                
                <aside id="event-info-page-aside">
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
            </div>
        </section>
    </main>
</body>
</html>