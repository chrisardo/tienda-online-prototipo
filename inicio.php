<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="img/reservaenviada.png" style="height: 340px; background-color:green;" class="d-block w-100" alt="...">
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
<div class="contorno">
    <?php
    $querymo = "SELECT*FROM productos_masordenados ORDER BY cantidadordenados DESC LIMIT 4";
    $resul_cantmo = mysqli_query($conexion, $querymo);
    $cantidadmo = mysqli_num_rows($resul_cantmo);
    $masordenados = mysqli_fetch_all($resul_cantmo, MYSQLI_ASSOC);
    ?>
    <?php
    if ($cantidadmo > 0) {
        ?>
        <p style="color: green; font-size: 16px;margin-left: 12px; margin-top: 3px; "><strong>POPULARES: </strong></p>
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
                $query1u = mysqli_query($mysqli, $consulta_u);
                $empres = mysqli_fetch_all($query1u, MYSQLI_ASSOC);
                foreach ($empres as $arraye) { }
                ?>
            <div class="contorno2">
                <div class="divimg">
                    <img src="data:image/jpg;base64,<?php echo base64_encode($rowp['imagproducto']); ?>" style="width: 100%; height:100px;" alt="imgproductos">
                    <!--<img src="img/logo.png" style="width: 100%; height:100px;" alt="imgproductos"-->
                </div>
                <div style="width: 102%;">
                    <div class="pe">
                        <p style="color: blue;">
                            <strong> <?php echo sed::decryption($rowp['nombreproducto']); ?></strong>
                        </p>
                    </div>
                    <a href="verempresa.php?id=<?php echo $arraye["id_empresa"]; ?>" style="color:green; ">
                        <div class="pe" style="margin-top:-12px;">
                            <p>
                                <strong>Empresas: <?php echo sed::decryption($arraye["nombreempresa"]); ?></strong>
                            </p>
                        </div>
                    </a>
                    <div style="margin-top:-12px; width: 100%;">
                        <div class="contenedor3">
                            <p class="pc"><strong><?php echo sed::decryption($row2['nombrecateg']); ?></strong>
                            </p>
                        </div>
                        <div class="contenedor3">
                            <p class="pc" style="color:orangered;"><strong>S/.<?php echo sed::decryption($rowp['costoproducto']);
                                                                                        ?> </strong></p>
                        </div>
                    </div>
                </div>
                <div style="widh:100%;">
                    <div class="btnp" style="display: inline-block;">
                        <a href="verproducto.php?idproducto=<?php echo $id; ?>">
                            <div class="buttonprod btn btn-primary">
                                Ver
                            </div>
                        </a>
                    </div>
                    <div style="display: inline-block;">
                        <a href="index.php?idproducto=<?php echo $id; ?>&index=1&p=1">
                            <div style="border: 2px solid blue; " class="buttonprod btn btn-primary">
                                Añadir al carrito
                            </div>
                        </a>

                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>
<div class="contorno">
    <?php
    $querycat = "SELECT*FROM categoria  ORDER BY idcategoria DESC";
    $resultcat = mysqli_query($conexion, $querycat);
    $cantidadcat = mysqli_num_rows($resultcat);
    $catego = mysqli_fetch_all($resultcat, MYSQLI_ASSOC);
    ?>
    <?php
    if ($cantidadcat > 0) {
        ?>
        <p style="color: green; font-size: 15px;margin-left: 12px; margin-top: 3px; "><strong>CATEGORIAS: </strong></p>
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
            <div class="contornocate">
                <div class="cate">
                    <p style="color: blue;">
                        <strong> <?php echo sed::decryption($row2['nombrecateg']); ?></strong>
                    </p>
                </div>
                <div class="divimg">
                    <img src="data:image/jpg;base64,<?php echo $imag_categ;
                                                            ?>" style="width: 100%; height:110px;" alt="imgproductos">
                    <!--<img src="img/logo.png" style="width: 100%; height:120px;" alt="imgproductos">-->
                </div>

                <div class="contenedorcate">
                    <p class="catecanti"><strong><?php echo $totalproduc; ?></strong>
                    </p>
                </div>
                <a href="index.php?productos=1" style="color:green; ">
                    <div class="buttonp">
                        Ver categorias
                    </div>
                </a>
            </div>
        <?php } ?>
    <?php } ?>
