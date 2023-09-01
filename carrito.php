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
            <?php
            if (@$ft == 1) {
                ?>
                <a class="" href="favoritos.php">
                    <img src="img/atras.png" style="width: 30px; height: 40px;">
                </a>
            <?php
            } else {
                ?>
                <a class="" href="index.php?index=1">
                    <img src="img/atras.png" style="width: 30px; height: 40px;">
                </a>
            <?php
            }
            ?>
            <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 16px;" href="#">
                <img src="img/ilogo.png" style="width: 30px; height: 30px;" alt="logo restaurantapp">
                <strong>Tienda Only</strong>
            </a>

        </div>
    </nav>

    <br><br><br><br>
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
                        <strong>CARRITO DE COMPRAS</strong></h3>

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
                                <th scope="col"></th>
                                <!--<th scope="col">Cod. producto</th>-->
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
                                        $codipro = sed::decryption($ro['codigoproducto']);
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
                                    $consul_em = ("SELECT * FROM logueo_empresa  WHERE id_empresa='$idusu_empresa'");
                                    $query2em = mysqli_query($mysqli, $consul_em);
                                    $empresas = mysqli_fetch_all($query2em, MYSQLI_ASSOC);
                                    foreach ($empresas as $arrayem) {
                                        $nombreempresa = sed::decryption($arrayem['nombreempresa']);
                                    }
                                    ?>

                            <tbody>
                                <div class="container_card">
                                    <tr>
                                        <td style="vertical-align: middle;">
                                            <form action="carrito.php" method="post" style="width:110px; display: inline-block;">
                                                <input type="hidden" name="idcarrito" value="<?php echo $rows['id_carrito']; ?>">
                                                <input type="image" name="eliminarcarrito" src="img/eliminar.png" style="width: 50px; height: 60px;" value="Quitar" class="btn btn-sm btn-primary btn-rounded" />
                                            </form>
                                            <?php
                                                        if (isset($_POST['idcarrito'])) {
                                                            $idcarro = $_POST['idcarrito'];
                                                            $sqlborrar = "DELETE FROM carrito WHERE id_carrito=$idcarro";
                                                            $resborrar = mysqli_query($mysqli, $sqlborrar);
                                                            if ($resborrar) {
                                                                //echo '<div class="alert alert-primary" role="alert">Eliminado exitosamente. </div>';
                                                                echo "<script>location.href='carrito.php'</script>";
                                                            } else {
                                                                echo "Error: " . $sqlborrar . "<br>" . mysqli_error($mysqli);
                                                                //echo "<script>location.href='registro.php'</script>";
                                                            }
                                                        }
                                                        ?>
                                        </td>
                                        <!--<th scope="row" style="vertical-align: middle;"><?php //echo $codipro; 
                                                                                                        ?></th>-->
                                        <td>
                                            <img src="data:image/jpg;base64,<?php echo $image; ?>" style="width: 95px; height: 130px;">
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <form id="form2" name="form1" method="post" action="carrito.php">
                                                <div style="display:inline-block;">
                                                    <input name="id" type="hidden" id="id" value="<?php echo $idcarrito;
                                                                                                                ?>" class="align-middle" />
                                                    <input name="cantidad" type="number" id="cantidad" style="width:40px; height: 40px;" class="formulario__label text-center" value="<?php echo $cantipedir; ?>" size="1" maxlength="4" />
                                                </div>
                                                <div style="display:inline-block;">
                                                    <input type="image" name="imageField3" src="img/actualizar.gif" style="width: 40px; height: 40px; display:inline-block;" value="" class="btn btn-sm btn-primary btn-rounded" />
                                                </div>
                                            </form>
                                            <?php
                                                        if (isset($_POST['cantidad'])) {
                                                            $id_carrito = $_POST['id'];
                                                            $cuantos = $_POST['cantidad'];
                                                            if ($cuantos > 0) {
                                                                $sqlcar = "SELECT*FROM carrito where id_carrito='$id_carrito'";
                                                                $carritosql = mysqli_query($conexion, $sqlcar);
                                                                $precio_carri = mysqli_fetch_all($carritosql, MYSQLI_ASSOC);
                                                                $cantprecio = mysqli_num_rows($carritosql);
                                                                foreach ($precio_carri as $rowcp) { }
                                                                $precitotal = $rowcp['precio'] * $cuantos;
                                                                $actualizarcarro = mysqli_query($mysqli, "UPDATE carrito 
                                                                SET cantidadpedir = '$cuantos', Total= '$precitotal' 
                                                                WHERE id_carrito='$id_carrito'");
                                                                if ($actualizarcarro) {
                                                                    echo "<script>location.href='carrito.php'</script>";
                                                                }
                                                            }
                                                        }
                                                        ?>
                                        </td>
                                        <!--<td style="vertical-align: middle;"><?php //echo $cantipedir; 
                                                                                            ?></td>-->
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
                    <li class="list-group-item d-flex justify-content-between" style="margin-top:-25px;" >
                        <span style="text-align: left; color: #000000;"><strong>Total (SOLES).</strong></span>
                        <strong style="text-align: left; color: #000000;">S/.
                            <?php
                                    $qcanti = "SELECT SUM(Total) preciototal FROM carrito where idusu='$idlog'";
                                    $rcanti = mysqli_query($conexion, $qcanti);
                                    $preciocarrito = mysqli_fetch_all($rcanti, MYSQLI_ASSOC);
                                    $cantprecio = mysqli_num_rows($rcanti);
                                    foreach ($preciocarrito as $rowpreci) {
                                        echo $rowpreci['preciototal'];
                                    }
                                    ?>
                        </strong>
                    </li>
                </div>
                <a href="carritopedido.php" class="btn btn-primary" style="width: 40%;">Continuar pedido</a>
            <?php
                } else {
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
                                <strong>CARRIO DE COMPRAS</strong></h3>

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