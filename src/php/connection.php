<?php
    include('config.php');

    $dbHost = DB_HOST;
    $dbUser = DB_USER;
    $dbPassword = DB_PASSWORD;
    $dbName = DB_NAME;

    $mysqli = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    if ($mysqli->error) {
        die("Falha ao acessar o Banco de Dados: " . $mysqli->error);
    }
?>