<?php
    include('../../php/protect.php');
    include('../../php/connection.php');

    if (isset($_FILES['edit-image']) && isset($_POST['edit-name']) && isset($_POST['edit-user'])) {
        $file = $_FILES['edit-image'];

        if ($file['error']) {
            $user = $_SESSION['user'];

            $user_email = $user['email'];
            $user_name = $mysqli->real_escape_string($_POST['edit-name']);
            $user_username = $mysqli->real_escape_string($_POST['edit-user']);

            $sql_code = "UPDATE `users` SET `user`='$user_username',`name`='$user_name' WHERE `email` = '$user_email'";
            $sql_query = $mysqli->query($sql_code) or die("Falha ao executar código SQL: " . $mysqli->error);

            $_SESSION['user']['name'] = $user_name;
            $_SESSION['user']['user'] = $user_username;

            header("Location: profile.php");
        }

        $dir = "../../../assets/uploads/";
        $new_file_name = uniqid();
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if ($extension != "jpg" && $extension != "png" && $extension != "jpeg") {
            die("Tipo de arquivo não aceito");
        }

        $right_extension = move_uploaded_file($file['tmp_name'], $dir . $new_file_name . "." . $extension);
        $file_path = $new_file_name . "." . $extension;

        if ($right_extension) {

            $user = $_SESSION['user'];

            $user_email = $user['email'];
            $user_name = $mysqli->real_escape_string($_POST['edit-name']);
            $user_username = $mysqli->real_escape_string($_POST['edit-user']);

            $sql_code = "UPDATE `users` SET `user`='$user_username',`name`='$user_name',`path`='$file_path' WHERE `email` = '$user_email'";
            $sql_query = $mysqli->query($sql_code) or die("Falha ao executar código SQL: " . $mysqli->error);

            $_SESSION['user']['name'] = $user_name;
            $_SESSION['user']['user'] = $user_username;
            $_SESSION['user']['path'] = $file_path;

            header("Location: profile.php");

        } else {
            $_SESSION['notify_type'] = "error";
            $_SESSION['notify_message'] = "Falha ao enviar arquivo";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Importação de estilos -->
    <link rel="stylesheet" href="../../styles/config.css">
    <link rel="stylesheet" href="../../styles/editProfile.css">
    <link rel="stylesheet" href="../../styles/notify.css">
    <link rel="stylesheet" href="../../styles/components/header.css">

    <!-- Importação lib de ícones -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Importação Favicon -->
    <link rel="shortcut icon" href="../../../assets/favicon.ico" type="image/x-icon">

    <title>Editar Perfil</title>
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
        <section id="edit-profile-page">    
            <form action="#" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <legend>Editar Perfil</legend>

                    <label for="edit-name">Nome</label>
                    <input type="text" name="edit-name" id="edit-name" class="edit-input" value="<?php echo $user['name']; ?>" required>

                    <label for="edit-user">Usuário</label>
                    <input type="text" name="edit-user" id="edit-user" class="edit-input" value="<?php echo $user['user']; ?>" required>

                    <label for="edit-image">Foto de Perfil</label>
                    <input type="file" name="edit-image" id="edit-image" class="edit-input" accept="image/x-png,image/jpeg">

                    <input type="submit" value="Salvar Alterações">
                    <a href="./profile.php" class="cancel">Cancelar Alterações</a>
                </fieldset>
            </form>
        </section>
    </main>

    <section class="notify-section"></section>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="../../js/jquery.btechco.excelexport.js"></script>
    <script src="../../js/jquery.base64.js"></script>

    <script src="../../js/notify.js"></script>
    <?php
        if (isset($_SESSION['notify_type'])) {
    ?>
        <script>
            createNotify("<?php echo $_SESSION['notify_type']; unset($_SESSION['notify_type']); ?>", "<?php echo $_SESSION['notify_message']; unset($_SESSION['notify_message']); ?>", 5)
        </script>
    <?php
        }
    ?>
</body>
</html>