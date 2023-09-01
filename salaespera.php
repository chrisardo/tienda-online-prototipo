<?php
session_start();
if (@!$_SESSION['idusu']) {
    echo "<script>location.href='logueo.php'</script>";
} elseif ($_SESSION['rolusu'] == "a1" || $_SESSION['rolusu'] == "empresa" || $_SESSION['rolusu'] == "repartidor") {
    /*¡if ((time() - $_SESSION['last_login_timestamp']) > 240) { // 900 = 15 * 60  
        setcookie("cerrarsesion", 1, time() + 60000); //6o segundos es 1 minuto, 86400 segundos es por 24 horas
        echo "<script>location.href='desconectar.php'</script>";
    } else {
        $_SESSION['last_login_timestamp'] = time();
    }*/ } else {
    echo "<script>location.href='logueo.php'</script>";
}
require("connectdb.php");
include("conexion.php");
include 'sed.php';
$idlog = @$_SESSION['idusu'];
$consulta = ("SELECT * FROM logueo_empresa  WHERE id_empresa='$idlog'");
$query1 = mysqli_query($mysqli, $consulta);
$persona = mysqli_fetch_all($query1, MYSQLI_ASSOC);
foreach ($persona as $array) {
    $id = $array['id_empresa'];
    $imagperfi = base64_encode($array['imagempresa']);
    $nom = sed::decryption($array["nombreempresa"]);
    $detalle_empresa = SED::decryption($array['detalle_empresa']);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sala en espera | RestaurantApp</title>
    <link rel="icon" href='img/logo.png' sizes="32x32" type="img/jpg" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css2/style.css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
        <div class="container-fluid">
            <a class="" href="desconectar.php">
                <img src="img/atras.png" style="width: 30px; height: 40px;">
            </a>
            <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 15px;" href="#">
                <img src="img/logo.png" style="width: 30px; height: 30px;" alt="logo restaurantapp">
                <strong>Perikos</strong>
            </a>
        </div>
    </nav>
    <br><br><br>
    <div class="container container-web-page ">
        <div class="row justify-content-md-center border-primary" style="background-color: orange;border-radius: 35px; width: 100%; margin-left: 0;">
            <div class="col-12 col-md-6">
                <figure class="full-box">
                    <center>
                        <img src="img/esperando.png" alt="registration_killaripostres" class="img-fluid">
                    </center>
                </figure>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-md-6">
                <h3 style="color:white;" class="text-center text-uppercase poppins-regular font-weight-bold">
                    <strong>Sala en espera</strong></h3>

                <p class="text-justify">
                    <center>
                        <strong style="color:white;">
                            <?php echo $nom; ?> spere a que el administrador revise y acepte su solicitud para que se habilite su cuenta...</strong>

                    </center>
                </p>
            </div>
        </div>
    </div>
</body>

</html>