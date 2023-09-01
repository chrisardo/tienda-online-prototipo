<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro</title>
    <link rel="icon" href='img/logo.png' sizes="32x32" type="img/jpg">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css2/style.css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
        <div class="container-fluid">
            <?php
            extract($_GET);
            if (@$logueo == 1) {
                ?>
                <a class="" href="logueo.php">
                    <img src="img/atras.png" style="width: 30px; height: 40px;">
                </a>
            <?php
            } else {
                ?>
                <a class="" href="index.php">
                    <img src="img/atras.png" style="width: 30px; height: 40px;">
                </a>
            <?php
            }
            ?>
            <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 16px;" href="#">
                <img src="img/logo.png" style="width: 30px; height: 30px;" alt="logo restaurantapp">
                <strong>Periko's</strong>
            </a>

        </div>
    </nav>
    <br><br><br><br>
    <center>
        <a class="btn btn-primary" style="width: 60%;" href="rgistrarse.php">
            <img src="img/perfil.png" style="width: 50px; height: 50px;">Registrarme como cliente
        </a><br><br>
        <a class="btn btn-warning" style="color: white; width: 60%;" href="registroempresa.php">
            <img src="img/negocio.png" style="width: 50px; height: 50px;">Registrarme como empresa
        </a>
    </center>
</body>

</html>