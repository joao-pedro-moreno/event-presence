<?php 
    if (!isset($_SESSION)) {
        session_start();
    }

    $user = $_SESSION['user'];

    if (!isset($user)) {
        header("Location: ../../index.html");
    }
?>