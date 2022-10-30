<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    $user = $_SESSION['user'];
?>

<header>
    <h1 class="header-title"><a href="../../../index.html" class="index-redirect">Event Presence</a></h1>

    <nav>
        <a href="../eventFeedPage.php" class="header-links">Eventos</a>
        <a href="../aboutPage.html" class="header-links">Sobre</a>
        <a href="../contactPage.html" class="header-links">Contato</a>

        <?php
            if (!isset($user)) {
        ?>
            <a href="./loginPage.php" id="connect-redirect">Já possui uma conta?</a>
        <?php        
            } else {
        ?>
            <a href="./loginPage.php" id="profile-redirect"><img src="../../../assets/uploads/<?php echo $user['path']; ?>" alt=""></a>
        <?php        
            }
        ?>
        <!-- <a href="./loginPage.php" id="connect-redirect">Já possui uma conta?</a> -->
    </nav>
</header>
