<?php
session_start();
require("connectdb.php");
include("conexion.php");
include 'sed.php';
extract($_GET);
$sql1 = "SELECT * FROM productos WHERE idproducto=$idproducto";
$resultado = mysqli_query($conexion, $sql1);
$persona = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
foreach ($persona as $rows) {
    $idproducto = $rows['idproducto'];
    $img_producto = base64_encode($rows['imagproducto']);
    $nombre_producto = sed::decryption($rows['nombreproducto']);
    $idcate_producto = $rows['codigocate'];
    $precio_producto = sed::decryption($rows['costoproducto']);
}
if (@$_SESSION['rolusu'] == "user") { //sino si la session rol no esta vacia
    /*if ((time() - @$_SESSION['last_login_timestamp']) > 1260) { // 900 = 15 * 60  
        setcookie("cerrarsesion", 1, time() + 960000); //6o segundos es 1 minuto, 86400 segundos es por 24 horas
        echo "<script>location.href='desconectar.php'</script>";
    } else {
        @$_SESSION['last_login_timestamp'] = time();
    }*/ }
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title><?php echo $nombre_producto; ?>| Tienda only</title>
    <link rel="icon" href='data:image/jpg;base64,<?php echo $img_producto; ?>' sizes="32x32" type="img/jpg">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css2/style.css" />

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css2/invitado.css">
    <link rel="stylesheet" href="css/estilosgaleria.css">
    <link rel="stylesheet" href="css/contact.css">
    <!--compartir-->
    <!--<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=61a8fa9ed0a9e10012e4df83&product=sticky-share-buttons' async='async'></script>-->
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
            } else if (@$idempresa) {
                ?>
                <a class="" href="verempresa.php?id=<?php echo $idempresa; ?>">
                    <img src="img/atras.png" style="width: 30px; height: 40px;">
                </a>
            <?php
            } else {
                ?>
                <a class="" href="index.php?productos=1">
                    <img src="img/atras.png" style="width: 30px; height: 40px;">
                </a>
            <?php
            }
            ?>
            <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 16px;" href="#">
                <img src="img/ilogo.png" style="width: 30px; height: 30px;" alt="logo restaurantapp">
                <strong>Tienda Only</strong>
            </a>
            <div style="margin-left: 1px;" class="navbar-brand order-1 order-justify-content-end dropdown show" id="yui_3_17_2_1_1636218170770_38">
                <a href="#" tabindex="0" class="" style="color: white;" id="action-menu-toggle-1" aria-label="Menú de usuario" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" aria-controls="action-menu-1-menu">

                    <img src="img/puntosblancos.png" style="width: 30px; height: 30px;">
                </a>
                <div class="dropdown-menu dropdown-menu-right menu align-tr-br" id="action-menu-1-menu" data-rel="menu-content" aria-labelledby="action-menu-toggle-1" role="menu" data-align="tr-br">
                    <a onclick="Copy();" class="dropdown-item menu-action select" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                        <img src="img/copylink.png" style="width: 26px; height: 22px;"><strong> Copiar link</strong>
                    </a>
                    <div class="dropdown-divider border-primary" style="background-color:blue;"></div>
                    <a href="
                    <?php
                    if (@!$_SESSION['idusu']) { //si la session del usuario esta vacia
                        ?>
                        logueo.php
                    <?php
                        //El @ oculta los mensajes de error que pueda salir
                    } else if ($_SESSION['rolusu'] == "user") { //sino si la session rol no esta 
                        ?>
                        verproducto.php?favorito=1&idproducto=<?php echo $idproducto; ?>
                    <?php
                    }
                    ?>
                    " class="dropdown-item menu-action select" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                        <img src="img/favorito.png" style="width: 26px; height: 22px;"><strong> Agregar favoritos</strong>
                    </a>
                    <div class="dropdown-divider border-primary" style="background-color:blue;"></div>
                    <a href="
                        <?php
                        if (@!$_SESSION['idusu']) { //si la session del usuario esta vacia
                            ?>
                        logueo.php
                        <?php
                            //El @ oculta los mensajes de error que pueda salir
                        } else if ($_SESSION['rolusu'] == "user") { //sino si la session rol no esta 
                            ?>
                            verproducto.php?report=1&idproducto=<?php echo $idproducto; ?>
                        <?php
                        }
                        ?>
                    " class="dropdown-item menu-action select" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                        <img src="img/reportar.png" style="width: 26px; height: 22px;"><strong> Reportar este producto</strong>
                    </a>
                </div>
                <script>
                    function Copy() {
                        let url = document.location.href

                        navigator.clipboard.writeText(url).then(function() {
                            console.log('Copied!');
                        }, function() {
                            console.log('Copied!');
                        });

                    }
                </script>
            </div>
        </div>
    </nav>
    <?php
    foreach ($persona as $ro) {
        $id = $ro['idproducto'];
        $ide_prod = $ro['id_empresa'];
        $image = base64_encode($ro['imagproducto']);
        $nombretort = sed::decryption($ro['nombreproducto']);
        $preciotorta = sed::decryption($ro['costoproducto']);
        $detalletorta = sed::decryption($ro['detalleproducto']);
        $idcategprod = $ro['codigocate'];
        $querycat = "SELECT*FROM categoria where codigocate='$idcategprod' ORDER BY idcategoria DESC";
        $resultcat = mysqli_query($conexion, $querycat);
        $catego = mysqli_fetch_all($resultcat, MYSQLI_ASSOC);
        foreach ($catego as $row2) {
            $id_categ = $row2['idcategoria'];
            $imag_categ = base64_encode($row2['imagen']);
            $nombre_categ = sed::decryption($row2['nombrecateg']);
            $descripcion_categ = sed::decryption($row2['descripcioncateg']);
        }
        $consulta_u = ("SELECT * FROM logueo_empresa  WHERE logueo_empresa.id_empresa='$ide_prod'");
        $query1u = mysqli_query($mysqli, $consulta_u);
        $empres = mysqli_fetch_all($query1u, MYSQLI_ASSOC);
        foreach ($empres as $arraye) { }
        ?>
        <li class="" style="margin-top: 8px;">
            <div class="invi border-primary " style="width: 100%;height: 180%;" category="iquitos">
                <img src="data:image/jpg;base64,<?php echo $image; ?>" style="width: 100%" alt="imagen invitado">
                <p class="p"><?php echo $nombretort; ?></p>
            </div>
        </li>
    <?php
    }
    ?>
    <br>
    <div style="width: 42%; margin-left: 20px; border: 2px solid blue;  display: inline-block;">
        <div style="border: 2px solid blue;">
            <center>
                <h1 style="color:blue; font-size: 32px;"><strong> Categoria</strong></h1>
            </center>
        </div>
        <div style="border: 2px solid blue;">
            <center>
                <p><strong><?php
                            if (!empty($nombre_categ)) {
                                echo $nombre_categ;
                            } else {
                                echo "Se eliminó la categoria";
                            } ?></strong></p>
            </center>
        </div>
    </div>
    <?php
    if (!empty($preciotorta)) {
        ?>
        <div style="width: 40%; margin-left: 20px; border: 2px solid blue; display: inline-block; ">
            <div style="border: 2px solid blue;">
                <center>
                    <h1 style="color:blue; font-size: 32px;"><strong> Precio</strong></h1>
                </center>
            </div>
            <div style="border: 2px solid blue;">
                <center>
                    <p><strong>S/.<?php echo $preciotorta; ?></strong></p>
                </center>
            </div>
        </div>
    <?php
    }
    ?>
    <?php
    if (!empty($detalletorta)) {
        ?>
        <div style="width: 85%; margin-left: 20px; border: 2px solid blue;  display: inline-block; margin-top: 15px;">
            <div style="border: 2px solid blue; background: orange;">
                <h1 style="color:white; font-size: 22px; margin-left: 12px;"><strong>Detalles del producto</strong></h1>

            </div>
            <div style="border: 2px solid blue;">
                <p style="margin-left:12px; text-align:initial;"><strong><?php echo $detalletorta; ?></strong></p>
            </div>
        </div>
    <?php
    }
    ?>
    <form action="" id="form-login" method="post">
        <div style="width: 86%; margin-left: 20px;  margin-top: 22px;">
            <div class="row g-3">
                <div class="col">
                    <input type="hidden" class="form-control" name="idproducto" value="<?php echo $id; ?>" required="required" />
                    <label for="" style="color:blue; margin-left: 8px;" class="formulario__label"><strong>Cantidad:</strong> </label>
                    <input type="number" name="cantidadproduct" style="width: 80%; margin-left: 100px; margin-top:-40px;" class="form-control" placeholder="Ingrese la cantidad a pedir">
                </div>
            </div>
        </div>
        <div class="row g-3">
            <div style="width: 70%; display: inline-block;">
                <!--<a href="ordenar.php?idproducto=<?php //echo $id; 
                                                    ?>" >
                    HACER MI ORDEN
                </a>-->
                <input type="submit" name="hacerorden" value="HACER MI ORDEN" style="width:90%; margin-left: 40px;" class="btn btn-success">
            </div>
            <div style="width: 30%; display: inline-block;">
                <input type="submit" style="width:86%; margin-left: 5px;" class="btn btn-primary" name="añadircarrito" value="AÑADIR AL CARRITO">
            </div>
        </div>
        <!--<a class="btn" href="admveregistorta.php" role="button" value="Ver torta">
                    <input type="button" style="width:150px" class="btn btn-primary" value="Ver torta">
                </a>-->
    </form>
    <?php
    if (@!$_SESSION['idusu']) { //si la session del usuario esta vacia
        echo '<div class="alert alert-danger" style="text-align:center;" role="alert">Inicia sessión para hacer tu orden . </div>';
    } else if ($_SESSION['rolusu'] == "user") { //sino si la session rol no esta 
        if (isset($_POST['hacerorden'])) {
            extract($_GET);
            $idus = $_SESSION['idusu'];
            $idpr = $_POST['idproducto'];
            $cantidadproduct = $_POST['cantidadproduct'];
            if ($cantidadproduct > 0) {// La cantidad a pedir del producto es mayor a 0
                echo "<script>location.href='ordenar.php?idproducto=$id&cantidadpedir=$cantidadproduct'</script>";
            } else {
                echo '<div class="alert alert-danger" style="text-align:center;" role="alert">La cantidad a pedir del producto tiene que ser mayor a 0. </div>';
            }
        }
        if (isset($_POST['añadircarrito'])) {
            extract($_GET);
            $idus = $_SESSION['idusu'];
            $idpr = $_POST['idproducto'];
            $cantidadproduct = $_POST['cantidadproduct'];
            if ($cantidadproduct > 0) {// La cantidad a pedir del producto es mayor a 0
                $sql = "SELECT * FROM productos WHERE idproducto=$idpr";
                //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
                $producsql = mysqli_query($mysqli, $sql);
                $producto = mysqli_fetch_all($producsql, MYSQLI_ASSOC);
                foreach ($producto as $row) {
                    $idp = $row['idproducto'];
                    $nombreprodu = sed::decryption($row['nombreproducto']);
                    $costoprodu = sed::decryption($row['costoproducto']);
                }
                $checkprod = mysqli_query($mysqli, "SELECT * FROM carrito WHERE idproducto='$idpr'");
                $check_produc = mysqli_num_rows($checkprod);
                //if ($check_produc > 0) { //si existe el producto favorito
                  //  echo "<div class='alert alert-warning' role='alert'> Ya agregaste $nombreprodu al carrito, solo se puede agregar una vez. </div>";
                //} else {
                    // Obtener el monto total según cantidad de productos.
                    $preciototal = ($costoprodu * $cantidadproduct);
                    // Obtener IGV.
                    $igv = $preciototal * 0.18;
                    // Monto total a pagar incluido IGV.
                    $monto_total = $preciototal + $igv;
                    //echo "Precio total: " . $monto_total . " soles";
                    $query = "INSERT INTO carrito 
                    (idproducto, idusu, cantidadpedir, precio, fechacarrito, horacarrito, estadocarrito, total) 
            VALUES('$id', '$idus', '$cantidadproduct','$costoprodu' ,now(), now(), '1', '$preciototal')";
                    $resultado = $conexion->query($query);
                    if ($resultado) {
                        echo "<div class='alert alert-primary' role='alert'> $nombreprodu se agregó al carrito. </div>";
                        echo "<script>location.href='verproducto.php?idproducto=$id'</script>";
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Hubo problemas al agregar al carrito, intenta nuevamente. </div>';
                        echo "<script>location.href='verproducto.php?idproducto=$id'</script>";
                    }
                //}
            } else {
                echo '<div class="alert alert-danger" style="text-align:center;" role="alert">La cantidad a pedir del producto tiene que ser mayor a 0. </div>';
            }
        }
    }
    ?>
    <?php
    if (@$report == 1) {
        $idlog = @$_SESSION['idusu'];
        $sql = "SELECT * FROM productos WHERE idproducto=$idproducto";

        //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
        $ressql = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_row($ressql)) {
            $id = $row[0];
            $nombreprodu = sed::decryption($row[2]);
        }
        $checkprod = mysqli_query($mysqli, "SELECT * FROM reporteproducto WHERE idproducto='$id'");
        $check_produc = mysqli_num_rows($checkprod);
        if ($check_produc > 0) { //si existe el producto favorito
            echo "<div class='alert alert-warning' role='alert'> Ya reportaste el producto $nombreprodu, solo se puede reportar una vez cada producto. </div>";
        } else {
            $query_report = "INSERT INTO reporteproducto (idproducto, fecha_reporte, idusu) VALUES('$id', now(),'$idlog')";
            $resultado_reporte = $conexion->query($query_report);
            if ($resultado_reporte) {
                echo "<div class='alert alert-primary' role='alert'> Reportaste el producto $nombreprodu . </div>";
                //echo "<script>location.href='torta.php?id=$id'</script>";
            } else {
                echo '<div class="alert alert-danger" role="alert">Hubo problemas al reportar, intenta nuevamente. </div>';
                echo "<script>location.href='verproducto.php?idproducto=$id'</script>";
            }
        }
    }
    if (@$favorito == 1) {
        extract($_GET);
        $idus = @$_SESSION['idusu'];
        $sql = "SELECT * FROM productos WHERE idproducto=$idproducto";

        //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
        $ressql = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_row($ressql)) {
            $id = $row[0];
            $nombreprodu = sed::decryption($row[2]);
        }
        $checkprod = mysqli_query($mysqli, "SELECT * FROM favoritos WHERE idproducto='$id'");
        $check_produc = mysqli_num_rows($checkprod);
        if ($check_produc > 0) { //si existe el producto favorito
            echo "<div class='alert alert-warning' role='alert'> Ya agregaste $nombreprodu a tus favoritos, solo se puede agregar una vez. </div>";
        } else {
            $query = "INSERT INTO favoritos (idproducto, idusu, fecha_guardado) 
            VALUES('$id', '$idus',now())";
            $resultado = $conexion->query($query);
            if ($resultado) {
                echo "<div class='alert alert-primary' role='alert'> $nombreprodu se agregó a tus favoritos. </div>";
                //echo "<script>location.href='verproducto.php?idproducto=$id'</script>";
            } else {
                echo '<div class="alert alert-danger" role="alert">Hubo problemas al agregar a tu favorito, intenta nuevamente. </div>';
                echo "<script>location.href='verproducto.php?idproducto=$id'</script>";
            }
        }
    }
    if (@$carrito == 1) { }
    ?>
    <form name="form1" method="post" action="">
        <label for="textarea"></label>
        <div style="width: 100%;">
            <input type="hidden" class="form-control" name="idproducto" value="<?php echo $id; ?>" required="required" />
            <textarea name="comentario" style="width: 74%;display:inline-block;  margin-left:22px;" rows="2" id="textarea" class="form-control"><?php if (isset($_GET['user'])) { ?>@<?php echo $_GET['user']; ?><?php } else { ?> Agrega un comentario acerca del producto...<?php } ?></textarea>
            <input type="submit" <?php if (isset($_GET['comentario'])) { ?>name="reply" <?php } else { ?>name="comentar" <?php } ?> class="btn btn-primary" style="display:inline-block; margin-top:-38px;" value="Comentar">
        </div>
    </form>
    <?php
    if (isset($_POST['comentar'])) {
        if (@$_SESSION['rolusu'] == "user") { //sino si la session rol no esta 
            $comentarios= sed::encryption($_POST['comentario']);
            if (!empty($_POST['comentario'])) {
                $query = mysqli_query($mysqli, "INSERT INTO comentarios (idproducto, idusu,comentario,fecha) 
      value ('" . $_POST['idproducto'] . "','" . @$_SESSION['idusu'] . "','$comentarios',NOW())");
                if ($query) {
                    echo "<script>location.href='verproducto.php?idproducto=$id'</script>";
                }
            } else { 
                echo '<div class="alert alert-danger" role="alert">El comentario no debe ir vacío. </div>';
            }
        } else {
            echo "<script>location.href='logueo.php'</script>";
        }
    }
    if (isset($_POST['reply'])) {
        $comentarios = sed::encryption($_POST['comentario']);
        if (@$_SESSION['rolusu'] == "user") { //sino si la session rol no esta
            if (!empty($_POST['comentario'])) {
                $query = mysqli_query($mysqli, "INSERT INTO comentarios(idproducto, idusu,comentario,reply,fecha) 
  value ('" . $_POST['idproducto'] . "','" . $_SESSION['idusu'] . "','$comentarios','" . $_GET['comentario'] . "',NOW())");
                if ($query) {
                    echo "<script>location.href='?idproducto=$id'</script>";
                } else {
                    echo "Error: " . $query . "<br>" . mysqli_error($mysqli);
                    echo "No se pudo agregar";
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">El comentario no debe ir vacío. </div>';
            }
        } else if (@$_SESSION['rolusu'] == "empresa") { //sino si la session rol no esta
            if (!empty($_POST['comentario'])) {
                $query = mysqli_query($mysqli, "INSERT INTO comentarios(idproducto, id_empresa,comentario,reply,fecha) 
  value ('" . $_POST['idproducto'] . "','" . $_SESSION['idusu'] . "','$comentarios','" . $_GET['comentario'] . "',NOW())");
                if ($query) {
                    echo "<script>location.href='?idproducto=$id'</script>";
                } else {
                    echo "Error: " . $query . "<br>" . mysqli_error($mysqli);
                    echo "No se pudo agregar";
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">El comentario no debe ir vacío. </div>';
            }
        }
    }
    include "comentarios.php";
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha256-OUFW7hFO0/r5aEGTQOz9F/aXQOt+TwqI1Z4fbVvww04=" crossorigin="anonymous"></script>

    <script src="./js/script2.js"></script>
</body>

</html>