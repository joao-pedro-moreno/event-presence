<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Importação de estilos -->
    <link rel="stylesheet" href="./src/styles/config.css">
    <link rel="stylesheet" href="./src/styles/components/header.css">
    <link rel="stylesheet" href="./src/styles/home.css">

    <!-- Importação Favicon -->
    <link rel="shortcut icon" href="./assets/favicon.ico" type="image/x-icon">

    <title>Event Presence</title>
</head>
<body>
    <?php
        $indexLink = './index.php';
        $eventFeedLink = './src/pages/eventFeed.php';
        $aboutLink = './src/pages/about.php';
        $contactLink = './src/pages/contact.php';
        $loginLink = './src/pages/connect/login.php';
        $profileLink = './src/pages/user/profile.php';
        $assetsRoute = './assets/uploads/';

        global $indexLink, $eventFeedLink, $aboutLink, $contactLink, $loginLink, $profileLink, $assetsRoute;

        include('./src/php/header.php');
    ?>

    <main>
        <section id="index-page">
            <h2 class="index-title">Vai fazer um evento?</h2>
            <h3 class="index-subtitle">Te ajudamos a organizar</h3>

            <p class="index-paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem unde illo perferendis fugit corrupti commodi reiciendis quia quas, eaque cum non. Atque, optio dolore! Consequatur ratione nostrum quaerat ipsa fugit! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ipsum corrupti corporis tempore omnis eius quos impedit odio consequuntur maiores eveniet eaque, enim cum quas, quae veritatis exercitationem facere atque ipsa.</p>
        </section>

        <img src="./assets/ball.svg" alt="Duas pessoas dançando com uma bola de cristal" class="index-image">
    </main>
</body>
</html>