<?php
session_start();
if (@!$_SESSION['idusu']) {
    echo "<script>location.href='logueo.php'</script>";
} elseif ($_SESSION['rolusu'] == "a1") { } else {
    echo "<script>location.href='logueo.php'</script>";
}
?>
<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalles de la reserva|Periko's</title>
    <link rel="icon" href='img/logokillari.jpg' sizes="32x32" type="img/jpg">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/estilosgaleria.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="css/styl.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="js/jquery-3.2.1.js"></script>
    <script src="js/script.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
        <div class="container-fluid">
            <a class="" href="admreserva.php">
                <img src="img/atras.png" style="width: 30px; height: 40px;">
            </a>
            <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 15px;" href="#">
                <img src="img/logokillari.jpg" style="width: 30px; height: 30px;" alt="logo killaripostres">
                <strong>Periko's</strong>
            </a>
        </div>
    </nav><br><br><br>
    <?php
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
        <p>
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
                                <option value="3">Cancelar orden</option>
                                <option value="0">Enviar orden</option>
                            </select>
                        </div>
                        <div class="col">
                            <input type="submit" style="width: 95%; margin-top: -5px; float:left;" class="btn btn-success" name='cambiarestado' value="Cambiar estado">
                        </div>
                    </div>
                </form>
            </strong>
        </p>
    </div>
                                                    <?php }?>
    <?php
    if (isset($_POST['cambiarestado'])) {
        $estadopedido = $_POST['estadopedido'];
        $baneo = mysqli_query($conexion, "UPDATE reservas SET reservas.estado= '$estadopedido' WHERE reservas.id_reserva='$id_reserva'");
        if ($baneo) {
            echo "<script>location.href='editreseradmin.php?id_reserva=$id_reserva'</script>";
        } else {
            echo '<div class="alert alert-danger" role="alert">No se cambió el estado. </div>';
        }
    }
    ?>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>