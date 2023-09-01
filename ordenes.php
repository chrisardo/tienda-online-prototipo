<div style="width: 99%; margin-left: 10px;">
    <div style="display: inline-block; ">
        <img src="img/reservaenviada.png" style="width: 96px; height: 110px; margin-top: -110px;">
    </div>
    <div style="display: inline-block;">
        <p style="color:blue; ">Cliente:
            <strong><?php echo sed::decryption($arrayu["nombreusu"]) . " " .  sed::decryption($arrayu["apellidousu"]); ?></strong>
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
                    <strong>Pedido realizado el: <?php echo $fecha_orden." ".$hora_orden; ?> </strong>
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
        <form action="" method="post" style="width:110px; display: inline-block; margin-top: -30px;">
            <input type="hidden" name="idestadoorden" value="<?php echo $id_orden; ?>">
            <?php
            if ($_SESSION['rolusu'] == "user") { ?>
                <?php if ($row2['estado_orden'] == 2) { // cuando la orden se entregó al cliente 
                        ?>
                <?php } elseif ($row2['estado_orden'] == 3) { ?>
                    <input type="submit" style="width:110px; margin-top: -15px;" class="btn btn-danger" name="ordeneliminado" value="Eliminar">
                <?php } elseif ($row2['estado_orden'] == 0 || $row2['estado_orden'] == 1) { //Cuando la orden está enviado o en proceso puede cancelar ?>
                    <input type="submit" style="width:150px; margin-top: -15px; color:white;" class="btn btn-warning" name="cambiarestado" value="Cancelar pedido">
                <?php } ?>
            <?php } elseif ($_SESSION['rolusu'] == "a1") { ?>
                <?php if ($row2['idusu'] == 0 && $row2['id_empresa'] == 0) {
                        ?>
                    <input type="submit" style="width:110px; margin-top: -15px;" class="btn btn-danger" name="ordeneliminado" value="Eliminar">
                <?php } ?>
            <?php } ?>
        </form>
        <?php
        if ($_SESSION['rolusu'] == "empresa") {
            if (isset($_POST['ordeneliminado'])) {
                $idestadoorden = $_POST['idestadoorden'];
                $sqlborrar = "UPDATE ordenes SET ordenes.id_empresa = '0'  WHERE ordenes.id_orden='$idestadoorden'";
                $resborrar = mysqli_query($mysqli, $sqlborrar);
                if ($resborrar) {
                    echo '<div class="alert alert-primary" role="alert">Eliminado exitosamente. </div>';
                    echo "<script>location.href='index.php?vereservas=1'</script>";
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
                    //echo '<div class="alert alert-primary" role="alert">Eliminado exitosamente. </div>';
                    echo "<script>location.href='index.php?vereservas=1'</script>";
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
</div>
<div style="width: 90%; margin-left: 16px; background: blue; height: 3px; margin-top: 4px;"></div>