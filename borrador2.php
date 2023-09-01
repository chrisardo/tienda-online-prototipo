<?php
    require("connectdb.php");
    include("conexion.php");
    include 'sed.php';
    $idlog = @$_SESSION['idusu'];
    echo $idlog;
    $productos_vendidos = mysqli_query($mysqli, "SELECT *FROM productos_vendidos WHERE id_empresa='$idlog'");
    $productosvendidos = mysqli_fetch_all($productos_vendidos, MYSQLI_ASSOC);
    foreach ($productosvendidos as $rowpv) {
        $id_pv = $rowpv["idprod_vendido"];
        $idorden_pv = $rowpv["id_orden"];
        //echo $idorden_pv;
        //}
        $queryorden = "SELECT *FROM ordenes WHERE estado_orden=2 and id_orden='$idorden_pv'";
        $resultorden = mysqli_query($conexion, $queryorden);
        $orden = mysqli_fetch_all($resultorden, MYSQLI_ASSOC);
        $cantorden = mysqli_num_rows($resultorden);
        //if ($cantorden > 0) {
        ?>
        <div style="width: 96%; margin-left: 10px; border:2px solid blue; margin-top:4px;">
            <div style="width: 100%; border:2px solid blue;">
                <img src="img/ordenes.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">
                <h1 style="display: inline-block; font-size: 16px;">Productos vendidos: <?php echo $cantorden; ?></h1>
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
                    ?>
                <div style="width: 99%; margin-left: 10px;">
                    <div style="display: inline-block; ">
                        <img src="img/reservaenviada.png" style="width: 96px; height: 110px; margin-top: -110px;">
                    </div>
                    <div style="display: inline-block;">
                        <p style="color:blue; margin-top: -15px;">
                            Cod: <strong><?php echo $rowpv['idprod_vendido']; ?></strong>
                        </p>
                        <p style="color:blue; margin-top: -15px;">
                            Medio pago: <strong><?php echo $ro['medio']; ?></strong>
                        </p>
                        <p style="margin-left: 1px; margin-top: -15px;"><strong>Estado orden:
                                <?php
                                        if ($row2['estado_orden'] == 0) {
                                            echo "Pedido enviado";
                                        } else if ($row2['estado_orden'] == 1) {
                                            echo "Pedido en proceso";
                                        } else if ($row2['estado_orden'] == 2) {
                                            echo "Pedido entregado";
                                        } else if ($row2['estado_orden'] == 3) {
                                            if ($_SESSION['rolusu'] == "user") {
                                                echo "Cancelaste tu orden";
                                            } else {
                                                echo "Canceló orden";
                                            }
                                        }  ?></strong></p>
                        <div style="margin-top: -15px; ">
                            <div style="display: inline-block;">
                                <p>
                                    <strong>Pedido realizado el: <?php echo $fecha_orden . " " . $hora_orden; ?> </strong>
                                </p>
                            </div>
                            <div style="display: inline-block;">
                                <p style="margin-left: 25px; color:orangered; font-size: 22px; margin-top: -40px;">
                                    <strong>S/. <?php echo $ro['montototal']; ?></strong>
                                </p>
                            </div>
                        </div>
                        <a class="btn btn-primary" href="detalleorden.php?id=<?php echo $id_orden; ?>&ft=1" style="width:70px; margin-top: -16px;" role="button" value="Ver torta">
                            <strong> Ver</strong>
                        </a>
                    </div>
                </div>
                <div style="width: 90%; margin-left: 16px; background: blue; height: 3px; margin-top: 4px;"></div>
            <?php } ?>
        </div>
    <?php }/*} else { ?>
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
                        <strong>PRODUCTOS VENDIDOS</strong></h3>

                    <p class="text-justify">
                        <center>
                            <strong style="color:white;">
                                Aquí se mostrarán los productos que has vendido.</strong>
                        </center>
                    </p>
                    </p>
                </div>
            </div>
        </div>
    <?php }*/ ?>