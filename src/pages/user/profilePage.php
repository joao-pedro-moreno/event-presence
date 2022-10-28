<?php
    include('../../php/protect.php');
    include('../../php/connection.php');

    $user = $_SESSION['user'];
    $email = $user['email'];

    $sql_code = "SELECT `id`, `owner_email`, `name`, `banner` FROM `events` WHERE owner_email = '$email'";
    $sql_query = $mysqli->query($sql_code) or die("Falha ao executar código SQL: " . $mysqli->error);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Importação de estilos -->
    <link rel="stylesheet" href="../../styles/config.css">
    <link rel="stylesheet" href="../../styles/profilePage.css">
    <link rel="stylesheet" href="../../styles/components/header.css">

    <!-- Importação lib de ícones -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Importação Favicon -->
    <link rel="shortcut icon" href="../../../assets/favicon.ico" type="image/x-icon">

    <title>Perfil</title>
</head>
<body>
    <header>
        <h1 class="header-title"><a href="../../../index.html" class="index-redirect">Event Presence</a></h1>

        <nav>
            <a href="../eventFeedPage.php" class="header-links">Eventos</a>
            <a href="../aboutPage.html" class="header-links">Sobre</a>
            <a href="../contactPage.html" class="header-links">Contato</a>
            <a href="../connect/loginPage.php" id="connect-redirect">Já possui uma conta?</a>
        </nav>
    </header>

    <main>
        <div class="profile-content">
            <aside>
                <img src="../../../assets/uploads/<?php echo $user['path']; ?>" alt="" class="profile-image">
                <div class="profile-info">
                    <h2 class="user-name"><?php echo $user['name']; ?></h2>
                    <p class="user-info" id="user-username"><?php echo $user['user']; ?></p>
                    <p class="user-info" id="user-email"><?php echo $user['email']; ?></p>
                </div>

                <div class="profile-buttons">
                    <a href="./editProfile.php" class="edit-profile">Editar Perfil</a>
                    <a href="../../php/logout.php" class="disconnect-profile">Desconectar</a>
                </div>
            </aside>

            <hr>
            
            <section>
                <h2 class="section-title">Seus eventos</h2>

                <div class="user-events">
                    <a href="./userEvents/createEventPage.php" class="event-create">
                        <i class='bx bx-plus'></i>
                        <span class="create-event-span">Criar um novo Evento</span>
                    </a>

                    <?php
                        while($data = $sql_query->fetch_array()) {
                    ?>
                            <article>
                                <img src="../../../assets/uploads/<?php echo $data['banner']; ?>" alt="Banner do evento" class="event-banner">
        
                                <h3 class="event-name"><?php echo $data['name']; ?></h3>
        
                                <a href="./userEvents/manageEventPage.php?e=<?php echo $data['id']; ?>" class="manage-event-button">Gerenciar evento</a>
                            </article>
                    <?php
                        }
                    ?>


                    <!-- <article>
                        <img src="../../../assets/uploads/eventBanner.jpg" alt="Banner do evento" class="event-banner">

                        <h3 class="event-name">Nome do Evento</h3>

                        <a href="./userEvents/manageEventPage.html" class="manage-event-button">Gerenciar evento</a>
                    </article>

                    <article>
                        <img src="../../../assets/uploads/eventBanner.jpg" alt="Banner do evento" class="event-banner">

                        <h3 class="event-name">Nome do Evento</h3>

                        <a href="./userEvents/manageEventPage.html" class="manage-event-button">Gerenciar evento</a>
                    </article> -->
                </div>
            </section>
        </div>
    </main>
</body>
</html>