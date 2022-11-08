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
        <section id="profile-page">
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
            
            <section>
                <h2 class="section-title">Seus eventos</h2>

                <div class="user-events">
                    <a href="./userEvents/createEvent.php" class="event-create">
                        <i class='bx bx-plus'></i>
                        <span class="create-event-span">Criar um novo Evento</span>
                    </a>

                    <?php
                        while($data = $sql_query->fetch_array()) {
                    ?>
                            <article class="event-card">
                                <img src="../../../assets/uploads/<?php echo $data['banner']; ?>" alt="Banner do evento" class="event-banner">
        
                                <h3 class="event-name"><?php echo $data['name']; ?></h3>
        
                                <a href="./userEvents/manageEvent.php?e=<?php echo $data['id']; ?>" class="manage-event-button">Gerenciar evento</a>
                            </article>
                    <?php
                        }
                    ?>
                </div>
            </section>
        </section>
    </main>
</body>
</html>