<?php
//validar
session_start();
require("connectdb.php");
include("conexion.php");
include 'sed.php';
if (@!$_SESSION['idusu']) {
    echo "<script>location.href='logueo.php'</script>";
} elseif ($_SESSION['rolusu'] == "empresa") {
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
    <title>Detalles venta| RestaurantApp</title>
    <link rel="icon" href='img/ilogo.png' sizes="32x32" type="img/jpg">
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
            <a class="" href="admproductosvendidos.php">
                <img src="img/atras.png" style="width: 30px; height: 40px;">
            </a>
            <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 16px;" href="#">
                <img src="img/ilogo.png" style="width: 30px; height: 30px;" alt="logo restaurantapp">
                <strong>Tienda Only</strong>
            </a>

        </div>
    </nav>
    <br><br>
    <?php
    extract($_GET);
    $id_us = $_SESSION['idusu'];
    $productos_vendidos = mysqli_query($mysqli, "SELECT *FROM reportes_ventas INNER JOIN ordenes on reportes_ventas.id_orden=ordenes.id_orden
  WHERE reportes_ventas.idprod_vendido='$id' and ordenes.estado_orden=2");
    $cantidad = mysqli_num_rows($productos_vendidos);
    $orden = mysqli_fetch_all($productos_vendidos, MYSQLI_ASSOC);

    foreach ($orden as $row2) {
        $id_pv = $row2["idprod_vendido"];
        $id_orden = $row2['id_orden'];
        $idpago_orden = $row2['idpago'];
        $idusu_clientes = $row2['idusu'];
        $id_repartidor = $row2['id_repartidor'];
        $pedidopagosql = "SELECT * FROM pedidopago where idpago='$idpago_orden'";
        $result_pedidopago = mysqli_query($conexion, $pedidopagosql);
        $pedidopagos = mysqli_fetch_all($result_pedidopago, MYSQLI_ASSOC);
        foreach ($pedidopagos as $ro) {
            $idpago = $ro['idpago'];
            $id_cliente = $ro['idusu'];
            $montototal = $ro['montototal'];
        }
        $consul_em = ("SELECT * FROM logueo_empresa  WHERE logueo_empresa.id_empresa='$idlog'");
        $query2em = mysqli_query($mysqli, $consul_em);
        $empresas = mysqli_fetch_all($query2em, MYSQLI_ASSOC);
        foreach ($empresas as $arrayem) {
            $nombreempresa = sed::decryption($arrayem['nombreempresa']);
        }
        $productos_vendidos = mysqli_query($mysqli, "SELECT *FROM pedidoproductos WHERE idpago='$idpago_orden' and id_empresa='$idlog'");
        $cantidadpp = mysqli_num_rows($productos_vendidos);
        ?>
        <center>
            <li style="list-style:none; margin-top: 12px;">
                <div class="invi border-primary " style=" border:2px solid blue; width: 30%;height: 150px;" category="iquitos">
                    <img src="img/reservaenviada.png" style="width: 100%; height: 150px;" alt="imagen invitado">
                    <p class="p">Empresa: <strong style="color:greenyellow;"><?php echo $nombreempresa; ?></strong></p>

                </div>
            </li>
        </center>
        <div class="container-fluid p-2">
            <center>
                <p style="color:blue; font-size: 22px;"><strong>DATOS DE VENTA</strong></p>
            </center>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Cod. venta</th>
                        <th scope="col">Productos vendidos</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Fecha pedido realizado</th>
                    </tr>
                </thead>
                <tbody>
                    <div class="container_card">
                        <tr>
                            <td style="vertical-align: middle;"><?php echo $id_pv; ?></td>
                            <td style="vertical-align: middle;"><?php echo $cantidadpp; ?></td>
                            <td style="vertical-align: middle;">
                                <?php if ($row2['estado_orden'] == 0) {
                                        echo "Pedido enviado";
                                    } else if ($row2['estado_orden'] == 1) {
                                        echo "Pedido en proceso";
                                    } else if ($row2['estado_orden'] == 2) {
                                        echo "Vendido";
                                    } else if ($row2['estado_orden'] == 3) {
                                        echo "Pedido cancelado";
                                    } ?>
                            </td>
                            <td style="vertical-align: middle;"><?php echo $row2['fecha_orden'] . " " . $row2['hora_orden']; ?></td>
                        </tr>
                    </div>
                </tbody>
            </table>
        </div>
        <div class="container-fluid p-2" style="margin-top: -25px;">
            <center>
                <p style="color:blue; font-size: 22px;"><strong>DATOS DE PEDIDO</strong></p>
            </center>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Cod. producto</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <?php
                    $productospedidosql = "SELECT * FROM pedidoproductos where idpago='$idpago' and id_empresa='$idlog'";
                    $result_productospedido = mysqli_query($conexion, $productospedidosql);
                    $productos_pedido = mysqli_fetch_all($result_productospedido, MYSQLI_ASSOC);
                    foreach ($productos_pedido as $rowp) {
                        $id_empresa = $rowp['id_empresa'];
                        $ima_producto = $rowp['imag'];
                        ?>
                    <tbody>
                        <div class="container_card">
                            <tr>
                                <th scope="row" style="vertical-align: middle;"><?php echo $rowp['codigoproducto']; ?></th>
                                <!--<td>
                  <img src="data:image/jpg;base64,<?php //echo $ima_producto; 
                                                            ?>" style="width: 90px; height: 100px;">
                </td>-->
                                <td style="vertical-align: middle;"><?php echo $rowp['cantipedir']; ?></td>
                                <td style="vertical-align: middle;"><?php echo $rowp['nomproducto']; ?></td>
                                <td style="vertical-align: middle;"><?php echo $rowp['categ_producto']; ?></td>
                                <td style="vertical-align: middle;">S/.<?php echo $rowp['precio']; ?></td>
                                <td style="vertical-align: middle;">S/.<?php echo $rowp['precio'] * $rowp['cantipedir']; ?></td>
                            </tr>
                        </div>
                    </tbody>
                <?php } ?>
            </table>
            <li style="margin-top: -16px;" class="list-group-item d-flex justify-content-between">
                <span style="text-align: left; color: #000000;"><strong>Total (SOLES).</strong></span>
                <strong style="text-align: left; color: #000000;">S/.
                    <?php
                        $qcanti = "SELECT SUM(total) preciototal FROM pedidoproductos where idpago='$idpago' and id_empresa='$idlog'";
                        $rcanti = mysqli_query($conexion, $qcanti);
                        $preciocarrito = mysqli_fetch_all($rcanti, MYSQLI_ASSOC);
                        $cantprecio = mysqli_num_rows($rcanti);
                        foreach ($preciocarrito as $rowpreci) {
                            $preci_total = $rowpreci['preciototal'];
                            echo $rowpreci['preciototal'];
                        }
                        ?>
                </strong>
            </li>
            <li style="margin-top: -16px;" class="list-group-item d-flex justify-content-between">
                <span style="text-align: left; color: #000000;"><strong>IGV (SOLES).</strong></span>
                <strong style="text-align: left; color: #000000;"> 0.18
                </strong>
            </li>
            <li style="margin-top: -16px;" class="list-group-item d-flex justify-content-between">
                <span style="text-align: left; color: #000000;"><strong>TOTAL + IGV (SOLES).</strong></span>
                <strong style="text-align: left; color: #000000;"> S/.
                    <?php
                        // Obtener el monto total según cantidad de productos.
                        $preciototal = ($rowp['precio'] * $rowp['cantipedir']);
                        // Obtener IGV.
                        $igv = $preci_total * 0.18;
                        // Monto total a pagar incluido IGV.
                        $monto_total = $preci_total + $igv;
                        echo $monto_total;
                        ?>
                </strong>
            </li>
        </div>
        <center>
            <p style="color:blue; font-size: 22px;"><strong>DATOS DEL PAGO</strong></p>
        </center>
        <div style="margin-left: 16px; margin-top: 3px;">
            <p><strong>Medio de pago: <?php echo $ro['medio']; ?> </strong></p>
            <p><strong>Estado pago: <?php echo $ro['estadopago']; ?> </strong></p>
            <?php if ($_SESSION['rolusu'] == "user" || $_SESSION['rolusu'] == "a1") {
                    $repartidorsql = "SELECT * FROM logueo_repartidor where id_repartidor='$id_repartidor'";
                    $result_repartidor = mysqli_query($conexion, $repartidorsql);
                    $repartidor = mysqli_fetch_all($result_repartidor, MYSQLI_ASSOC);
                    foreach ($repartidor as $arrayr) { } ?>
                <?php if ($row2['estado_orden'] == 1) { // cuando la orden se entregó al cliente 
                            ?>
                    <p style="color: green;"><strong>Pedido tomado por repartidor: <?php echo sed::decryption($arrayr['nombre_repartidor']) . " " . sed::decryption($arrayr['apellido_repartidor']); ?> </strong></p>
                <?php } else if ($row2['estado_orden'] == 2) { // cuando la orden se entregó al cliente 
                            ?>
                    <p style="color: green;"><strong>Pedido entregado por repartidor: <?php echo sed::decryption($arrayr['nombre_repartidor']) . " " . sed::decryption($arrayr['apellido_repartidor']); ?> </strong></p>
                <?php } ?>
            <?php } ?>
        </div>

        <div style="margin-left: 16px; margin-top: 3px;">
            <form action="" method="post" style="margin-top: 0px;">
                <div class="row g-3">
                    <div class="col">
                        <input type="hidden" name="idestadoorden" value="<?php echo $id_orden; ?>">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col">
                        <?php if ($_SESSION['rolusu'] == "user") { ?>
                            <?php if ($row2['estado_orden'] == 2) { // cuando la orden se entregó al cliente 
                                        ?>
                            <?php } elseif ($row2['estado_orden'] == 3) { //cuando la orden ha sido cancelado 
                                        ?>
                                <input type="submit" style="width:50%; margin-top: -1px; color:blue;" class="btn btn-danger" name="ordeneliminado" value="Eliminar">
                            <?php } elseif ($row2['estado_orden'] == 0 || $row2['estado_orden'] == 1) { //Cuand la orden está enviado o en proceso puede cancelar 
                                        ?>
                                <input type="submit" style="width:50%; margin-top: -1px; color:blue;" class="btn btn-success" name="cambiarestado" value="Cancelar pedido">
                            <?php } ?>
                        <?php } elseif ($_SESSION['rolusu'] == "repartidor") { ?>
                            <?php if ($row2['estado_orden'] == 0) { ?>
                                <?php if ($id_repartidor != $_SESSION['idusu']) { ?>
                                    <input type="submit" style="width:50%; margin-top: -1px; color:blue;" class="btn btn-success" name="tomarpedido" value="Tomar pedido">
                                <?php } else { ?>
                                <?php } ?>
                            <?php } elseif ($row2['estado_orden'] == 1) { ?>
                                <?php if ($id_repartidor == $_SESSION['idusu']) { ?>
                                    <input type="submit" style="width:50%; margin-top: -1px; color:blue;" class="btn btn-success" name="pedidoentregado" value="Pedido entregado">
                                <?php } else { ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </form>
            <?php
                if ($_SESSION['rolusu'] == "repartidor") {
                    if (isset($_POST['tomarpedido'])) {
                        $idestadoorden = $_POST['idestadoorden'];
                        $sqlborrar = "UPDATE ordenes SET ordenes.estado_orden = '1' , ordenes.id_repartidor = '$id_us' WHERE ordenes.id_orden='$idestadoorden'";
                        $resborrar = mysqli_query($mysqli, $sqlborrar);
                        if ($resborrar) {
                            echo '<div class="alert alert-primary" role="alert">Eliminado exitosamente. </div>';
                            echo "<script>location.href='detalleorden.php?id=$id&ft=1'</script>";
                        } else {
                            echo "Error: " . $sqlborrar . "<br>" . mysqli_error($mysqli);
                            //echo "<script>location.href='registro.php'</script>";
                        }
                    }
                    if (isset($_POST['pedidoentregado'])) {
                        $idestadoorden = $_POST['idestadoorden'];
                        $sqlborrar = "UPDATE ordenes SET ordenes.estado_orden = '2' WHERE ordenes.id_orden='$idestadoorden'";
                        $resborrar = mysqli_query($mysqli, $sqlborrar);
                        if ($resborrar) {
                            echo '<div class="alert alert-primary" role="alert">Eliminado exitosamente. </div>';
                            echo "<script>location.href='admreserva.php'</script>";
                        } else {
                            echo "Error: " . $sqlborrar . "<br>" . mysqli_error($mysqli);
                            //echo "<script>location.href='registro.php'</script>";
                        }
                    }
                } elseif ($_SESSION['rolusu'] == "user") {
                    if (isset($_POST['cambiarestado'])) {
                        $idestadoorden = $_POST['idestadoorden'];
                        $sqlborrar = "UPDATE ordenes SET ordenes.estado_orden = '3' 
                                                WHERE ordenes.id_orden='$idestadoorden'";
                        $resborrar = mysqli_query($mysqli, $sqlborrar);
                        if ($resborrar) {
                            //echo '<div class="alert alert-primary" role="alert">Cancelado exitosamente. </div>';
                            echo "<script>location.href='detalleorden.php?id=$id_orden&ft=1'</script>";
                        } else {
                            echo "Error: " . $sqlborrar . "<br>" . mysqli_error($mysqli);
                            //echo "<script>location.href='registro.php'</script>";
                        }
                    }
                    if (isset($_POST['ordeneliminado'])) {
                        $idestadoorden = $_POST['idestadoorden'];
                        $sqlborrar = "UPDATE ordenes SET ordenes.ordeneliminado_cliente = '1'  WHERE ordenes.id_orden='$idestadoorden'";
                        $resborrar = mysqli_query($mysqli, $sqlborrar);
                        if ($resborrar) {
                            echo '<div class="alert alert-primary" role="alert">Eliminado exitosamente. </div>';
                            echo "<script>location.href='index.php?vereservas=1'</script>";
                        } else {
                            echo "Error: " . $sqlborrar . "<br>" . mysqli_error($mysqli);
                            //echo "<script>location.href='registro.php'</script>";
                        }
                    }
                }
                ?>
        </div>
    <?php } ?>
</body>

</html>