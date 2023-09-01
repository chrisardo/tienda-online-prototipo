<br><br><br>
<?php
include_once('class/database.php');
//echo $id_us;
if ($_SESSION['rolusu'] == "a1") {
  $queryorden = "SELECT *FROM ordenes ORDER BY id_orden DESC";
} elseif ($_SESSION['rolusu'] == "user") {
  $queryorden = "SELECT * FROM ordenes
         WHERE idusu='$idlog' and ordeneliminado_cliente =0 ORDER BY id_orden DESC";
} elseif ($_SESSION['rolusu'] == "repartidor") {
  $queryorden = "SELECT *FROM ordenes WHERE estado_orden!=2 ORDER BY id_orden DESC";
}
$resultorden = mysqli_query($conexion, $queryorden);
$orden = mysqli_fetch_all($resultorden, MYSQLI_ASSOC);
$cantorden = mysqli_num_rows($resultorden);
if ($cantorden > 0) {
  ?>
  <div style="width: 96%; margin-left: 10px; border:2px solid blue; margin-top:4px;">
    <div style="width: 100%; border:2px solid blue;">
      <img src="img/ordenes.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">
      <h1 style="display: inline-block; font-size: 16px;">Pedidos: <?php echo $cantorden; ?></h1>
    </div>
    <?php
      foreach ($orden as $row2) {
        $id_orden = $row2['id_orden'];
        $idpago_orden = $row2['idpago'];
        $idusu_clientes = $row2['idusu'];
        $id_repartidor = $row2['id_repartidor'];
        $fecha_orden = $row2['fecha_orden'];
        $hora_orden = $row2['hora_orden'];
        $ordeneliminado_cliente = $row2['ordeneliminado_cliente'];
        $pedidopagosql = "SELECT * FROM pedidopago where idpago='$idpago_orden'";
        $result_pedidopago = mysqli_query($conexion, $pedidopagosql);
        $pedidopagos = mysqli_fetch_all($result_pedidopago, MYSQLI_ASSOC);
        foreach ($pedidopagos as $ro) {
          $id_cliente = $ro['idusu'];
          $montototal = $ro['montototal'];
        }
        $clientesql = "SELECT * FROM logueo where idusu='$idusu_clientes'";
        $result_cliente = mysqli_query($conexion, $clientesql);
        $clientes = mysqli_fetch_all($result_cliente, MYSQLI_ASSOC);
        foreach ($clientes as $arrayu) { }
        ?>
      <?php if ($_SESSION['rolusu'] == "repartidor") {
            if ($ordeneliminado_cliente == 0) {
              if ($_SESSION['idusu'] && $id_repartidor == $_SESSION['idusu'] && $row2['estado_orden'] == 1) {
                require("ordenes.php");
              }else if ($_SESSION['idusu'] && $id_repartidor != $_SESSION['idusu'] && $row2['estado_orden'] != 1) {
                require("ordenes.php");
              }
            } ?>
      <?php  } else if ($_SESSION['rolusu'] == "user" || $_SESSION['rolusu'] == "a1") {
            require("ordenes.php");
          } ?>
    <?php } ?>
  </div>
<?php } else { ?>
  <div class=" container container-web-page ">
    <div class=" row justify-content-md-center border-primary" style="background-color: orange;border-radius: 35px; width: 100%; margin-left: 0;">
      <div class="col-12 col-md-6">
        <figure class="full-box">
          <center>
            <img src="img/ordenes.png" alt="registration_killaripostres" class="img-fluid">
          </center>
        </figure>
      </div>
      <div class="w-100"></div>
      <div class="col-12 col-md-6">
        <h3 style="color:white;" class="text-center text-uppercase poppins-regular font-weight-bold">
          <strong>MIS ORDENES</strong></h3>

        <p class="text-justify">
          <center>
            <strong style="color:white;">
              Aquí se mostrarán los pedidos que ordenes.</strong>
          </center>
        </p>
        </p>
      </div>
    </div>
  </div>
<?php } ?>