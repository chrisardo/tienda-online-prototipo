<?php
session_start();
/*if ($_SESSION['rol'] == "user") {
  if ((time() - $_SESSION['last_login_timestamp']) > 240) { // 900 = 15 * 60  
      setcookie("cerrarsesion", 1, time() + 60000); //6o segundos es 1 minuto, 86400 segundos es por 24 horas
      echo "<script>location.href='desconectar.php'</script>";
  } else {
      $_SESSION['last_login_timestamp'] = time();
  }
}*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Politica de privacidad | Perikos</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
  <link rel="stylesheet" href="css2/style.css" />
  <link href="css/main.css" rel="stylesheet" />
  <link rel=icon href='img/logo.png' sizes="32x32" type="image/jpeg">
</head>

<body>
  <?php
  extract($_GET);
  require("connectdb.php");
  include("conexion.php");
  include 'sed.php';
  ?>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
    <div class="container-fluid">
      <div class="navbar-brand ">
        <?php
        if (@$priv==1) {
          //echo "Diferente". $emai. " ". $correo;
          ?>
          <a href="rgistrarse.php"><img src="img/atras.png" style="width: 36px; height: 40px;"></a>
        <?php
        } else {
          ?>
          <a href="opciones.php"><img src="img/atras.png" style="width: 36px; height: 40px;"></a>
        <?php
        }
        ?>
        <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto">
          <img src="img/logo.png" style="width: 36px; height: 40px;">Perikos
        </a>
      </div>
    </div>
  </nav><br><br><br><br>
  <center>
    <div class="card border-primary mb-3" style="max-width: 90%;">
      <div class="card-header" style="color: blue;">Politica de condiciones y privacidad</div>
      <div class="card-body text-primary">
        <p class="card-text" style="color: black; text-align:initial;">
          La aplicación contiene funciones como ver tipos de tortas, también hacer su pedido, con el objetivo de que los usuarios puedan ver información de los costos de las tortas y reservar.<br>
          En consecuencia, la aplicacion puede pedirle al usuario que ingrese datos personales como su celular, dirección, distrito para que al momento de la entrega el repartidor conosca su ubicación para la entrega de su pedido.<br>
          Estos datos personales no se muestran a otros usuarios de la aplición. Estos datos no se comparten ni entrega con ninguna entidad ni con terceras organizaciones como son las empresas de marketing entre otros.<br>
          Nuestros datos están encryptados con la seguridad moderna para que personas no deseables no puedan ver sus información, solo el encargado de ver los pedidos de los usuarios vea la información.<br>
          Los usuarios pueden cancelar sus pedidos en la opcion de PEDIDOS de la aplicacion. No rastreamos ni mucho menos espiamos a los usuarios como por medio de su IP. Permitimos que empresas de terceros publiquen anuncios y recopilen cierta información anónima cuando visita nuestra aplicación.<br>
          Estas empresas pueden utilizar información anónima, como el tipo y versión de su dispositivo, la actividad de navegación, la ubicación y otros datos técnicos relacionados con su dispositivo, para proporcionar anuncios.
        </p>
      </div>
    </div>
  </center>
</body>

</html>