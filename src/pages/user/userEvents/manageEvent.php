<?php
    include('../../../php/connection.php');
    include('../../../php/protect.php');

    $admins = array();
    $handle_admins = array();

    if (isset($_GET['e'])) {
        $event_id = $_GET['e'];

        $user = $_SESSION['user'];
        $owner_email = $user['email'];

        $sql_owner_verification_code = "SELECT `id`, `owner_email` FROM `events` WHERE id = $event_id AND owner_email = '$owner_email'";
        $sql_owner_verification_query = $mysqli->query($sql_owner_verification_code) or die("Falha ao executar código SQL: " . $mysqli->error);

        if ($sql_owner_verification_query->num_rows > 0) {
            // Pega as informações do evento
            $sql_code = "SELECT `id`, `owner_email`, `name`, `ticket`, `address`, `date`, `hour_start`, `hour_end`, `banner`, `capacity`, `age`, `contact_email`, `contact_tel` FROM `events` WHERE id = '$event_id'";
            $sql_query = $mysqli->query($sql_code) or die("Falha ao executar código SQL: " . $mysqli->error);
    
            $event = $sql_query->fetch_assoc();
    
            // Pega as informaçõe das pessoass confirmadas
            $sql_confirmed_code = "SELECT * FROM `confirmed` WHERE event_id = '$event_id'";
            $sql_confirmed_query = $mysqli->query($sql_confirmed_code) or die("Falha ao executar código SQL: " . $mysqli->error);
    
            // Pega as informações dos admins do evento
            $sql_get_admin_code = "SELECT `email` FROM `admins` WHERE event_id = $event_id";
            $sql_get_admin_query = $mysqli->query($sql_get_admin_code) or die("Falha ao executar código SQL: " . $mysqli->error);

            while($admins_list = $sql_get_admin_query->fetch_array()){
                $handle_admins[] = $admins_list;
            };

            foreach ($handle_admins as $admin) {
                // Pega as informações do perfil dos admins
                $admin_email = $admin['email'];

                $sql_admins_code = "SELECT `email`, `name`, `path` FROM `users` WHERE email = '$admin_email'";
                $sql_admins_query = $mysqli->query($sql_admins_code) or die("Falha ao executar código SQL: " . $mysqli->error);

                while ($get_admin = $sql_admins_query->fetch_assoc()) {
                    $admins[] = $get_admin;
                };
            };
            
    
            if (isset($_POST['delete-event-name'])) {
                if (strlen($_POST['delete-event-name']) == 0) {
                    $_SESSION['notify_type'] = "error";
                    $_SESSION['notify_message'] = "Insira valores válidos";
                } else {
                    $name = $mysqli->real_escape_string($_POST['delete-event-name']);
    
                    if ($name === $event['name']) {
                        $sql_code = "DELETE FROM `events` WHERE id = $event_id";
                        $sql_query = $mysqli->query($sql_code) or die("Falha ao executar código SQL: " . $mysqli->error);
                        
                        header("Location: ../profile.php");
                    } else {
                        $_SESSION['notify_type'] = "error";
                        $_SESSION['notify_message'] = "Nome incorreto";
                    }
                }
            }
        } else {
            header("Location: ../profile.php");
        }   
    } else {
        header("Location: ../../../../index.php");
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Importação de estilos -->
    <link rel="stylesheet" href="../../../styles/config.css">
    <link rel="stylesheet" href="../../../styles/manageEvent.css">
    <link rel="stylesheet" href="../../../styles/notify.css">
    <link rel="stylesheet" href="../../../styles/components/header.css">

    <!-- Importação Favicon -->
    <link rel="shortcut icon" href="../../../../assets/favicon.ico" type="image/x-icon">

    <!-- Importação lib de ícones -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Gerencie seu evento</title>
</head>

<body>
    <?php
        $indexLink = '../../../../index.php';
        $eventFeedLink = '../../eventFeed.php';
        $aboutLink = '../../about.php';
        $contactLink = '../../contact.php';
        $loginLink = '../../connect/login.php';
        $profileLink = '../../user/profile.php';
        $assetsRoute = '../../../../assets/uploads/';

        global $indexLink, $eventFeedLink, $aboutLink, $contactLink, $loginLink, $profileLink, $assetsRoute;

        include('../../../php/header.php');
    ?>

    <main>
        <section id="manage-event-page">
            <a href="../profile.php" class="back-button"><i class='bx bx-chevron-left'></i> Voltar</a>
            <div class="event-content">
                <aside>
                    <h2 class="event-name"><?php echo $event['name']; ?></h2>
                    <img src="../../../../assets/uploads/<?php echo $event['banner']; ?>" alt="Banner do evento" class="event-aside-banner">
                    <h3 class="event-aside-title">Valor do ingresso</h3>
                    <p class="event-aside-info event-aside-ticket"><?php echo $event['ticket']; ?></p>
                    <hr>
                    <h3 class="event-aside-title">Local</h3>
                    <p class="event-aside-info event-aside-address"><?php echo $event['address']; ?></p>
                    <hr>
                    <h3 class="event-aside-title">Data</h3>
                    <p class="event-aside-info event-aside-date" id="date-info"><?php echo $event['date']; ?></p>
                    <hr>
                    <h3 class="event-aside-title">Horário</h3>
                    <p class="event-aside-info event-aside-hour"><?php echo $event['hour_start']; ?></p>
                    <hr>
                    <h3 class="event-aside-title">Idade mínima</h3>
                    <p class="event-aside-info event-aside-age"><?php echo $event['age']; ?></p>
                    <hr>
                    <h3 class="event-aside-title">Capacidade máxima</h3>
                    <p class="event-aside-info event-aside-capacity"><?php echo $event['capacity']; ?></p>
                    <hr>
                    <h3 class="event-aside-title">Email de contato</h3>
                    <p class="event-aside-info event-aside-email"><?php echo $event['contact_email']; ?></p>
                    <hr>
                    <h3 class="event-aside-title">Telefone de contato</h3>
                    <p class="event-aside-info event-aside-tel"><?php echo $event['contact_tel']; ?></p>
                    <hr>
                    <a href="./registerEventAdmin.php?e=<?php echo $event_id; ?>" class="redirect-button">Adicionar administradores</a>
                    <a href="./editEvent.php?e=<?php echo $event_id; ?>" class="redirect-button">Editar evento</a>
                    <button class="delete-event">Deletar evento</button>
                </aside>
                <section class="delete-modal">
                    <form action="#" method="POST">
                        <fieldset class="modal-info">
                            <h3 class="modal-title">Deseja mesmo deletar o evento?</h3>
                            <p class="modal-paragraph">Esta ação é irreversível. Para deletar o evento digite o nome do evento abaixo <i><?php echo $event['name']; ?></i></p>
                            <input type="text" name="delete-event-name" id="delete-event-name" class="modal-input">
                            <input type="submit" value="Deletar evento" class="delete-event-modal">
                            <button type="button" class="cancel">Cancelar</button>
                        </fieldset>
                    </form>
                </section>
                <section id="other-infos">
                    <h2 class="manage-event-title">Administradores</h2>
                    <div class="event-admins">
                        <?php
                            foreach ($admins as $admin) {
                        ?>
                            <img src="../../../../assets/uploads/<?php echo $admin['path']; ?>" alt="" class="admin-profile-image">
                        <?php
                            }
                        ?>
                    </div>
                    <h2 class="manage-event-title"><?php echo $sql_confirmed_query->num_rows; ?> Pessoas Confirmadas</h2>
                    <div class="table">
                        <table id="tableExport">
                            <tr>
                                <th class="table-info">Nome</th>
                                <th class="table-info">Email</th>
                                <th class="table-info">Telefone</th>
                                <th class="table-info">CPF</th>
                            </tr>
                            <?php
                                while ($data = $sql_confirmed_query->fetch_array()) {
                            ?>
                                <tr>
                                    <td><?php echo $data['name']; ?></td>
                                    <td><?php echo $data['email']; ?></td>
                                    <td><?php echo $data['tel']; ?></td>
                                    <td><?php echo $data['cpf']; ?></td>
                                </tr>
                            <?php
                                }
                            ?>
                        </table>
                    </div>
                    <button id="export-table">Baixar tabela</button>
                </section>
            </div>
        </section>
    </main>

    <section class="notify-section"></section>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="../../../js/jquery.btechco.excelexport.js"></script>
    <script src="../../../js/jquery.base64.js"></script>

    <script src="../../../js/notify.js"></script>
    <?php
        if (isset($_SESSION['notify_type'])) {
    ?>
        <script>
            createNotify("<?php echo $_SESSION['notify_type']; unset($_SESSION['notify_type']); ?>", "<?php echo $_SESSION['notify_message']; unset($_SESSION['notify_message']); ?>", 5)
        </script>
    <?php
        }
    ?>

    <script>
        $(document).ready(function () {
            $(".delete-modal").hide();

            $("#export-table").click(function () {
                $("#tableExport").btechco_excelexport({
                    containerid: "tableExport",
                    datatype: $datatype.Table,
                    filename: 'confirmedNames'
                });
            });

            $(".delete-event").click(function () {
                $(".delete-modal").show(500);
                $(".cancel").click(function () {
                    $(".delete-modal").hide(500);
                })
            })
        });
    </script>
</body >
</html >