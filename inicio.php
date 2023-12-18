<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="img/reservaenviada.png" style="height: 340px; background-color:green;" class="d-block w-100"
                alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5 style="color:white;"><strong>HAGA SU ORDEN!!</strong></h5>

                <?php
                if (@!$_SESSION['idusu']) { //si la session del usuario esta vacia
                    echo '<a href="logueo.php" class="btn btn-primary">Ir pedir orden</a>';
                    //El @ oculta los mensajes de error que pueda salir
                } else if ($_SESSION['rolusu'] == "user") { //sino si la session rol no esta vacia
                    echo '<a href="registro.php" class="btn btn-primary">Ir pedir orden</a>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<center>
    <?php
    //validar
    if (@!$_SESSION['idusu']) { //si la session del usuario esta vacia
        //El @ oculta los mensajes de error que pueda salir
    } elseif ($_SESSION['rolusu'] == "user") { //sino si la session rol no esta vacia
        echo "<h1 style='color: blue; font-size: 26px;'><u>Bienvenido: <strong> " . ucwords($nom) . ' ' . ucwords($apelli) . "</u></strong> </h1>";
    }
    ?>
</center>
<br>

<div class="container">
    <?php
    $querymo = "SELECT*FROM productos_masordenados ORDER BY cantidadordenados DESC LIMIT 4";
    $resul_cantmo = mysqli_query($conexion, $querymo);
    $cantidadmo = mysqli_num_rows($resul_cantmo);
    $masordenados = mysqli_fetch_all($resul_cantmo, MYSQLI_ASSOC);
    ?>
    <h5 class="card-title">Productos populares:</h5>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
        <?php
        if ($cantidadmo > 0) {
        ?>
        <?php
            foreach ($masordenados as $row) {
                $id_masordenados = $row['id_masordenados'];
                $id_prod = $row['idproducto'];
                $sqlp = "SELECT*FROM productos WHERE idproducto='$id_prod' ORDER BY idproducto DESC";
                $resul_cant = mysqli_query($conexion, $sqlp);
                $cantidadp = mysqli_num_rows($resul_cant);
                $produ = mysqli_fetch_all($resul_cant, MYSQLI_ASSOC);
                foreach ($produ as $rowp) {
                    $id = $rowp['idproducto'];
                    $ide_prod = $rowp['id_empresa'];
                    $idcategprod = $rowp['codigocate'];
                }
                $querycat = "SELECT*FROM categoria where codigocate='$idcategprod' ORDER BY idcategoria DESC";
                $resultcat = mysqli_query($conexion, $querycat);
                $catego = mysqli_fetch_all($resultcat, MYSQLI_ASSOC);
                foreach ($catego as $row2) {
                    $id_categ = $row2['idcategoria'];
                }
                $consulta_u = ("SELECT * FROM logueo_empresa  WHERE logueo_empresa.id_empresa='$ide_prod'");
                $query1u = mysqli_query($conexion, $consulta_u);
                $empres = mysqli_fetch_all($query1u, MYSQLI_ASSOC);
                foreach ($empres as $arraye) {
                }
            ?>
        <div class="col mb-4">
            <div class="card h-100">
                <img src="data:image/jpg;base64,<?php echo base64_encode($rowp['imagproducto']); ?>" height="150"
                    class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title text-primary" style="font-size: 18px;">
                        <strong> <?php echo sed::decryption($rowp['nombreproducto']); ?></strong>
                    </h5>
                    <p class="card-text">
                        <strong>Empresa: <?php echo sed::decryption($arraye["nombreempresa"]); ?></strong>
                    </p>
                    <div class="row">
                        <div class="col-6">
                            <p class="card-text ">
                                <strong><?php echo sed::decryption($row2['nombrecateg']); ?></strong>
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="card-text text-end text-primary">
                                <strong>S/.<?php echo sed::decryption($rowp['costoproducto']); ?> </strong>
                            </p>
                        </div>
                    </div>

                </div>
                <div class="card-footer border-primary">
                    <!--poner cada boton al costado-->
                    <div class="row">
                        <div class="col-6">
                            <a href="verproducto.php?idproducto=<?php echo $id; ?>" class="btn btn-outline-primary">
                                Ver...
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="index.php?idproducto=<?php echo $id; ?>&index=1&p=1"
                                class="btn btn-outline-primary">
                                <img src="img/carrito.png" style="width: 30px; height: 20px;" alt="imgproductos">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php } ?>

    <?php
$querycat = "SELECT*FROM categoria  ORDER BY idcategoria DESC";
$resultcat = mysqli_query($conexion, $querycat);
$cantidadcat = mysqli_num_rows($resultcat);
$catego = mysqli_fetch_all($resultcat, MYSQLI_ASSOC);
?>

    <h5 class="card-title">Categorias:</h5>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
        <?php
    if ($cantidadcat > 0) {
    ?>
        <?php
        foreach ($catego as $row2) {
            $id_categ = $row2['idcategoria'];
            $imag_categ = base64_encode($row2['imagen']);
            $nombre_categ = sed::decryption($row2['nombrecateg']);
            $descripcion_categ = sed::decryption($row2['descripcioncateg']);
            $idcategprod = $row2['codigocate'];
            $sql1 = "SELECT imagproducto, count(codigocate) as totalproducto, codigocate FROM productos 
                where codigocate='$idcategprod' ORDER BY codigocate";
            $resultado = mysqli_query($conexion, $sql1);
            $pro = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            foreach ($pro as $arre) {
                $image = base64_encode($arre['imagproducto']);
                $totalproduc = $arre['totalproducto'];
            }
        ?>
        <div class="col mb-4">
            <div class="card h-100">
                <img src="data:image/jpg;base64,<?php echo $imag_categ;
                                                    ?>" height="150" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title text-center" style="font-size: 18px;">
                        <strong><?php echo sed::decryption($row2['nombrecateg']); ?></strong>
                    </h5>
                    <p class="card-text text-center">
                        <strong><?php echo $totalproduc; ?></strong>
                    </p>
                </div>
                <div class="card-footer border-primary">
                    <a href="index.php?productos=1" class="btn btn-outline-primary">
                        Ver categorias
                    </a>
                </div>
            </div>

        </div>
        <?php } ?>
        <?php } ?>
    </div>
</div>
<div class="container">
    <?php
    if (@!$_SESSION['idusu']) { //si la session del usuario esta vacia
    ?>
    <div class="row justify-content-md-center border-primary"
        style="background-color: orange;border-radius: 35px; width: 100%; margin-left: 0;">
        <div class="col-12 col-md-6">
            <figure class="full-box">
                <img src="img/registracion.png" alt="registration_killaripostres" class="img-fluid">
            </figure>
        </div>
        <div class="w-100"></div>
        <div class="col-12 col-md-6">
            <h3 style="color:white;" class="text-center text-uppercase poppins-regular font-weight-bold">
                <strong>Crea tu cuenta</strong>
            </h3>
            <p class="text-justify" style="color:white;"><strong>
                    Crea tu cuenta para poder realizar tu orden de menú y/o administrar tus órdenes desde la
                    comodidad
                    de tu casa, es muy fácil y rápido.</strong>
            </p>
            <p class="text-center">
                <a href="registrarme.php" class="btn btn-primary">Crear cuenta</a>
            </p>
        </div>
    </div><br>
    <?php
        //El @ oculta los mensajes de error que pueda salir
    }
    ?>

    <h2 style="color:blue;"><strong>Nuestros Servicios</strong></h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
            <div class="card h-100">
                <img src="img/repartidor.png" height="300" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title text-center ">Envio a domicilio</h5>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <img src="img/venta.png" height="300" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title text-center">Ventas a por mayor</h5>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <img src="img/negocio.png" height="300" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title text-center">Retiro en negocio local</h5>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <div class="card border-primary mb-3">
                <div class="card-header bg-transparent border-success">Tipos de productos</div>
                <div class="card-body text-primary">
                    <p class="card-text">
                        Aquí se mostrarán los tipos de productos que se ofrecen en la empresa y que usted puede
                        ordenar.
                    </p>
                </div>
                <div class="card-footer bg-transparent border-success">
                    <a href="tipostortas.php" class="btn btn-primary">Ir ver menú</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card border-primary mb-3">
                <div class="card-header bg-transparent border-success">Mi pedido</div>
                <div class="card-body text-primary">
                    <p class="card-text">
                        Usted puede realizar su pedido de producto desde la comodidad de su casa, solo debe
                        registrarse
                        y
                    </p>
                </div>
                <div class="card-footer bg-transparent border-success">
                    <a <?php if (@!$_SESSION['idusu']) { ?> href="logueo.php"
                        <?php } else if ($_SESSION['rolusu'] == "u2") { ?>href="registro.php"
                        <?php } ?>style="color:white;" class="btn btn-primary">Ir ordenar</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--------------------------------------------------------------------------------------->
<style>

</style>
<!------------------------------------------------------------------------------>
<br>
<div style="background-color: orange;">
    <p id="whatsapp">
        <a id="app-whatsapp" target="_blank"
            href="https://api.whatsapp.com/send?phone=51966820221&amp;text=Hola!&nbsp;ví&nbsp;su&nbsp;sitio&nbsp;web&nbsp;de&nbsp;Killari&nbsp;Postres,&nbsp;tengo&nbsp;una&nbsp;consulta">
            <strong id="mensaje">Envía mensaje al Whattsapp</strong>
            <img rel="icon" src='img/whatsapp.png' style="width: 60px; height: 60px;" type="img/jpg" />
            <!--<i class="icon-whatsapp1"></i>-->
        </a>
    </p>
    <style>

    </style>
</div>
<?php
if (@$p == 1) {
    extract($_GET);
    $idus = $_SESSION['idusu'];
    $sql = "SELECT * FROM productos WHERE idproducto=$idproducto";
    //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
    $producsql = mysqli_query($mysqli, $sql);
    $producto = mysqli_fetch_all($producsql, MYSQLI_ASSOC);
    foreach ($producto as $row) {
        $idp = $row['idproducto'];
        $nombreprodu = sed::decryption($row['nombreproducto']);
        $costoprodu = sed::decryption($row['costoproducto']);
    }
    $checkprod = mysqli_query($mysqli, "SELECT * FROM carrito WHERE idproducto='$idproducto'");
    $check_produc = mysqli_num_rows($checkprod);
    $preciototal = ($costoprodu * 1);
    $query = "INSERT INTO carrito 
                                        (idproducto, idusu, cantidadpedir, precio, fechacarrito, horacarrito, estadocarrito, total) 
                                VALUES('$idp', '$idus', '1','$costoprodu' ,now(), now(), '1', '$preciototal')";
    $resultado = $conexion->query($query);
    if ($resultado) {
        //echo "se guardo";
        echo "<script>location.href='index.php?index=1'</script>";
    } else {
        //echo "no se guardo";
        echo "<script>location.href='index.php?index=1'</script>";
    }
}
?>