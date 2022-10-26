<?php 
    if (!isset($_SESSION)) {
        session_start();
    }

    $user = $_SESSION['user'];

    if (!isset($user)) {
        die("Você precisa iniciar a sessão para acessar essa página <a href='../../index.html'>Voltar</a>");
    }
?>