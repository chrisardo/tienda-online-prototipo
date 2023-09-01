<?php
session_start();
/*if (@$_SESSION['rolusu'] == "user") { //sino si la session rol no esta 
    if ((time() - @$_SESSION['last_login_timestamp']) > 240) { // 900 = 15 * 60  
        setcookie("cerrarsesion", 1, time() + 60000); //6o segundos es 1 minuto, 86400 segundos es por 24 horas
        echo "<script>location.href='desconectar.php'</script>";
    } else {
        @$_SESSION['last_login_timestamp'] = time();
    }
}*/
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Opciones|RestaurantApp</title>
    <link rel="icon" href='img/logo.png' sizes="32x32" type="img/jpg" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css2/style.css" />
</head>

<body>
    <?php
    require("connectdb.php");
    include("conexion.php");
    include 'sed.php';
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
        <div class="container-fluid">
            <a class="" href="index.php">
                <img src="img/atras.png" style="width: 30px; height: 40px;">
            </a>
            <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 15px;" href="#">

                <img src="img/logo.png" style="width: 30px; height: 30px;" alt="logo killaripostres">
                <strong>Periko's</strong>
            </a>
        </div>
    </nav>
    <br><br><br>
    <div style="width: 90%; margin-left: 22px; border:2px solid blue;">
        <div style="width: 100%; border:2px solid blue;">
            <img src="img/opcione.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">
            <h1 style="display: inline-block;">Opciones</h1>
        </div>
        <div style="width: 100%; border: 2px solid blue; ">
            <?php
            if (@!$_SESSION['idusu']) { //si la session del usuario esta vacia
                ?>
            <?php
                //El @ oculta los mensajes de error que pueda salir
            } else if ($_SESSION['rolusu'] == "user") { //sino si la session rol no esta vacia
                ?>
                <div style="margin-top: 3px">
                    <a href="informacion.php">
                        <img src="img/informa.png" style="width: 30px; height: 30px; margin-left: 26px;">
                        Información sobre su cuenta
                    </a>
                </div>
                <div style="width: 90%; height: 2px; background-color: blue; margin-top: 3px; margin-left: 6px;"></div>
                <div style="margin-top: 3px">
                    <a href="favoritos.php">
                        <img src="img/favorito.png" style="width: 30px; height: 30px; margin-left: 26px;">
                        Productos favoritos
                    </a>
                </div>
                <div style="width: 90%; height: 2px; background-color: blue; margin-top: 3px; margin-left: 6px;"></div>
            <?php } ?>
            <div style="margin-top: 3px">
                <a href="nosotros.php">
                    <img src="img/inf.png" style="width: 30px; height: 30px; margin-left: 26px;">
                    Acerca de nosotros
                </a>
            </div>
            <div style="width: 90%; height: 2px; background-color: blue; margin-top: 3px; margin-left: 6px;"></div>

            <div style="margin-top: 3px">
                <a href="politicaprivacidad.php">
                    <img src="img/politicaprivacidad.png" style="width: 30px; height: 30px; margin-left: 26px;">
                    Politica de privacidad</a>
            </div>
        </div>
    </div>
</body>

</html>