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
            <a class="" href="carrito.php">
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
    $querycar = "SELECT*FROM carrito where id_carrito='$id'";
    $resultcar = mysqli_query($conexion, $querycar);
    $carrito = mysqli_fetch_all($resultcar, MYSQLI_ASSOC);
    $cantcarrito = mysqli_num_rows($resultcar);
    foreach ($carrito as $rows) {
        $idcarrito = $rows['id_carrito'];
        $idproducto = $rows['idproducto'];
        $idcate_producto = $rows['idcategoria'];
        $cantipedir = $rows['cantidadpedir'];
        $preciotota = $rows['preciototal'];
        $fech_carrito = $rows['fechacarrito'];
        $hor_carrito = $rows['horacarrito'];

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
            $idcategprod = $ro['idcategoria'];
        }
        $querycat = "SELECT*FROM categoria where idcategoria='$idcategprod' ORDER BY idcategoria DESC";
        $resultcat = mysqli_query($conexion, $querycat);
        $catego = mysqli_fetch_all($resultcat, MYSQLI_ASSOC);
        foreach ($catego as $row2) {
            $id_categ = $row2['idcategoria'];
            $imag_categ = base64_encode($row2['imagen']);
            $nombre_categ = sed::decryption($row2['nombrecateg']);
            $descripcion_categ = sed::decryption($row2['descripcioncateg']);
        }
        ?>
        <center>
            <li>
                <div class="invi border-primary " style=" border:2px solid blue; width: 50%;height: 180%;" category="iquitos">
                    <img src="data:image/jpg;base64,<?php echo $image; ?>" style="width: 100%" alt="imagen invitado">

                    <p class="p"><?php echo $nombrepro; ?></p>

                </div>
            </li>
        </center>
        <div style="margin-left: 16px; margin-top: 3px;">
            <h1 style="color:blue;"><strong>Información</strong></h1>
            <p><strong>Categoria: <?php
                                        if (!empty($nombre_categ)) {
                                            echo $nombre_categ;
                                        } else {
                                            echo "Se eliminó la categoria del producto";
                                        }
                                        ?> </strong></p>
            <p><strong>Cantidad a pedir: <?php echo $cantipedir; ?> unidades </strong></p>
            <p><strong>Precio del producto: S/. <?php echo $costopro; ?> </strong></p>
            <p><strong>IGV: 0.18</strong></p>
            <p><strong>Precio Total: S/.<?php echo $preciotota; ?> </strong></p>

        </div>
    <?php } ?>

    <center>
        <h2 style="color:blue;"><strong>Complete los datos para hagas el pedido</strong></h2>
    </center>
    <div class="container container--flex" style="width: 95%; border: 2px green solid; border-radius: 8px; margin-top:4px;">
        <form action="" method="post" class="formulario column column--50 bg-orange">
            <div class="row g-3">
                <div class="col">
                    <input class="form-control" type="hidden" id="idpro" name="idpro" value="<?php echo $idprod ?>" autocomplete="off" require="required">
                </div>
                <div class="col">
                    <input class="form-control" type="hidden" id="canpedir" name="canpedir" value="<?php echo $cantipedir; ?>" autocomplete="off" require="required">
                </div>
                <div class="col">
                    <input class="form-control" type="hidden" id="pretotal" name="pretotal" value="<?php echo $preciotota; ?>" autocomplete="off" require="required">
                </div>
                <div class="col">
                    <input class="form-control" type="hidden" id="id_carri" name="id_carri" value="<?php echo $idcarrito; ?>" autocomplete="off" require="required">
                </div>
            </div>
            <!--<div class="row g-3">
                <div class="col">
                    <label for="" style="color:blue; " class="formulario__label"><strong> DISTRITO : </strong></label>
                    <select id="soporte" style="border: 2px blue solid;" class="form-control" name="distrito" required="required">
                        <option value="-" selected="">Seleccione el distrito donde se encuentra</option>
                        <option value="Punchana">Punchana</option>
                        <option value="Maynas">Maynas</option>
                        <option value="Belén">Belén</option>
                        <option value="San Juan">San Juan</option>
                        <option value="OTROS">OTRO</option>
                    </select>
                </div>
            </div>-->
            <div class="row g-3">
                <div class="col">
                    <label for="" style="color:blue; font-size: 16px;" class="formulario__label"><strong>HORA DE ENTREGA: </strong></label>
                    <input type="time" style="border: 2px blue solid;" class="form-control" id="horaentrega" name="horaentrega" autocomplete="off" required="required">
                </div>
                <div class="col">
                    <label for="" style="color:blue; font-size: 16px;" class="formulario__label"><strong>FECHA DE ENTREGA: </strong></label>
                    <input type="date" style="border: 2px blue solid;" class="form-control" id="fechaentrega" name="fechaentrega" autocomplete="off" required="required">
                </div>
            </div>
            <div class="row g-3">
                <div class="col">
                    <label for="" style="color:blue;font-size: 14px;" class="formulario__label"><strong>CELULAR: </strong></label>
                    <input type="number" style="border: 2px blue solid;" class="form-control" name="celular" required="required" placeholder="Ejemplo: 51912345678">
                </div>
                <div class="col">
                    <label for="" style="color:blue;" class="formulario__label" style="width:100%"><strong>LUGAR ENTREGA:</strong> </label>
                    <input class="form-control" style="border: 2px blue solid;" type="text" id="direccionEnvio" name="direccion" placeholder="Ej. Urb. Iquitos calle 430" autocomplete="off" require="required">
                </div>
            </div>
            <div class="row g-3">
                <div class="col">
                    <label for="" style="color:blue; font-size: 14px;" class="formulario__label"><strong>Especifique la referencia de la dirección: </strong></label>
                    <textarea name="referenciadire" style="border: 2px blue solid;" id="" cols="30" rows="3" class="form-control formulario__textarea" placeholder="Especifique la referencia donde usted vive..." required="required"></textarea>
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
            $idcarro = $_POST['id_carri'];
            $canpedir = $_POST['canpedir'];
            $pretotal = $_POST['pretotal'];
            //$distrito = $_POST['distrito'];
            $celular = $_POST['celular'];
            $fechaentrega = $_POST['fechaentrega'];
            $horaentrega = $_POST['horaentrega'];
            $direccion = $_POST['direccion'];
            $referenciadire = $_POST['referenciadire'];
            $distritoe = sed::encryption($distrito);
            $fechaentregae = sed::encryption($fechaentrega);
            $direccione = sed::encryption($direccion);
            $refedireccione = sed::encryption($referenciadire);
            $celul = "51" . $celular;
            //echo $celu;
            if (!empty($fechaentrega) && !empty($direccion) && !empty($referenciadire)) {
                if ($celul <= 51999999999 && $celul >= 51900000000) {
                    $estadocarri = mysqli_query($mysqli, "UPDATE carrito SET carrito.estadocarrito = '0' WHERE carrito.id_carrito='$idcarro'");

                    $query = "SELECT*FROM productos WHERE productos.idproducto=$id_produ";
                    $resul_cant = mysqli_query($conexion, $query);
                    $cantidad = mysqli_num_rows($resul_cant);
                    $pro = mysqli_fetch_all($resul_cant, MYSQLI_ASSOC);
                    foreach ($pro as $ro) {
                        $idprod = $ro['idproducto'];
                        $image = base64_encode($ro['imagproducto']);
                        $nombrepro = $ro['nombreproducto'];
                        $idcategprod = $ro['idcategoria'];
                    }
                    $querycat = "SELECT*FROM categoria where idcategoria='$idcategprod' ORDER BY idcategoria DESC";
                    $resultcat = mysqli_query($conexion, $querycat);
                    $catego = mysqli_fetch_all($resultcat, MYSQLI_ASSOC);
                    foreach ($catego as $row2) {
                        $id_categ = $row2['idcategoria'];
                        $nombre_categ = $row2['nombrecateg'];
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
                    if ($cantidadmo < 0) {
                        $qmasordenado = "INSERT INTO productos_masordenados(idproducto) VALUES('$id_produ')";
                    } else {
                        $incrementarordenados = $canti_masordenados + 1;
                        $cantiordenados = "UPDATE productos_masordenados SET cantidadordenados= '$incrementarordenados' 
                        WHERE id_masordenados='$id_masordenados'";
                    }

                    /*$sql = "INSERT INTO ordenes (idproducto, imag, nomproducto, categ_producto, cantiproduct, preciototal, hora_entrega,fecha_entrega, fechayhora_orden, celularu, direccion_orden, referenciadireccion,idusu, estado_orden) 
            VALUES ('$id_produ', '$image', '$nombrepro', '$nombre_categ', '$canpedir', '$pretotal','$horaentrega','$fechaentregae', now(), '$celul' ,'$direccione', '$refedireccione', '$id_use', '0')";
                    $resultado = mysqli_query($conexion, $sql);
                    if ($resultado == 1 && $estadocarri == 1) {
                        //echo "Datos ingresados";
                        echo '<div class="alert alert-primary" role="alert">Orden exitoxamente. </div>';
                        echo "<script>location.href='reservaenviada.php'</script>";
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Hubo problemas al reservar. </div>';
                        //header('Location:registro.php');
                        echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
                    }*/
                } else {
                    echo '<div class="alert alert-danger" role="alert">"El numero de celular tiene que ser de 9 números. </div>';
                    //echo "<script>location.href='registro.php'</script>";
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Completa todos los datos. </div>';
            }
        }
        include('footer.php');
        ?>
    </div>
</body>

</html>