<?php
//validar
session_start();
require("connectdb.php");
include("conexion.php");
include 'sed.php';
if (@!$_SESSION['idusu']) {
  echo "<script>location.href='logueo.php'</script>";
} elseif ($_SESSION['rolusu'] == "a1") {
  /* if ((time() - $_SESSION['last_login_timestamp']) > 240) { // 900 = 15 * 60  
    setcookie("cerrarsesion", 1, time() + 60000); //6o segundos es 1 minuto, 86400 segundos es por 24 horas
    echo "<script>location.href='desconectar.php'</script>";
  } else {
    $_SESSION['last_login_timestamp'] = time();
  }*/ } else {
  echo "<script>location.href='logueo.php'</script>";
}
@$idlog = @$_SESSION['idusu'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>Detalles del orden| RestaurantApp</title>
  <link rel="icon" href='img/logo.png' sizes="32x32" type="img/jpg">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
  <link rel="stylesheet" href="css2/style.css" />

  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/footer.css">
  <link rel="stylesheet" href="css2/invitado.css">
  <link rel="stylesheet" href="css/estilosgaleria.css">
  <link rel="stylesheet" href="css/contact.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
    <div class="container-fluid">
      <a class="" href="admreserva.php">
        <img src="img/atras.png" style="width: 30px; height: 40px;">
      </a>
      <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 16px;" href="#">
        <img src="img/logo.png" style="width: 30px; height: 30px;" alt="logo restaurantapp">
        <strong>Periko's</strong>
      </a>

    </div>
  </nav>
  <br><br>
  <?php
  extract($_GET);
  $id_us = $_SESSION['idusu'];
  $query = "SELECT*FROM ordenes WHERE ordenes.id_orden=$id order by id_orden desc";
  $resul_cant = mysqli_query($conexion, $query);
  $cantidad = mysqli_num_rows($resul_cant);
  $orden = mysqli_fetch_all($resul_cant, MYSQLI_ASSOC);

  foreach ($orden as $row2) {
    $id_orden = $row2['id_orden'];
    $imag_pro = $row2['imag'];
    $nomproducto = $row2['nomproducto'];
    $categ_producto = $row2['categ_producto'];
    $cantipedir = $row2['cantiproduct'];
    $preciotota = $row2['preciototal'];
    $distrito = sed::decryption($row2['distrito']);
    $hor_entrega = $row2['hora_entrega'];
    $fecha_entre = sed::decryption($row2['fecha_entrega']);
    $fechayhoraroden = $row2['fechayhoraroden'];
    $celularu = $row2['celularu'];
    $direccion_orden = sed::decryption($row2['direccion_orden']);
    $referenciadireccion = sed::decryption($row2['referenciadireccion']);
    $estado = $row2['estado_orden'];
    ?>
    <center>
      <li>
        <div class="invi border-primary " style=" border:2px solid blue; width: 50%;height: 180%;" category="iquitos">
          <img src="data:image/jpg;base64,<?php echo $imag_pro; ?>" style="width: 100%" alt="imagen invitado">

          <p class="p"><?php echo $nomproducto; ?></p>

        </div>
      </li>
    </center>
    <div style="margin-left: 16px; margin-top: 3px;">
      <h1 style="color:blue;"><strong>Detalles de tu orden</strong></h1>
      <p><strong>Categoria: <?php echo $categ_producto ?> </strong></p>
      <p><strong>Cantidad a pedir: <?php echo $cantipedir; ?> unidades </strong></p>
      <p><strong>Precio Total: S/.<?php echo $preciotota; ?> </strong></p>
      <p><strong>Distrito: <?php echo $distrito; ?> </strong></p>
      <p><strong>Dirección entrega: <?php echo $direccion_orden; ?> </strong></p>
      <p><strong>Fecha entrega: <?php echo $fecha_entre; ?> </strong></p>
      <p><strong>Hora entrega: <?php echo $hor_entrega; ?> </strong></p>
      <p >
        <img src="img/reserv.png" style="width: 30px; height: 30px; margin-top: -10px;">
        <strong><?php echo $fechayhoraroden; ?> </strong>
      </p>
      <p style="float: left; display: inline-block;"><strong>Estado de orden:
          <form action="" style=" margin-left: 6px; margin-top: -2px;" method="post" class="formulario column  bg-orange">
            <div class="row g-3" style="float: left; ">
              <div class="col">
                <select id="estado" style="border:2px solid green; color:green; margin-left: 6px; width: 110%;" name="estadoorden" class="form-control">
                  <option value="<?php if ($estado == 0) {
                                      echo "Orden enviado";
                                    } else if ($estado == 1) {
                                      echo "Orden en proceso";
                                    } else if ($estado == 2) {
                                      echo "Pedido entregado";
                                    } else if ($estado == 3) {
                                      echo "Cancelaste tu orden";
                                    } ?>" selected=""><?php if ($estado == 0) {
                                                          echo "Orden enviado";
                                                        } else if ($estado == 1) {
                                                          echo "Orden en proceso";
                                                        } else if ($estado == 2) {
                                                          echo "Pedido entregado";
                                                        } else if ($estado == 3) {
                                                          echo "Cancelaste tu orden";
                                                        } ?></option>
                  <option value="1">Orden en proceso</option>
                  <option value="2">Pedido entregado</option>
                </select>
              </div>
              <div class="col">
                <input type="submit" style="width: 95%; margin-top: -5px; float:left;" class="btn btn-success" name='cambiarestado' value="Cambiar estado">
              </div>
            </div>
          </form>

          <?php
            if (isset($_POST['cambiarestado'])) {
              $estadoorden = $_POST['estadoorden'];
              $eo = mysqli_query($mysqli, "UPDATE ordenes SET ordenes.estado_orden = '$estadoorden' 
              WHERE ordenes.id_orden='$id_orden'");
              if ($eo) {
                echo "<script>location.href='editarreservasadm.php?id=$id_orden&ft=1'</script>";
              } else {
                echo '<div class="alert alert-danger" role="alert">No se cambió el estado. </div>';
              }
            }
            ?>
        </strong>
      </p>
    </div>
  <?php } ?>
</body>

</html>