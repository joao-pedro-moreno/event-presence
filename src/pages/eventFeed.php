<?php
    include('../php/connection.php');

    $sql_code = "SELECT `id`, `name`, `description`, `date`, `hour_start`, `banner` FROM `events` WHERE 1";
    $sql_query = $mysqli->query($sql_code) or die("Falha ao executar código SQL: " . $mysqli->error);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Importação de estilos -->
    <link rel="stylesheet" href="../styles/config.css">
    <link rel="stylesheet" href="../styles/eventFeed.css">
    <link rel="stylesheet" href="../styles/components/header.css">

    <!-- Importação Favicon -->
    <link rel="shortcut icon" href="../../assets/favicon.ico" type="image/x-icon">

    <title>Event Presence</title>
</head>
<body>
    <header>
        <h1 class="header-title"><a href="../../index.html" class="index-redirect">Event Presence</a></h1>

        <nav>
            <a href="./eventFeed.php" class="header-links">Eventos</a>
            <a href="./about.html" class="header-links">Sobre</a>
            <a href="./contact.html" class="header-links">Contato</a>
            <a href="./connect/login.php" id="connect-redirect">Já possui uma conta?</a>
        </nav>
    </header>

    <main>
        <section id="event-feed-page">
            <?php
                while($data = $sql_query->fetch_array()) {
            ?>
                <article class="event-card">
                    <img src="../../assets/uploads/<?php echo $data['banner'] ?>" alt="Banner do evento" class="card-image">
                    <h3 class="card-name"><?php echo $data['name'] ?></h3>
                    <p class="card-desc"><?php echo $data['description'] ?></p>
                    <span class="card-date"><?php echo $data['date'] ?></span>
                    <span class="card-hour"><?php echo $data['hour_start'] ?></span>
                    <a href="./eventInfo.php?e=<?php echo $data['id'] ?>" class="card-button">Mais informações</a>
                </article>
            <?php
                }
            ?>
        </section>
    </main>
</body>
</html>