</div><br>
<?php
if (@!$_SESSION['idusu']) { //si la session del usuario esta vacia
    ?>
    <div class="container container-web-page ">
        <div class="row justify-content-md-center border-primary" style="background-color: orange;border-radius: 35px; width: 100%; margin-left: 0;">
            <div class="col-12 col-md-6">
                <figure class="full-box">
                    <img src="img/registracion.png" alt="registration_killaripostres" class="img-fluid">
                </figure>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-md-6">
                <h3 style="color:white;" class="text-center text-uppercase poppins-regular font-weight-bold">
                    <strong>Crea tu cuenta</strong></h3>
                <p class="text-justify" style="color:white;"><strong>
                        Crea tu cuenta para poder realizar tu orden de menú y/o administrar tus órdenes desde la comodidad de tu casa, es muy fácil y rápido.</strong>
                </p>
                <p class="text-center">
                    <a href="registrarme.php" class="btn btn-primary">Crear cuenta</a>
                </p>
            </div>
        </div>
    </div><br>
<?php
    //El @ oculta los mensajes de error que pueda salir
} else if ($_SESSION['rolusu'] == "user") { //sino si la session rol no esta vacia

}
?>
<h2 style="color:blue;"><strong>Nuestros Servicios</strong></h2>
<div class="contorno">
    <div class="contornocate">
        <div class="divimg">
            <img src="img/repartidor.png" style="width: 100%; height:170px;" alt="imgproductos">
        </div>

        <div class="contenedorcate">
            <p class="conten"><strong>ENVÍOS A DOMICILIO</strong>
            </p>
        </div>
    </div>
    <div class="contornocate">
        <div class="divimg">
            <img src="img/venta.png" style="width: 100%; height:170px;" alt="imgproductos">
        </div>

        <div class="contenedorcate">
            <p class="conten"><strong>VENTAS AL POR MAYOR</strong>
            </p>
        </div>
    </div>
    <div class="contornocate">
        <div class="divimg">
            <img src="img/negocio.png" style="width: 100%; height:170px;" alt="imgproductos">
        </div>

        <div class="contenedorcate">
            <p class="conten"><strong>RETIRO EN NEGOCIO LOCAL</strong>
            </p>
        </div>
    </div>
</div>
<!--------------------------------------------------------------------------------------->
<div style="width: 100%; margin-top: 6px;">
    <div class="s1">
        <div class="s_border" style="display: inline-block; border: 2px solid blue; border-radius: 6px;">
            <div style="margin-left: 10px; margin-top: 6px;">
                <h5 style="color:blue;"><strong>Tipos de menús</strong></h5>
            </div>
            <div style="width: 95%; margin-left: 6px; background-color: blue; height: 2px;"></div>
            <div class="texto1" style="margin-left: 10px; margin-top: 4px;  word-wrap: break-word;">
                <p class="p1">
                    <strong>
                        Los tipos de menú que hemos hecho abarcan desde entradas, Platos de fondo, Sopas, entre otros y nuestro servicio de delivery es gratis. </strong>
                </p>
            </div>
            <div class="boton1" style="margin-left: 8px; border:2px;">
                <a href="tipostortas.php" class="btn btn-primary">Ir ver menú</a>
            </div>
        </div>
        <div class="r_border" style="display: inline-block; border: 2px solid blue; border-radius: 6px;">
            <div style="margin-left: 10px; margin-top: 6px;">
                <h5 style="color:blue;"><strong>ORDENAR</strong></h5>
            </div>
            <div style="width: 95%; margin-left: 6px; background-color: blue; height: 2px;"></div>
            <div class="texto2" style="margin-left: 6px; margin-top: 4px; word-wrap: break-word;">
                <p class="p2">
                    <strong>
                        Usted puede hacer su orden de cualquier tipo de menú a su preferencia en línea, lo cual se le enviará la información a los chefs para que prepare el pedido que usted hizo. </strong>
                </p>
            </div>
            <div class="boton2" style="margin-left: 8px;  border:2px;">
                <a <?php if (@!$_SESSION['idusu']) { ?> href="logueo.php" <?php } else if ($_SESSION['rolusu'] == "u2") { ?>href="registro.php" <?php } ?>style="color:white;" class="btn btn-primary">Ir ordenar</a>
            </div>
        </div>
    </div>
</div>
<style>

