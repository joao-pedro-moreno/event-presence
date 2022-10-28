<?php
    // include('../../php/connection.php');

    // if (isset($_POST['recovery-email'])) {
    //     if (strlen($_POST['recovery-email']) == 0) {
    //         $email = $mysqli->real_escape_string($_POST['recovery-email']);

    //         $new_password = substr(md5(time()), 0, 6);
    //         $new_password_encrypted = md5(md5($new_password));

    //         $sql_code = "UPDATE users SET pass = '$new_password_encrypted' WHERE email = '$email'";
    //         $sql_query = $mysqli->query($sql_code) or die("Falha ao executar código SQL: ". $mysqli->error);

    //         mail($email, "Sua nova senha", "Sua nova senha é: ".$new_password);
    //     }
    // }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Importação de estilos -->
    <link rel="stylesheet" href="../../styles/config.css">
    <link rel="stylesheet" href="../../styles/defaultPage.css">
    <link rel="stylesheet" href="../../styles/components/header.css">
    <link rel="stylesheet" href="../../styles/components/connectForm.css">

    <!-- Importação Favicon -->
    <link rel="shortcut icon" href="../../../assets/favicon.ico" type="image/x-icon">

    <title>Recuperação de Senha</title>
</head>
<body>
    <header>
        <h1 class="header-title"><a href="../../../index.html" class="index-redirect">Event Presence</a></h1>

        <nav>
            <a href="../eventFeedPage.php" class="header-links">Eventos</a>
            <a href="../aboutPage.html" class="header-links">Sobre</a>
            <a href="../contactPage.html" class="header-links">Contato</a>
            <a href="./loginPage.php" id="connect-redirect">Já possui uma conta?</a>
        </nav>
    </header>

    <main>
        <form action="#" method="POST">
            <fieldset>
                <legend>Recuperar Senha</legend>

                <label for="recovery-email">Email</label>
                <input type="email" name="recovery-email" id="recovery-email" class="connect-input" required>

                <input type="submit" value="Recuperar" class="submit-button">
            </fieldset>
        </form>
    </main>
</body>
</html>