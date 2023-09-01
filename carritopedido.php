<?php
session_start();
require("connectdb.php");
include("conexion.php");
include 'sed.php';
@$idlog = @$_SESSION['idusu'];
extract($_GET);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Carrito de compras| Tienda Only</title>
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
            <a class="" href="carrito.php">
                <img src="img/atras.png" style="width: 30px; height: 40px;">
            </a>
            <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 16px;" href="#">
                <img src="img/ilogo.png" style="width: 30px; height: 30px;" alt="logo restaurantapp">
                <strong>Tienda Only</strong>
            </a>

        </div>
    </nav>

    <br><br><br>
    <?php
    if (@!$_SESSION['idusu']) { //si la session del usuario esta vacia
        ?>
        <div class="container container-web-page ">
            <div class="row justify-content-md-center border-primary" style="background-color: orange;border-radius: 35px; width: 100%; margin-left: 0;">
                <div class="col-12 col-md-6">
                    <figure class="full-box">
                        <center>
                            <img src="img/carrito.png" alt="registration_killaripostres" class="img-fluid">
                        </center>
                    </figure>
                </div>
                <div class="w-100"></div>
                <div class="col-12 col-md-6">
                    <h3 style="color:white;" class="text-center text-uppercase poppins-regular font-weight-bold">
                        <strong>Carrito</strong></h3>

                    <p class="text-justify">
                        <center>
                            <strong style="color:white;">
                                Aquí se mostrarán los productos que añadiste al carrito de compras.</strong>
                            <br>
                            <strong style="color:white;">
                                Inicia sesión o crea una cuenta.</strong>
                        </center>
                    </p>
                    </p>
                </div>
            </div>
        </div>
        <?php
            //El @ oculta los mensajes de error que pueda salir
        } else if ($_SESSION['rolusu'] == "user") { //sino si la session rol no esta vacia
            $querycar = "SELECT id_carrito, idproducto, cantidadpedir, precio, fechacarrito, horacarrito
            , Total FROM carrito where idusu='$idlog'  and estadocarrito ='1'";
            $resultcar = mysqli_query($conexion, $querycar);
            $carrito = mysqli_fetch_all($resultcar, MYSQLI_ASSOC);
            $cantcarrito = mysqli_num_rows($resultcar);
            if ($cantcarrito > 0) {
                ?>
            <div style="width: 96%; margin-left: 12px; border:2px solid blue;">
                <div style="width: 100%; border:2px solid blue;">
                    <img src="img/carrito.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">
                    <h1 style="display: inline-block; font-size: 18px;">Añadido al carrito: <?php echo $cantcarrito; ?></h1>
                </div>
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
                        <?php
                                foreach ($carrito as $rows) {
                                    $idcarrito = $rows['id_carrito'];
                                    $idproducto = $rows['idproducto'];
                                    $cantipedir = $rows['cantidadpedir'];
                                    $precio = $rows['precio'];
                                    $fech_carrito = $rows['fechacarrito'];
                                    $hor_carrito = $rows['horacarrito'];

                                    $query = "SELECT*FROM productos WHERE productos.idproducto=$idproducto";
                                    $resul_cant = mysqli_query($conexion, $query);
                                    $cantidad = mysqli_num_rows($resul_cant);
                                    $pro = mysqli_fetch_all($resul_cant, MYSQLI_ASSOC);
                                    foreach ($pro as $ro) {
                                        $id = $ro['idproducto'];
                                        $idusu_empresa = $ro['id_empresa'];
                                        $image = base64_encode($ro['imagproducto']);
                                        $nombrepro = sed::decryption($ro['nombreproducto']);
                                        $costopro = sed::decryption($ro['costoproducto']);
                                        $detallepro = sed::decryption($ro['detalleproducto']);
                                        $idcategprod = $ro['codigocate'];
                                    }
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
                                    ?>

                            <tbody>
                                <div class="container_card">
                                    <tr>
                                        <!--<th scope="row" style="vertical-align: middle;"><?php //echo $rows['id_carrito']; 
                                                                                                        ?></th>-->
                                        <td>
                                            <img src="data:image/jpg;base64,<?php echo $image; ?>" style="width: 90px; height: 100px;">
                                        </td>
                                        <td style="vertical-align: middle;"><?php echo $cantipedir; ?></td>
                                        <td style="vertical-align: middle;"><?php echo sed::decryption($ro['nombreproducto']); ?></td>
                                        <td style="vertical-align: middle;"><?php echo sed::decryption($row2['nombrecateg']); ?></td>
                                        <td style="vertical-align: middle;"><?php echo  $nombreempresa; ?></td>
                                        <td style="vertical-align: middle;">S/.<?php echo $rows['precio']; ?></td>
                                        <td style="vertical-align: middle;">S/.<?php echo $rows['precio'] * $cantipedir; ?></td>

                                    </tr>
                                </div>
                            </tbody>
                        <?php  } ?>
                    </table>
                    <li class="list-group-item d-flex justify-content-between" style="margin-top:-25px;">
                        <span style="text-align: left; color: #000000;"><strong>Total (SOLES).</strong></span>
                        <strong style="text-align: left; color: #000000;">S/.
                            <?php
                                    $qcanti = "SELECT SUM(Total) preciototal FROM carrito where idusu='$idlog'  and estadocarrito ='1'";
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
                                    $preciototal = ($costopro * $cantipedir);
                                    // Obtener IGV.
                                    $igv = $preci_total * 0.18;
                                    // Monto total a pagar incluido IGV.
                                    $monto_total = $preci_total + $igv;
                                    echo $monto_total;
                                    ?>
                        </strong>
                    </li>
                </div><br>
                <center>
                    <h2 style="color:blue;"><strong>Complete los datos para hagas el pedido</strong></h2>
                </center>
                <div class="container container--flex" style="width: 95%; border: 2px green solid; border-radius: 8px; margin-top:4px;">
                    <form action="" method="post" class="formulario column column--50 bg-orange">
                        <div class="row g-3">
                            <div class="col">
                                <input type="hidden" id="pretotal" name="idu" value="<?php //echo $monto_total; 
                                                                                                ?>" class="form-control" autocomplete="off" require="required">
                                <input type="hidden" id="montototal" name="montototal" value="<?php echo $monto_total;
                                                                                                        ?>" class="form-control" autocomplete="off" require="required">
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
                                <textarea name="referenciadire" style="border: 2px blue solid;" id="" cols="30" rows="2" class="form-control formulario__textarea" placeholder="Especifique la referencia donde usted vive..."></textarea>
                            </div>
                        </div>
                        <center>
                            <input type="submit" style="width:64%; margin-top: 6px;" id="entrar" class="btn btn-primary" name="enviarpedido" value="ENVIAR PEDIDO ">
                        </center>
                    </form>
                    <?php
                            if (isset($_POST['enviarpedido'])) {
                                extract($_GET);
                                $iduscliente = $_SESSION['idusu'];
                                $hora_entrega = $_POST['horaentrega'];
                                $celula = $_POST['celular'];
                                $direccion_entrega = $_POST['direccion'];
                                $montototal = $_POST['montototal'];
                                $refedireccion = $_POST['referenciadire'];
                                $celule = sed::encryption($celula);
                                $direccione = sed::encryption($direccion_entrega);
                                $refedireccione = sed::encryption($refedireccion);
                                $celul = "51" . $celula;
                                if (!empty($direccion_entrega) && !empty($refedireccion)) {
                                    if ($celul <= 51999999999 && $celul >= 51900000000) {
                                        $pedidopago = mysqli_query($conexion, "INSERT INTO pedidopago (idusu, estadopago, medio, montototal, fecha) 
                                                    VALUES ('$iduscliente', 'falta de pago', 'Efectivo', '$montototal', now())");
                                        $pedidopagosql = mysqli_query($conexion, "SELECT * FROM pedidopago where idusu=$iduscliente");
                                        $cant_pedido = mysqli_num_rows($pedidopagosql);
                                        $pedidopagos = mysqli_fetch_all($pedidopagosql, MYSQLI_ASSOC);
                                        foreach ($pedidopagos as $rowp) {
                                            $idpago = $rowp['idpago'];
                                        }
                                        $queryo = mysqli_query($conexion, "SELECT*FROM ordenes WHERE idpago=$idpago and idusu=$iduscliente"); // Comprobando si existe el mismo idpago del usuario
                                        $cant_ordenes = mysqli_num_rows($queryo);
                                        if ($cant_ordenes > 0) {
                                            $pedidopagosql3 = mysqli_query($conexion, "SELECT * FROM pedidopago where idusu=$iduscliente and idpago!=$idpago");
                                            $pedidopagos3 = mysqli_fetch_all($pedidopagosql3, MYSQLI_ASSOC);
                                            foreach ($pedidopagos3 as $rowp3) {
                                                $idpago3 = $rowp3['idpago'];
                                                $idusu3 = $rowp3['idusu'];
                                            }
                                            //echo $idpago3 . " " .    $id_use;
                                            $sqlordenes = mysqli_query($conexion, "INSERT INTO ordenes 
                                                        (hora_entrega, fecha_orden, celularu, direccion_orden, referenciadireccion, idusu, estado_orden, idpago, hora_orden) 
                                                        VALUES ('$hora_entrega', now(), '$celula', '$direccione', '$refedireccione', '$iduscliente', '0', '$idpago3', now())");
                                        } else {
                                            //echo "Idpago está vacio";
                                            $sqlordenes = mysqli_query($conexion, "INSERT INTO ordenes 
                                                        (hora_entrega, fecha_orden, celularu, direccion_orden, referenciadireccion, idusu, estado_orden, idpago, hora_orden) 
                                                        VALUES ('$horaentrega', now(), '$celular', '$direccione', '$refedireccione', '$iduscliente', '0', '$idpago', now())");
                                        }
                                        $queryo = mysqli_query($conexion, "SELECT*FROM pedidoproductos WHERE idpago=$idpago and idusu=$iduscliente"); // Comprobando si existe el mismo idpago del usuario
                                        $cant_ordenes = mysqli_num_rows($queryo);
                                        if ($cant_ordenes > 0) {
                                            $pedidopagosql3 = mysqli_query($conexion, "SELECT * FROM pedidopago where idusu=$iduscliente and idpago!=$idpago");
                                            $pedidopagos3 = mysqli_fetch_all($pedidopagosql3, MYSQLI_ASSOC);
                                            foreach ($pedidopagos3 as $rowp3) {
                                                $idpago3 = $rowp3['idpago'];
                                                $idusu3 = $rowp3['idusu'];
                                            }
                                            $sqlcarrito = "SELECT * FROM carrito WHERE idusu=$iduscliente";
                                        //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
                                        $carritosql = mysqli_query($mysqli, $sqlcarrito);
                                        $carrito = mysqli_fetch_all($carritosql, MYSQLI_ASSOC);
                                        foreach ($carrito as $rowc) {
                                            $id_producto = $rowc['idproducto'];
                                            $cantidadpedir = $rowc['cantidadpedir'];
                                            $precio_produc = $rowc['precio'];
                                            $total_produc = $rowc['Total'];
                                            $querypro = "SELECT*FROM productos WHERE productos.idproducto=$id_producto";
                                            $result_pro = mysqli_query($conexion, $querypro);
                                            $cantidadprod = mysqli_num_rows($result_pro);
                                            $productos = mysqli_fetch_all($result_pro, MYSQLI_ASSOC);
                                            foreach ($productos as $ro) {
                                                $idusu_empresa = $ro['id_empresa'];
                                                $imagepro = base64_encode($ro['imagproducto']);
                                                $nombrepro = sed::decryption($ro['nombreproducto']);
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
                                            $querymo = "SELECT*FROM productos_masordenados WHERE idproducto='$id_producto' ORDER BY cantidadordenados DESC LIMIT 4";
                                            $resul_cantmo = mysqli_query($conexion, $querymo);
                                            $cantidadmo = mysqli_num_rows($resul_cantmo);
                                            $masordenados = mysqli_fetch_all($resul_cantmo, MYSQLI_ASSOC);
                                            foreach ($masordenados as $row) {
                                                $id_masordenados = $row['id_masordenados'];
                                                $canti_masordenados = $row['cantidadordenados'];
                                            }
                                            $incrementarordenados = $canti_masordenados + 1;
                                            $pedido_produc = mysqli_query($conexion, "INSERT INTO pedidoproductos
                                            (idusu, imag, nomproducto, categ_producto, cantipedir, precio, total, fecha_pedido, codigoproducto, id_empresa, idpago, hora_pedido) 
                                            VALUES('$iduscliente', '$imagepro', '$nombrepro', '$nombre_categ', '$cantidadpedir', '$precio_produc', '$total_produc', now(), '$codigopro', '$idempre', '$idpago3', now())");
                                            if ($pedido_produc && $sqlordenes) {
                                                $sqlborrar = mysqli_query($mysqli, "DELETE FROM carrito WHERE idusu=$iduscliente");
                                                if ($cantidadmo < 0) {
                                                    $qmasordenado = mysqli_query($conexion,"INSERT INTO productos_masordenados(idproducto) VALUES('$id_producto')");
                                                } else {
                                                    $cantiordenados = mysqli_query($conexion,"UPDATE productos_masordenados SET cantidadordenados= '$incrementarordenados' 
                                                        WHERE idproducto='$id_producto'");
                                                }
                                                echo "<script>location.href='reservaenviada.php?orden=1'</script>";
                                            } else {
                                                echo "Error: " . $pedido_produc . ' ' . $sqlordenes . ' ' . $resborrar . "<br>" . mysqli_error($conexion);
                                            }
                                        }
                                        } else {
                                            $sqlcarrito = "SELECT * FROM carrito WHERE idusu=$iduscliente";
                                            //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
                                            $carritosql = mysqli_query($mysqli, $sqlcarrito);
                                            $carrito = mysqli_fetch_all($carritosql, MYSQLI_ASSOC);
                                            foreach ($carrito as $rowc) {
                                                $id_producto = $rowc['idproducto'];
                                                $cantidadpedir = $rowc['cantidadpedir'];
                                                $precio_produc = $rowc['precio'];
                                                $total_produc = $rowc['Total'];
                                                $querypro = "SELECT*FROM productos WHERE productos.idproducto=$id_producto";
                                                $result_pro = mysqli_query($conexion, $querypro);
                                                $cantidadprod = mysqli_num_rows($result_pro);
                                                $productos = mysqli_fetch_all($result_pro, MYSQLI_ASSOC);
                                                foreach ($productos as $ro) {
                                                    $idusu_empresa = $ro['id_empresa'];
                                                    $imagepro = base64_encode($ro['imagproducto']);
                                                    $nombrepro = sed::decryption($ro['nombreproducto']);
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
                                                $querymo = "SELECT*FROM productos_masordenados WHERE idproducto='$id_producto' ORDER BY cantidadordenados DESC LIMIT 4";
                                                $resul_cantmo = mysqli_query($conexion, $querymo);
                                                $cantidadmo = mysqli_num_rows($resul_cantmo);
                                                $masordenados = mysqli_fetch_all($resul_cantmo, MYSQLI_ASSOC);
                                                foreach ($masordenados as $row) {
                                                    $id_masordenados = $row['id_masordenados'];
                                                    $canti_masordenados = $row['cantidadordenados'];
                                                }
                                                $incrementarordenados = $canti_masordenados + 1;
                                                $pedido_produc = mysqli_query($conexion, "INSERT INTO pedidoproductos
                                            (idusu, imag, nomproducto, categ_producto, cantipedir, precio, total, fecha_pedido, codigoproducto, id_empresa, idpago, hora_pedido) 
                                            VALUES('$iduscliente', '$imagepro', '$nombrepro', '$nombre_categ', '$cantidadpedir', '$precio_produc', '$total_produc', now(), '$codigopro', '$idempre', '$idpago', now())");
                                                if ($pedido_produc && $sqlordenes) {
                                                    $sqlborrar = mysqli_query($mysqli, "DELETE FROM carrito WHERE idusu=$iduscliente");
                                                    if ($cantidadmo < 0) {
                                                        $qmasordenado = mysqli_query($conexion, "INSERT INTO productos_masordenados(idproducto) VALUES('$id_producto')");
                                                    } else {
                                                        $cantiordenados = mysqli_query($conexion,"UPDATE productos_masordenados SET cantidadordenados= '$incrementarordenados' 
                                                        WHERE idproducto='$id_producto'");
                                                    }
                                                    echo "<script>location.href='reservaenviada.php?orden=1'</script>";
                                                } else {
                                                    echo "Error: " . $pedido_produc . ' ' . $sqlordenes . ' ' . $resborrar . "<br>" . mysqli_error($conexion);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            ?>
                </div>
            <?php
                } else {
                    ?>
                <div class="container container-web-page ">
                    <div class="row justify-content-md-center border-primary" style="background-color: orange;border-radius: 35px; width: 100%; margin-left: 0;">
                        <div class="col-12 col-md-6">
                            <figure class="full-box">
                                <center>
                                    <img src="img/favorito.png" alt="registration_killaripostres" class="img-fluid">
                                </center>
                            </figure>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-12 col-md-6">
                            <h3 style="color:white;" class="text-center text-uppercase poppins-regular font-weight-bold">
                                <strong>Favoritos</strong></h3>

                            <p class="text-justify">
                                <center>
                                    <strong style="color:white;">
                                        Aquí se mostrarán los productos que añadiste al carrito de compras.</strong>

                                </center>
                            </p>
                        </div>
                    </div>
                </div>
            <?php
                } ?>

        <?php
        }

        ?>
</body>

</html>