<?php
session_start();
if (@!$_SESSION['idusu']) {
    echo "<script>location.href='logueo.php'</script>";
} elseif ($_SESSION['rolusu'] == "a1" || $_SESSION['rolusu'] == "empresa") {
    /*if ((time() - $_SESSION['last_login_timestamp']) > 240) { // 900 = 15 * 60  
        setcookie("cerrarsesion", 1, time() + 60000); //6o segundos es 1 minuto, 86400 segundos es por 24 horas
        echo "<script>location.href='desconectar.php'</script>";
    } else {
        $_SESSION['last_login_timestamp'] = time();
    }*/ } else {
    echo "<script>location.href='logueo.php'</script>";
}
?>
<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reservas de clientes | RestaurantApp</title>
    <link rel="icon" href='img/logo.png' sizes="32x32" type="img/jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css2/style.css" />
</head>

<body>
    <?php
    require("connectdb.php");
    include("conexion.php");
    include 'sed.php';
    $idlog = @$_SESSION['idusu'];
    $consulta = ("SELECT * FROM logueo  WHERE logueo.idusu='$idlog'");
    $query1 = mysqli_query($mysqli, $consulta);
    $persona = mysqli_fetch_all($query1, MYSQLI_ASSOC);
    foreach ($persona as $array) {
        $imagperfi = base64_encode($array['imagperfil']);
        $nom = sed::decryption($array["nombreusu"]);
        $apelli = sed::decryption($array["apellidousu"]);
    }
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
        <div class="container-fluid">
            <div class="navbar-brand ">
                <a href="adm.php"><img src="img/atras.png" style="width: 30px; height: 36px;"></a>
                <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 13px;">
                    <img src="img/logo.png" style="width: 28px; height: 36px;">
                </a>
            </div>
        </div>
    </nav><br><br><br>
    <br>
    <?php require("productosreportados.php"); ?>
    <?php
    include('footer.php');
    ?>
</body>

</html>