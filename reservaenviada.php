<?php
//validar
session_start();
if (@!$_SESSION['idusu']) {
  echo "<script>location.href='logueo.php'</script>";
} elseif ($_SESSION['rolusu'] == "user") {
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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Reserva enviada |RestaurantApp</title>
  <link rel="icon" href='img/ilogo.png' sizes="32x32" type="img/jpg">
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/footer.css">
  <link rel="stylesheet" href="css/contact.css">
  <link rel="stylesheet" href="css/styl.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
  <link rel="stylesheet" href="css2/style.css" />
</head>

<body>
  <?php
  require("connectdb.php");
  include 'sed.php';
  extract($_GET);
  ?>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
    <div class="container-fluid">
      <?php if (@$orden==1) { ?>
        <a class="" href="index.php?productos=1">
          <img src="img/atras.png" style="width: 30px; height: 40px;">
        </a>
      <?php } else { ?>
        <a class="" href="carrito.php">
          <img src="img/atras.png" style="width: 30px; height: 40px;">
        </a>
      <?php } ?>

      <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 16px;" href="#">
        <img src="img/ilogo.png" style="width: 30px; height: 30px;" alt="logo restaurantapp">
        <strong>RestaurantApp</strong>
      </a>

    </div>
  </nav>
  <br><br><br><br>
  <center>
    <h1 style="color:blue; font-size: 22px;"><strong>RESERVA ENVIADA...</strong></h1>
    <?php
    $idlo = $_SESSION['idusu'];
    $consulta = ("SELECT * FROM logueo  WHERE logueo.idusu='$idlo'");
    $query1 = mysqli_query($mysqli, $consulta);
    while ($arre1 = mysqli_fetch_array($query1)) {
      $nom = sed::decryption($arre1[1]);
      $apelli = sed::decryption($arre1[2]);
    }
    ?>
    <img src="img/reservaenviada.png" style="height: 105px;" alt="reservado">
    <p style="font-size: 14px;"><strong>Le enviaremos un mensaje para confirmar su reserva...</strong></p>
    <p><strong>GRACIAS POR SU PREFERENCIA: <?php echo (ucwords($nom) . " " . ucwords($apelli)); ?> </strong></p>
  </center>

  <?php
  include('footer.php');
  ?>
</body>

</html>