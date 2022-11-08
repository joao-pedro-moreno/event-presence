<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    // $user = $_SESSION['user'];

    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
    } else {
        $user[''] = 'profileImage.png';
    }
?>

<header>
    <h1 class="header-title"><a href="<?php echo $GLOBALS['indexLink']; ?>" class="index-redirect">Event Presence</a></h1>

    <nav>
        <a href="<?php echo $GLOBALS['eventFeedLink']; ?>" class="header-links">Eventos</a>
        <a href="<?php echo $GLOBALS['aboutLink']; ?>" class="header-links">Sobre</a>
        <a href="<?php echo $GLOBALS['contactLink']; ?>" class="header-links">Contato</a>

        <?php
            if (!isset($_SESSION['user'])) {
        ?>
            <a href="<?php echo $GLOBALS['loginLink']; ?>" id="connect-redirect">Já possui uma conta?</a>
        <?php        
            } else {
        ?>
            <a href="<?php echo $GLOBALS['profileLink']; ?>" id="profile-redirect"><img src="<?php echo $GLOBALS['assetsRoute']; echo $user['path']; ?>" alt="" class="header-profile-image"></a>
        <?php        
            }
        ?>
        <!-- <a href="./login.php" id="connect-redirect">Já possui uma conta?</a> -->
    </nav>
</header>