</style>
<!------------------------------------------------------------------------------>
<br>
<div style="background-color: orange;">
    <p id="whatsapp">
        <a id="app-whatsapp" target="_blank" href="https://api.whatsapp.com/send?phone=51966820221&amp;text=Hola!&nbsp;ví&nbsp;su&nbsp;sitio&nbsp;web&nbsp;de&nbsp;Killari&nbsp;Postres,&nbsp;tengo&nbsp;una&nbsp;consulta">
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
<style>
    div .contorno {
        width: 97%;
        margin-left: 12px;
        margin-top: -3px;
    }

    div .buttonp {
        border: 2px solid green;
        margin-left: 6px;
        color: green;
        width: 90%;
        height: 25px;
        text-align: center;
        margin-top: -2px;
        background-color: white;
        font-size: 13px;
    }

    /*--Estilos responsive--*/
    @media screen and (min-width:350px) {
        div .cate {
            font-size: 15px;
            text-align: center;
        }

        div .contornocate {
            width: 29%;
            height: 226px;
            margin-left: 9px;
            border-radius: 6px;
            margin-top: 4px;
            border: 2px solid green;
            display: inline-block;
        }

        div .contenedorcate {
            display: inline-block;
            margin-left: 3px;
            width: 96%;
            height: 28px;
        }

        div .catecanti {
            text-align: center;
            font-size: 15px;
        }

        div .conten {
            text-align: center;
            font-size: 12px;
        }
    }

    @media screen and (min-width:390px) {
        div .cate {
            font-size: 15px;
            text-align: center;
        }

        div .contornocate {
            width: 28%;
            margin-left: 14px;
            border-radius: 6px;
            border: 2px solid green;
            display: inline-block;
        }

        div .contenedorcate {
            display: inline-block;
            margin-left: 3px;
            width: 96%;
            height: 28px;
        }

        div .catecanti {
            text-align: center;
            font-size: 16px;
        }
    }

    @media screen and (min-width:468px) {
        div .cate {
            font-size: 16px;
            text-align: center;
        }

        div .contornocate {
            width: 28%;
            margin-left: 16px;
        }

        div .catecanti {
            text-align: center;
            font-size: 18px;
        }
    }

    @media screen and (min-width:530px) {
        div .conten {
            text-align: center;
            font-size: 14px;
        }
    }

    @media screen and (min-width:730px) {
        div .cate {
            font-size: 16px;
            text-align: center;
        }

        div .contornocate {
            width: 30%;
            margin-left: 16px;
        }

        div .catecanti {
            text-align: center;
            font-size: 18px;
        }

        div .conten {
            text-align: center;
            font-size: 16px;
        }

        div .buttonp {
            margin-left: 12px;
        }
    }

    @media screen and (min-width:910px) {
        div .cate {
            font-size: 18px;
            text-align: center;
        }

        div .contornocate {
            width: 30%;
            margin-left: 19px;
        }

        div .catecanti {
            text-align: center;
            font-size: 18px;
        }

        div .buttonp {
            margin-left: 12px;
        }
    }

    @media screen and (min-width:1020px) {
        div .cate {
            font-size: 18px;
            text-align: center;
        }

        div .contornocate {
            width: 31%;
            margin-left: 16px;
        }

        div .catecanti {
            text-align: center;
            font-size: 18px;
        }

        div .buttonp {
            margin-left: 12px;
        }
    }

    @media screen and (min-width:1270px) {
        div .cate {
            font-size: 18px;
            text-align: center;
        }

        div .contornocate {
            width: 31%;
            margin-left: 20px;
        }

        div .catecanti {
            text-align: center;
            font-size: 18px;
        }

        div .buttonp {
            margin-left: 16px;
        }
    }
