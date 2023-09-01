<?php
//validar
session_start();
require("connectdb.php");
include("conexion.php");
include 'sed.php';
if (@!$_SESSION['idusu']) {
    echo "<script>location.href='logueo.php'</script>";
} elseif ($_SESSION['rolusu'] == "user") {
    /* if ((time() - $_SESSION['last_login_timestamp']) > 240) { // 900 = 15 * 60  
    setcookie("cerrarsesion", 1, time() + 60000); //6o segundos es 1 minuto, 86400 segundos es por 24 horas
    echo "<script>location.href='desconectar.php'</script>";
  } else {
    $_SESSION['last_login_timestamp'] = time();
  }*/ } else {
    echo "<script>location.href='logueo.php'</script>";
}
@$idlog = @$_SESSION['idusu'];
extract($_GET);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Carrito de compras| RestaurantApp</title>
    <link rel="icon" href='img/carrito.png' sizes="32x32" type="img/jpg">
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
            <a class="" href="verproducto.php?idproducto=<?php echo $idproducto; ?>">
                <img src="img/atras.png" style="width: 30px; height: 40px;">
            </a>
            <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 16px;" href="#">
                <img src="img/ilogo.png" style="width: 30px; height: 30px;" alt="logo restaurantapp">
                <strong>Periko's</strong>
            </a>

        </div>
    </nav>
    <br><br>
    <?php
    $query = "SELECT*FROM productos WHERE productos.idproducto=$idproducto";
    $resul_cant = mysqli_query($conexion, $query);
    $cantidad = mysqli_num_rows($resul_cant);
    $pro = mysqli_fetch_all($resul_cant, MYSQLI_ASSOC);
    foreach ($pro as $ro) {
        $idprod = $ro['idproducto'];
        $image = base64_encode($ro['imagproducto']);
        $nombrepro = sed::decryption($ro['nombreproducto']);
        $costopro = sed::decryption($ro['costoproducto']);
        $detallepro = sed::decryption($ro['detalleproducto']);
        $idcategprod = $ro['codigocate'];
        $idusu_empresa = $ro['id_empresa'];

        $querycat = "SELECT*FROM categoria where codigocate='$idcategprod' ORDER BY idcategoria DESC";
        $resultcat = mysqli_query($conexion, $querycat);
        $catego = mysqli_fetch_all($resultcat, MYSQLI_ASSOC);
        foreach ($catego as $row2) {
            $id_categ = $row2['idcategoria'];
            $imag_categ = base64_encode($row2['imagen']);
            $nombre_categ = sed::decryption($row2['nombrecateg']);
            $descripcion_categ = sed::decryption($row2['descripcioncateg']);
        }
        $consul_em = ("SELECT * FROM logueo_empresa  WHERE logueo_empresa.id_empresa='$idusu_empresa'");
        $query2em = mysqli_query($mysqli, $consul_em);
        $empresas = mysqli_fetch_all($query2em, MYSQLI_ASSOC);
        foreach ($empresas as $arrayem) {
            $nombreempresa = sed::decryption($arrayem['nombreempresa']);
        }
        $clientesql = "SELECT * FROM logueo where idusu='$idlog'";
        $result_cliente = mysqli_query($conexion, $clientesql);
        $clientes = mysqli_fetch_all($result_cliente, MYSQLI_ASSOC);
        foreach ($clientes as $arrayu) { }
    }
    ?>
    <center>
        <li>
            <div class="invi border-primary " style=" border:2px solid blue; width: 50%;height: 180%;" category="iquitos">
                <img src="img/reservaenviada.png" style="width: 100%; height: 150px;" alt="imagen invitado">
                <p class="p"><?php echo sed::decryption($arrayu["nombreusu"]) . " " .  sed::decryption($arrayu["apellidousu"]); ?></p>
            </div>
        </li>
    </center>
    <div class="container-fluid p-2">
        <table class="table">
            <thead>
                <tr>
                    <!--<th scope="col">#</th>-->
                    <th scope="col">Imagen</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Empresa</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                <div class="container_card">
                    <tr>
                        <!--<th scope="row" style="vertical-align: middle;"><?php //echo $rows['id_carrito']; 
                                                                            ?></th>-->
                        <td>
                            <img src="data:image/jpg;base64,<?php echo $image; ?>" style="width: 90px; height: 100px;">
                        </td>
                        <!--<td style="vertical-align: middle;">
                                            <form id="form2" name="form1" method="post" action="cart.php">
                                                <input name="id" type="hidden" id="id" value="<?php //print $i;   
                                                                                                ?>" class="align-middle" />
                                                <input name="cantidad" type="text" id="cantidad" style="width:50px;" class="align-middle text-center" value="<?php print $carrito_mio[$i]['cantidad'];   ?>" size="1" maxlength="4" />
                                                <input type="image" name="imageField3" src="../Carrito de compra paso 1/img/actualiza.png" value="" class="btn btn-sm btn-primary btn-rounded" />
                                            </form>
                                        </td>-->
                        <td style="vertical-align: middle;"><?php echo $cantidadpedir; ?></td>
                        <td style="vertical-align: middle;"><?php echo $nombrepro; ?></td>
                        <td style="vertical-align: middle;">
                            <?php if (!empty($nombre_categ)) {
                                echo $nombre_categ;
                            } else {
                                echo "Se eliminó la categoria del producto";
                            } ?>
                        </td>
                        <td style="vertical-align: middle;"><?php echo  $nombreempresa; ?></td>
                        <td style="vertical-align: middle;">S/.<?php echo $costopro; ?></td>
                        <td style="vertical-align: middle;">S/.<?php echo $costopro * $cantidadpedir; ?></td>
                    </tr>
                </div>
            </tbody>
        </table>
        <li class="list-group-item d-flex justify-content-between" style="margin-top:-25px;">
            <span style="text-align: left; color: #000000;"><strong>Total (SOLES).</strong></span>
            <strong style="text-align: left; color: #000000;">S/.
                <?php
                echo $costopro * $cantidadpedir;
                ?>
            </strong>
        </li>
        <li class="list-group-item d-flex justify-content-between" style="margin-top:-15px;">
            <span style="text-align: left; color: #000000;"><strong>IGV (SOLES).</strong></span>
            <strong style="text-align: left; color: #000000;"> 0.18
            </strong>
        </li>
        <li class="list-group-item d-flex justify-content-between" style="margin-top:-15px;">
            <span style="text-align: left; color: #000000;"><strong>TOTAL + IGV (SOLES).</strong></span>
            <strong style="text-align: left; color: #000000;"> S/.
                <?php
                // Obtener el monto total según cantidad de productos.
                $preciototal = ($costopro * $cantidadpedir);
                // Obtener IGV.
                $igv = $preciototal * 0.18;
                // Monto total a pagar incluido IGV.
                $monto_total = $preciototal + $igv;
                echo $monto_total;
                ?>
            </strong>
        </li>
    </div>
    <center>
        <h2 style="color:blue;"><strong>Complete los datos para hagas el pedido</strong></h2>
    </center>
    <div class="container container--flex" style="width: 95%; border: 2px green solid; border-radius: 8px; margin-top:4px;">
        <form action="" method="post" class="formulario column column--50 bg-orange">
            <div class="row g-3">
                <div class="col">
                    <input type="hidden" id="idpro" name="idpro" value="<?php echo $idprod; ?>" class="form-control" autocomplete="off" require="required">
                </div>
                <div class="col">
                    <input type="hidden" id="canpedir" name="canpedir" value="<?php echo $cantidadpedir; ?>" class="form-control" autocomplete="off" require="required">
                </div>
                <div class="col">
                    <input type="hidden" id="pretotal" name="pretotal" value="<?php echo $monto_total; ?>" class="form-control" autocomplete="off" require="required">
                </div>
            </div>
            <div class="row g-3">
                <div class="col">
                    <label for="" style="color:blue; font-size: 16px;" class="formulario__label"><strong>HORA DE ENTREGA: </strong></label>
                    <input type="time" style="border: 2px blue solid;" class="form-control" id="horaentrega" name="horaentrega" autocomplete="off" required="required">
                </div>
                <div class="col">
                    <label for="" style="color:blue;font-size: 14px;" class="formulario__label"><strong>CELULAR: </strong></label>
                    <input type="number" style="border: 2px blue solid;" class="form-control" name="celular" required="required" placeholder="Ejemplo: 912345678">
                </div>
            </div>
            <div class="row g-3">
                <div class="col">
                    <label for="" style="color:blue;" class="formulario__label" style="width:100%"><strong>LUGAR ENTREGA:</strong> </label>
                    <input class="form-control" style="border: 2px blue solid;" type="text" id="direccionEnvio" name="direccion" placeholder="Ej. Urb. Iquitos calle 430" autocomplete="off" require="required">
                </div>
            </div>
            <div class="row g-3">
                <div class="col">
                    <label for="" style="color:blue; font-size: 14px;" class="formulario__label"><strong>Especifique la referencia de la dirección: </strong></label>
                    <textarea name="referenciadire" style="border: 2px blue solid;" id="" cols="30" rows="3" class="form-control formulario__textarea" placeholder="Especifique la referencia donde usted vive..."></textarea>
                </div>
            </div>
            <center>
                <input type="submit" style="width:64%; margin-top: 4px;" id="entrar" class="btn btn-primary" name="enviarpedido" value="ENVIAR PEDIDO ">
            </center>
        </form>
        <?php
        if (isset($_POST['enviarpedido'])) {
            $id_use = $_SESSION['idusu'];
            $id_produ = $_POST['idpro'];
            $canpedir = $_POST['canpedir'];
            $pretotal = $_POST['pretotal'];
            //$distrito = $_POST['distrito'];
            $celular = $_POST['celular'];
            $horaentrega = $_POST['horaentrega'];
            $direccion = $_POST['direccion'];
            $referenciadire = $_POST['referenciadire'];
            //$distritoe = sed::encryption($distrito);
            $direccione = sed::encryption($direccion);
            $refedireccione = sed::encryption($referenciadire);
            $celul = "51" . $celular;
            if (!empty($direccion) && !empty($referenciadire)) { //
                if ($celul <= 51999999999 && $celul >= 51900000000) {
                    $pedidopago = mysqli_query($conexion, "INSERT INTO pedidopago (idusu, estadopago, medio, montototal, fecha) 
VALUES ('$id_use', 'falta de pago', 'Efectivo', '$pretotal', now())");
                    $pedidopagosql = mysqli_query($conexion, "SELECT * FROM pedidopago where idusu=$id_use");
                    $cant_pedido = mysqli_num_rows($pedidopagosql);
                    $pedidopagos = mysqli_fetch_all($pedidopagosql, MYSQLI_ASSOC);
                    foreach ($pedidopagos as $rowp) {
                        $idpago = $rowp['idpago'];
                    }
                    $queryo = mysqli_query($conexion, "SELECT*FROM ordenes WHERE idpago=$idpago and idusu=$id_use"); // Comprobando si existe el mismo idpago del usuario
                    $cant_ordenes = mysqli_num_rows($queryo);
                    if ($cant_ordenes > 0) {
                        $pedidopagosql3 = mysqli_query($conexion, "SELECT * FROM pedidopago where idusu=$id_use and idpago!=$idpago");
                        $pedidopagos3 = mysqli_fetch_all($pedidopagosql3, MYSQLI_ASSOC);
                        foreach ($pedidopagos3 as $rowp3) {
                            $idpago3 = $rowp3['idpago'];
                            $idusu3 = $rowp3['idusu'];
                        }
                        //echo $idpago3 . " " .    $id_use;
                        $sqlordenes = mysqli_query($conexion, "INSERT INTO ordenes 
                        (hora_entrega, fecha_orden, celularu, direccion_orden, referenciadireccion, idusu, estado_orden, idpago, hora_orden) 
                        VALUES ('$horaentrega', now(), '$celular', '$direccione', '$refedireccione', '$id_use', '0', '$idpago3', now())");
                    } else {
                        //echo "Idpago está vacio";
                        $sqlordenes = mysqli_query($conexion, "INSERT INTO ordenes 
                        (hora_entrega, fecha_orden, celularu, direccion_orden, referenciadireccion, idusu, estado_orden, idpago, hora_orden) 
                        VALUES ('$horaentrega', now(), '$celular', '$direccione', '$refedireccione', '$id_use', '0', '$idpago', now())");
                    }
                    $querypro = "SELECT*FROM productos WHERE productos.idproducto=$id_produ";
                    $result_pro = mysqli_query($conexion, $querypro);
                    $cantidadprod = mysqli_num_rows($result_pro);
                    $productos = mysqli_fetch_all($result_pro, MYSQLI_ASSOC);
                    foreach ($productos as $ro) {
                        $idusu_empresa = $ro['id_empresa'];
                        $imagepro = base64_encode($ro['imagproducto']);
                        $nombrepro = sed::decryption($ro['nombreproducto']);
                        $costoprod = sed::decryption($ro['costoproducto']);
                        $codigopro = sed::decryption($ro['codigoproducto']);
                        $idcategprod = $ro['codigocate'];
                    }
                    $querycat = "SELECT*FROM categoria where codigocate='$idcategprod'";
                    $resultcat = mysqli_query($conexion, $querycat);
                    $catego = mysqli_fetch_all($resultcat, MYSQLI_ASSOC);
                    foreach ($catego as $row2) {
                        $nombre_categ = sed::decryption($row2['nombrecateg']);
                    }
                    $consul_em = ("SELECT * FROM logueo_empresa  WHERE logueo_empresa.id_empresa='$idusu_empresa'");
                    $query2em = mysqli_query($mysqli, $consul_em);
                    $empresas = mysqli_fetch_all($query2em, MYSQLI_ASSOC);
                    foreach ($empresas as $arrayem) {
                        $idempre = $arrayem['id_empresa'];
                        $nombre_empresa = sed::decryption($arrayem['nombreempresa']);
                    }
                    //Para aumentar la cantidad de los productos mas pedidos 
                    $querymo = "SELECT*FROM productos_masordenados WHERE idproducto='$id_produ' ORDER BY cantidadordenados DESC LIMIT 4";
                    $resul_cantmo = mysqli_query($conexion, $querymo);
                    $cantidadmo = mysqli_num_rows($resul_cantmo);
                    $masordenados = mysqli_fetch_all($resul_cantmo, MYSQLI_ASSOC);
                    foreach ($masordenados as $row) {
                        $id_masordenados = $row['id_masordenados'];
                        $canti_masordenados = $row['cantidadordenados'];
                    }
                    $incrementarordenados = $canti_masordenados + 1;
                    $costo_producto =  $costoprod * $canpedir;
                    $queryo = mysqli_query($conexion, "SELECT*FROM pedidoproductos WHERE idpago=$idpago and idusu=$id_use"); // Comprobando si existe el mismo idpago del usuario
                    $cant_ordenes = mysqli_num_rows($queryo);
                    if ($cant_ordenes > 0) {
                        $pedidopagosql3 = mysqli_query($conexion, "SELECT * FROM pedidopago where idusu=$id_use and idpago!=$idpago");
                        $pedidopagos3 = mysqli_fetch_all($pedidopagosql3, MYSQLI_ASSOC);
                        foreach ($pedidopagos3 as $rowp3) {
                            $idpago3 = $rowp3['idpago'];
                            $idusu3 = $rowp3['idusu'];
                        }
                        //echo $idpago3 . " " .    $id_use;
                        $pedido_produc = mysqli_query($conexion, "INSERT INTO pedidoproductos
                 (idusu, imag, nomproducto, categ_producto, cantipedir, precio, total, fecha_pedido, codigoproducto, id_empresa, idpago, hora_pedido) 
                 VALUES('$id_use', '$imagepro', '$nombrepro', '$nombre_categ', '$canpedir', '$costoprod', '$costo_producto', now(), '$codigopro', '$idusu_empresa', '$idpago3', now())");
                    } else {
                        $pedido_produc = mysqli_query($conexion, "INSERT INTO pedidoproductos
                        (idusu, imag, nomproducto, categ_producto, cantipedir, precio, total, fecha_pedido, codigoproducto, id_empresa, idpago, hora_pedido) 
                        VALUES('$id_use', '$imagepro', '$nombrepro', '$nombre_categ', '$canpedir', '$costoprod', '$costo_producto', now(), '$codigopro', '$idusu_empresa', '$idpago', now())");
                    }

                    if ($pedido_produc) {
                        if ($cantidadmo < 0) {
                            $qmasordenado = "INSERT INTO productos_masordenados(idproducto) VALUES('$id_produ')";
                            $resultadocanti = mysqli_query($conexion, $qmasordenado);
                        } else {
                            $cantiordenados = "UPDATE productos_masordenados SET cantidadordenados= '$incrementarordenados' 
            WHERE idproducto='$id_produ'";
                            $resultadocanti = mysqli_query($conexion, $cantiordenados);
                        }
                        echo "<script>location.href='reservaenviada.php?orden=1'</script>";
                    } else {
                        echo "Error: " . $pedido_produc . ' ' . $sqlordenes . ' ' . $resborrar . "<br>" . mysqli_error($conexion);
                    }
                } else {
                    echo '<div class="alert alert-danger" role="alert">"El numero de celular tiene que ser de 9 números. </div>';
                    //echo "<script>location.href='registro.php'</script>";
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Completa todos los datos. </div>';
            }
        }
        ?>
    </div>
</body>

</html>