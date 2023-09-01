<?php
session_start();
if (@!$_SESSION['idusu']) {
    echo "<script>location.href='logueo.php'</script>";
} elseif ($_SESSION['rolusu'] == "empresa") {
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
    <link rel="icon" href='img/ilogo.png' sizes="32x32" type="img/jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css2/style.css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
        <div class="container-fluid">
            <div class="navbar-brand ">
                <a href="adm.php"><img src="img/atras.png" style="width: 30px; height: 36px;"></a>
                <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 13px;">
                    <img src="img/ilogo.png" style="width: 28px; height: 36px;">
                </a>
            </div>
            <!--<a class="navbar-brand order-1 order-justify-content-end" style="margin:-9px;">
                <form class="form-inline my-2 my-lg-0 align-self-stretch" name="buscador" action="admreserva.php" method="POST">
                    <input class="form-control mr-sm-2" style="width: 200px;" type="text" name="word" placeholder="Buscar ordenes" aria-label="Search" />
                    <button class="btn btn-success my-2 my-sm-0" style="width: 67px;" name="buscarorden" value="Buscar" type="submit">
                        Buscar
                    </button>
                </form>
            </a>-->
        </div>
    </nav><br><br><br>
    <?php
    require("connectdb.php");
    include("conexion.php");
    include 'sed.php';
    $idlog = @$_SESSION['idusu'];
    echo $idlog;
    $productos_vendidos = mysqli_query($mysqli, "SELECT *FROM productos_vendidos INNER JOIN ordenes on productos_vendidos.id_orden=ordenes.id_orden
    WHERE productos_vendidos.id_empresa='$idlog' and ordenes.estado_orden=2");
    $productosvendidos = mysqli_fetch_all($productos_vendidos, MYSQLI_ASSOC);
    $cantpv = mysqli_num_rows($productos_vendidos);
    ?>
    <div style="width: 96%; margin-left: 10px; border:2px solid blue; margin-top:4px;">
        <div style="width: 100%; border:2px solid blue;">
            <img src="img/ordenes.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">
            <h1 style="display: inline-block; font-size: 16px;">Productos vendidos: <?php echo $cantpv; ?></h1>
        </div>
        <?php
        if ($cantpv > 0) {
            foreach ($productosvendidos as $rowpv) {
                $id_pv = $rowpv["idprod_vendido"];
                $idorden_pv = $rowpv["id_orden"];
                /*$queryorden = mysqli_query($conexion, "SELECT *FROM ordenes WHERE estado_orden=2 and id_orden='$idorden_pv'");
                $orden = mysqli_fetch_all($queryorden, MYSQLI_ASSOC);
                $cantorden = mysqli_num_rows($queryorden);
                if ($cantorden > 0) {
                    foreach ($orden as $row2)*/ {
                    $id_orden = $rowpv['id_orden'];
                    $idpago_orden = $rowpv['idpago'];
                    $idusu_clientes = $rowpv['idusu'];
                    $id_repartidor = $rowpv['id_repartidor'];
                    $fecha_orden = $rowpv['fecha_orden'];
                    $hora_orden = $rowpv['hora_orden'];
                    $ordeneliminado_cliente = $rowpv['ordeneliminado_cliente'];
                }
                $productospedidosql = mysqli_query($conexion, "SELECT SUM(total) preciototal FROM pedidoproductos 
                where idpago='$idpago_orden' and id_empresa='$idlog'");
                $productos_pedido = mysqli_fetch_all($productospedidosql, MYSQLI_ASSOC);
                foreach ($productos_pedido as $rowp) {
                    $total_producto = $rowp['preciototal'];
                }
                $productos_vendidos = mysqli_query($mysqli, "SELECT *FROM pedidoproductos WHERE idpago='$idpago_orden' and id_empresa='$idlog'");
                $cantidadpp = mysqli_num_rows($productos_vendidos);
                /*$pedidopagosql = "SELECT * FROM pedidopago where idpago='$idpago_orden'";
                    $result_pedidopago = mysqli_query($conexion, $pedidopagosql);
                    $pedidopagos = mysqli_fetch_all($result_pedidopago, MYSQLI_ASSOC);
                    foreach ($pedidopagos as $ro) {
                        $id_cliente = $ro['idusu'];
                        $montototal = $ro['montototal'];
                    }*/
                ?>
                <div style="width: 99%; margin-left: 10px;">
                    <div style="display: inline-block; ">
                        <img src="img/reservaenviada.png" style="width: 96px; height: 110px; margin-top: -110px;">
                    </div>
                    <div style="display: inline-block;">
                        <p style="color:blue;">
                            Cod. Venta: <strong><?php echo $rowpv['idprod_vendido']; ?></strong>
                        </p>
                        <p style="color:blue; margin-top: -15px;">
                            Productos vendidos: <strong><?php echo $cantidadpp; ?></strong>
                        </p>
                        <p style="margin-left: 1px; margin-top: -15px;"><strong>Estado:
                                <?php
                                        if ($rowpv['estado_orden'] == 0) {
                                            echo "Pedido enviado";
                                        } else if ($rowpv['estado_orden'] == 1) {
                                            echo "Pedido en proceso";
                                        } else if ($rowpv['estado_orden'] == 2) {
                                            echo "vendido";
                                        } else if ($rowpv['estado_orden'] == 3) {
                                            if ($_SESSION['rolusu'] == "user") {
                                                echo "Cancelaste tu orden";
                                            } else {
                                                echo "Canceló orden";
                                            }
                                        }  ?></strong></p>
                        <div style="margin-top: -15px; ">
                            <div style="display: inline-block;">
                                <p>
                                    <strong>Pedido vendido el: <?php echo $fecha_orden . " " . $hora_orden; ?> </strong>
                                </p>
                            </div>
                            <div style="display: inline-block;">
                                <p style="margin-left: 25px; color:orangered; font-size: 22px; margin-top: -40px;">
                                    <strong>S/. <?php echo $total_producto; ?></strong>
                                </p>
                            </div>
                        </div>
                        <a class="btn btn-primary" href="detallereporteventa.php?id=<?php echo $id_pv; ?>&ft=1" style="width:70px; margin-top: -16px;" role="button" value="Ver torta">
                            <strong> Ver</strong>
                        </a>
                    </div>
                </div>
                <div style="width: 90%; margin-left: 16px; background: blue; height: 3px; margin-top: 4px;"></div>
            <?php } ?>
    </div>
<?php } else { ?>
    <div class=" container container-web-page ">
        <div class=" row justify-content-md-center border-primary" style="border-radius: 35px; width: 100%; margin-top: 5px;">
            <div class="col-12 col-md-6">
                <figure class="full-box">
                    <center>
                        <img src="img/ordenes.png" style="width: 100px; height: 100px;" alt="registration_killaripostres" class="img-fluid">
                    </center>
                </figure>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-md-6">
                <h3 style="color:green;" class="text-center text-uppercase poppins-regular font-weight-bold">
                    <strong>PRODUCTOS VENDIDOS</strong></h3>

                <p class="text-justify">
                    <center>
                        <strong style="color:green;">
                            Aquí se mostrarán los productos que has vendido.</strong>
                    </center>
                </p>
                </p>
            </div>
        </div>
    </div>
<?php } ?>
</body>

</html>