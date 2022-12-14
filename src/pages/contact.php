<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Importação de estilos -->
    <link rel="stylesheet" href="../styles/config.css">
    <link rel="stylesheet" href="../styles/components/header.css">
    <link rel="stylesheet" href="../styles/defaultPage.css">

    <!-- Importação lib de ícones -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Importação Favicon -->
    <link rel="shortcut icon" href="../../assets/favicon.ico" type="image/x-icon">

    <title>Contato</title>
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
        <section id="contact-page">
            <h3 class="contact-title">Email</h3>
            <a href="mailto:devmoreno1br@gmail.com" class="contact-link">devmoreno1br@gmail.com</a>
            <h3 class="contact-title">Telefone</h3>
            <a href="tel:+5500000000000" class="contact-link">+5500000000000</a>
            <section class="social-media-section">
                <a href="https://instagram.com/jpm0r3n0" class="social-media-links" target="_blank"><i class='bx bxl-instagram'></i></a>
                <a href="https://twitter.com/JPM0R3N0" class="social-media-links" target="_blank"><i class='bx bxl-twitter' ></i></a>
                <a href="https://github.com/joao-pedro-moreno" class="social-media-links" target="_blank"><i class='bx bxl-github'></i></a>
                <a href="https://www.linkedin.com/in/joão-pedro-magalhães-castro-moreno-86823821b/" class="social-media-links" target="_blank"><i class='bx bxl-linkedin' ></i></a>
            </section>
        </section>
    </main>
</body>
</html>