</style>
<style>
    /* estilod del cuadro de producto*/
    div .contorno {
        width: 98%;
        margin-left: 15px;
    }

    div .contorno2 {
        display: inline-block;
        border: 2px solid blue;
        width: 24%;
        margin-left: 8px;
        background-color: greenyellow;
    }

    div .buttonprod {
        border: 2px solid green;
        height: 36px;
        text-align: center;
        margin-left: 3px;
    }

    div .pe {
        font-size: 14px;
        margin-left: 3px;
    }

    div .contenedor3 {
        display: inline-block;
        margin-left: 5px;
        width: 46%;
        height: 32px;
    }

    /*--Estilos responsive--*/
    @media screen and (min-width:350px) {
        div .contorno {
            width: 97%;
            margin-left: 12px;
        }

        div .pe {
            font-size: 10px;
        }

        div .contorno2 {
            width: 46%;
            margin-left: 8px;
            margin-top: 4px;
        }

        div .contenedor3 {
            display: inline-block;
            margin-left: 3px;
            width: 46%;
            height: 32px;
        }

        div .pc {
            font-size: 12px;
        }

        div .buttonprod {
            width: 98%;
            margin-left: 4px;
            font-size: 10px;
        }
    }

    @media screen and (min-width:388px) {
        div .pe {
            font-size: 11px;
        }

        div .contorno2 {
            width: 46%;
            margin-left: 9px;
            margin-top: 4px;
        }

        div .contenedor3 {
            display: inline-block;
            margin-left: 3px;
            width: 46%;
            height: 32px;
        }

        div .pc {
            font-size: 12px;
        }

        div .buttonprod {
            width: 100%;
            margin-left: 5px;
            font-size: 11px;
        }
    }

    @media screen and (min-width:468px) {
        div .pe {
            font-size: 12px;
        }

        div .contorno2 {
            width: 46%;
            margin-left: 11px;
        }

        div .buttonprod {
            width: 100%;
            margin-left: 6px;
            font-size: 11px;
        }
    }

    @media screen and (min-width:538px) {
        div .pe {
            font-size: 13px;
        }

        div .contorno2 {
            width: 46%;
            margin-left: 12px;
        }

        div .buttonprod {
            width: 100%;
            margin-left: 6px;
            font-size: 13px;
        }

        div .pc {
            font-size: 13px;
        }
    }

    @media screen and (min-width:624px) {
        div .pe {
            width: 100%;
            font-size: 14px;
        }

        div .contorno2 {
            width: 46%;
            margin-left: 12px;
        }

        div .pc {
            font-size: 14px;
        }

        div .buttonprod {
            width: 100%;
            margin-left: 7px;
            font-size: 14px;
        }
    }

    @media screen and (min-width:730px) {
        div .pe {
            font-size: 15px;
        }

        div .contorno2 {
            width: 46%;
            margin-left: 14px;
        }

        div .contenedor3 {
            display: inline-block;
            margin-left: 4px;
            width: 46%;
            height: 32px;
        }

        div .pc {
            font-size: 14px;
        }

        div .buttonprod {
            width: 100%;
            margin-left: 8px;
            font-size: 17px;
        }
    }

    @media screen and (min-width:815px) {
        div .pe {
            font-size: 11px;
        }

        div .contorno2 {
            width: 23%;
            margin-left: 10px;
        }

        div .contenedor3 {
            display: inline-block;
            margin-left: 4px;
            width: 46%;
            height: 32px;
        }

        div .pc {
            font-size: 12px;
        }

        div .buttonprod {
            width: 100%;
            margin-left: 8px;
            font-size: 17px;
        }
    }

    @media screen and (min-width:910px) {
        div .pe {
            font-size: 13px;
        }

        div .contorno2 {
            width: 23%;
            margin-left: 12px;
        }

        div .contenedor3 {
            display: inline-block;
            margin-left: 4px;
            width: 46%;
            height: 32px;
        }

        div .pc {
            font-size: 13px;
        }

        div .buttonprod {
            width: 100%;
            margin-left: 8px;
            font-size: 17px;
        }
    }

    @media screen and (min-width:1020px) {
        div .pe {
            font-size: 14px;
        }

        div .contorno2 {
            width: 23%;
            margin-left: 12px;
        }

        div .contenedor3 {
            display: inline-block;
            margin-left: 4px;
            width: 46%;
            height: 32px;
        }

        div .pc {
            font-size: 14px;
        }

        div .buttonprod {
            width: 100%;
            margin-left: 12px;
            font-size: 18px;
        }
    }

    @media screen and (min-width:1270px) {
        div .pe {
            font-size: 16px;
        }

        div .contorno2 {
            width: 23%;
            margin-left: 17px;
        }

        div .contenedor3 {
            display: inline-block;
            margin-left: 4px;
            width: 46%;
            height: 32px;
        }

        div .pc {
            font-size: 15px;
        }

        div .buttonprod {
            width: 100%;
            margin-left: 14px;
            font-size: 20px;
        }
    }
</style>