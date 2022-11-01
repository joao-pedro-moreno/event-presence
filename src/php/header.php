<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    $user = $_SESSION['user'];
?>

<header>
    <h1 class="header-title"><a href="../../../index.html" class="index-redirect">Event Presence</a></h1>

    <nav>
        <a href="../eventFeed.php" class="header-links">Eventos</a>
        <a href="../about.html" class="header-links">Sobre</a>
        <a href="../contact.html" class="header-links">Contato</a>

        <?php
            if (!isset($user)) {
        ?>
            <a href="./login.php" id="connect-redirect">Já possui uma conta?</a>
        <?php        
            } else {
        ?>
            <a href="./login.php" id="profile-redirect"><img src="../../../assets/uploads/<?php echo $user['path']; ?>" alt=""></a>
        <?php        
            }
        ?>
        <!-- <a href="./login.php" id="connect-redirect">Já possui uma conta?</a> -->
    </nav>
</header>
