<?php
    include('../../../php/connection.php');
    include('../../../php/protect.php');

    if (isset($_GET['e'])) {
        $event_id = $_GET['e'];

        // Pega as informações do evento
        $sql_code = "SELECT `id`, `owner_email`, `name`, `ticket`, `address`, `date`, `hour_start`, `hour_end`, `banner`, `capacity`, `age`, `contact_email`, `contact_tel` FROM `events` WHERE id = '$event_id'";
        $sql_query = $mysqli->query($sql_code) or die("Falha ao executar código SQL: " . $mysqli->error);

        $event = $sql_query->fetch_assoc();

        // Pega as informaçõe das pessoass confirmadas
        $sql_confirmed_code = "SELECT * FROM `confirmed` WHERE event_id = '$event_id'";
        $sql_confirmed_query = $mysqli->query($sql_confirmed_code) or die("Falha ao executar código SQL: " . $mysqli->error);

        // Pega as informações dos admins do evento
        $sql_get_admin_code = "SELECT `event_id`, `email` FROM `admins` WHERE event_id = $event_id";
        $sql_get_admin_query = $mysqli->query($sql_get_admin_code) or die("Falha ao executar código SQL: " . $mysqli->error);

        if ($sql_get_admin_query->num_rows > 0) {
            $admins = $sql_get_admin_query->fetch_assoc();
            $admin_email = $admins['email'];
    
            // Pega as informações do perfil dos admins
            $sql_admins_code = "SELECT `user`, `email`, `name`, `path` FROM `users` WHERE email = '$admin_email'";
            $sql_admins_query = $mysqli->query($sql_admins_code) or die("Falha ao executar código SQL: " . $mysqli->error);
        } 
        
    } else {
        header("Location: ../../../../index.html");
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
    <link rel="stylesheet" href="../../../styles/components/header.css">

    <!-- Importação Favicon -->
    <link rel="shortcut icon" href="../../../../assets/favicon.ico" type="image/x-icon">

    <title>Gerencie seu evento</title>
</head>

<body>
    <header>
        <h1 class="header-title"><a href="../../../../index.html" class="index-redirect">Event Presence</a></h1>

        <nav>
            <a href="../../eventFeedPage.php" class="header-links">Eventos</a>
            <a href="../../aboutPage.html" class="header-links">Sobre</a>
            <a href="../../contactPage.html" class="header-links">Contato</a>
            <a href="../../connect/loginPage.php" id="connect-redirect">Já possui uma conta?</a>
        </nav>
    </header>

    <main>
        <div class="event-content">
        <aside>
                <h2 class="event-name"><?php echo $event['name'] ?></h2>

                <img src="../../../../assets/uploads/<?php echo $event['banner'] ?>" alt="Banner do evento" class="event-banner">

                <h3 class="event-aside-title">Valor do ingresso</h3>
                <p class="event-aside-info event-aside-ticket"><?php echo $event['ticket'] ?></p>
                <hr>

                <h3 class="event-aside-title">Local</h3>
                <p class="event-aside-info event-aside-address"><?php echo $event['address'] ?></p>
                <hr>

                <h3 class="event-aside-title">Data</h3>
                <p class="event-aside-info event-aside-date"><?php echo $event['date'] ?></p>
                <hr>

                <h3 class="event-aside-title">Horário</h3>
                <p class="event-aside-info event-aside-hour"><?php echo $event['hour_start'] ?></p>
                <hr>

                <h3 class="event-aside-title">Idade mínima</h3>
                <p class="event-aside-info event-aside-age"><?php echo $event['age'] ?></p>
                <hr>

                <h3 class="event-aside-title">Capacidade máxima</h3>
                <p class="event-aside-info event-aside-capacity"><?php echo $event['capacity'] ?></p>
                <hr>

                <h3 class="event-aside-title">Email de contato</h3>
                <p class="event-aside-info event-aside-email"><?php echo $event['contact_email'] ?></p>
                <hr>

                <h3 class="event-aside-title">Telefone de contato</h3>
                <p class="event-aside-info event-aside-tel"><?php echo $event['contact_tel'] ?></p>

                <hr>
                <a href="./registerEventAdmin.php?e=<?php echo $event_id; ?>" class="redirect-button">Adicionar administradores</a>
                <a href="./editEvent.php?e=<?php echo $event_id; ?>" class="redirect-button">Editar evento</a>
            </aside>

            <section>
                <h2 class="manage-event-title">Administradores</h2>
                <div class="event-admins">
                    <?php
                        while ($data = $sql_admins_query->fetch_array()) {
                    ?>
                        <img src="../../../../assets/uploads/<?php echo $data['path']; ?>" alt="<?php echo $data['user']; ?>" class="admin-profile-image">
                    <?php        
                        }
                    ?>
                </div>

                <h2 class="manage-event-title">Pessoas Confirmadas</h2>

                <div class="table">
                    <table id="tableExport">
                        <thead>
                            <tr>
                                <th class="table-info">Nome</th>
                                <th class="table-info">Email</th>
                                <th class="table-info">Telefone</th>
                                <th class="table-info">CPF</th>
                            </tr>
                        </thead>
                        <tbody>
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
                        </tbody>
                    </table>
                </div>

                <button id="exportTable">Baixar tabela</button>
            </section>
        </div>
    </main>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="../../../js/jquery.btechco.excelexport.js"></script>
    <script src="../../../js/jquery.base64.js"></script>

    <script>
        $(document).ready(function () {
            $("#exportTable").click(function () {
                $("#tableExport").btechco_excelexport({
                    containerid: "tableExport",
                    datatype: $datatype.Table,
                    filename: 'confirmedNames'
                });
            });
        });
    </script>
</body >
</html >