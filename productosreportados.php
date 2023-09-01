<?php
//echo $id_us;
if (@$_SESSION['rolusu'] == "a1") {
    $query = "SELECT*FROM reporteproducto WHERE elimin_cliente='0'
    ORDER BY id_reporte DESC";
} elseif (@$_SESSION['rolusu'] == "empresa") {
    $query = "SELECT*FROM reporteproducto WHERE elimin_empresa=0 and id_empresa='$idlog'
    ORDER BY id_reporte DESC";
}

//$query = "SELECT*FROM logueo where rolusu != '$rolusu' ORDER BY logueo.idusu DESC";
$resul_cant = mysqli_query($mysqli, $query);
$cantidreporte = mysqli_num_rows($resul_cant);
$productoreportado = mysqli_fetch_all($resul_cant, MYSQLI_ASSOC);
if ($cantidreporte > 0) { ?>
    <div style="width: 95%; margin-left: 12px; border:2px solid blue;">
        <div style="width: 100%; border:2px solid blue;">
            <img src="img/servicio.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">
            <h1 style="display: inline-block; font-size: 18px;">Productos reportados: <?php echo $cantidreporte; ?></h1>
        </div>
        <div style="width: 99%; margin-left: 4px;">
            <?php
                foreach ($productoreportado as $row) {
                    $id_report = $row['id_reporte'];
                    $id_prod = $row['idproducto'];
                    $id_usu = $row['idusu'];
                    if (@$_SESSION['rolusu'] == "a1") {
                        $queryp = "SELECT*FROM productos WHERE productos.idproducto='$id_prod'
                    ORDER BY idproducto DESC";
                    } elseif (@$_SESSION['rolusu'] == "empresa") {
                        $queryp = "SELECT*FROM productos WHERE productos.idproducto='$id_prod'  ORDER BY idproducto DESC";
                    }
                    $resul_cantp = mysqli_query($mysqli, $queryp);
                    $cantidprod = mysqli_num_rows($resul_cantp);
                    $producto = mysqli_fetch_all($resul_cantp, MYSQLI_ASSOC);
                    if ($cantidprod > 0) {
                        foreach ($producto as $rowp) {
                            $id_product = $rowp['idproducto'];
                            $ide_prod = $rowp['id_empresa'];
                            $codcate_prod = $rowp['codigocate'];
                            @$idcategprod = $rowp['idcategoria'];
                        }
                        $querycat = "SELECT*FROM categoria where codigocate='$codcate_prod' ORDER BY codigocate DESC";
                        $resultcat = mysqli_query($conexion, $querycat);
                        $catego = mysqli_fetch_all($resultcat, MYSQLI_ASSOC);
                        foreach ($catego as $row2) {
                            $id_categ = $row2['idcategoria'];
                        }
                        $consulta_u = ("SELECT * FROM logueo_empresa  
                                     INNER JOIN rol on logueo_empresa.codigorol = rol.codigorol
                                    WHERE logueo_empresa.id_empresa='$ide_prod'");
                        $query1u = mysqli_query($mysqli, $consulta_u);
                        $personau = mysqli_fetch_all($query1u, MYSQLI_ASSOC);
                        foreach ($personau as $arraye) {
                            $imgperfi = base64_encode($arraye['imagempresa']);
                            $nombre_empre = sed::decryption($arraye["nombreempresa"]);
                        }
                        $consulta_u = ("SELECT * FROM logueo  
                            INNER JOIN rol on logueo.codigorol = rol.codigorol
                           WHERE logueo.idusu='$id_usu'");
                        $query1u = mysqli_query($mysqli, $consulta_u);
                        $personau = mysqli_fetch_all($query1u, MYSQLI_ASSOC);
                        foreach ($personau as $arrayu) {
                            $imgperfi = base64_encode($arrayu['imagperfil']);
                            $apellidop = sed::decryption($arrayu["apellidousu"]);
                        }
                        ?>
                    <div style="display: inline-block; ">
                        <img src="data:image/jpg;base64,<?php echo base64_encode($rowp['imagproducto']);; ?>" style="width: 96px; height: 100px; <?php if ($_SESSION['rolusu'] == "a1") { ?> margin-top: -160px; <?php } elseif ($_SESSION['rolusu'] == "empresa") { ?>margin-top: -140px; <?php } ?>">
                    </div>
                    <div style="display: inline-block;">
                        <p style="color:blue; font-size: 14px;"><strong><?php echo sed::decryption($rowp['nombreproducto']);; ?></strong></p>
                        <p style="color:orange; font-size: 14px; margin-top:-16px;">
                            <strong>Empresa: <?php echo sed::decryption($arraye["nombreempresa"]);
                                                            ?>
                            </strong>
                        </p>
                        <?php if (@$_SESSION['rolusu'] == "a1") { ?>
                            <p style="margin-top: -16px; ">Reportado por:
                                <strong>
                                    <?php echo sed::decryption(@$arrayu['nombreusu']) . " " . sed::decryption(@$arrayu['apellidousu']); ?>
                                </strong>
                            </p>
                        <?php } ?>
                        <p style="margin-top: -16px; ">Categoria:
                            <strong>
                                <?php
                                            if (!empty(sed::decryption(@$row2['nombrecateg']))) {
                                                echo sed::decryption(@$row2['nombrecateg']);
                                            } else {
                                                echo "Categoria del producto no definido";
                                            }
                                            ?>
                            </strong>
                        </p>
                        <p style="margin-top: -16px; ">Cantidad en stock:
                            <strong>
                                <?php
                                            if (!empty(sed::decryption(@$rowp['cantistock']))) {
                                                echo @sed::decryption($rowp['cantistock']);
                                            } else {
                                                echo "Cantidad stock del producto no definido";
                                            }
                                            ?>
                            </strong>
                        </p>
                        <div style="margin-top: -15px; ">
                            <div style="display: inline-block;">
                                <p>
                                    <strong>Producto reportado el: <?php echo $row['fecha_reporte']; ?> </strong>
                                </p>
                            </div>
                            <div style="display: inline-block;">
                                <p style="margin-left: 25px; color:orangered; font-size: 22px; margin-top: -40px;">
                                    <strong> S/.<?php
                                                            if (!empty(sed::decryption(@$rowp['costoproducto']))) {
                                                                echo sed::decryption(@$rowp['costoproducto']);
                                                            } else {
                                                                echo "Precio no definido";
                                                            } ?></strong>
                                </p>
                            </div>
                        </div>
                        <a class="btn btn-primary" href="admdetalleproduc.php?id=<?php echo $row['idproducto']; ?>" style="width:110px; display: inline-block; margin-top: -10px;" role="button" value="Ver torta">
                            <strong>Ver</strong>
                        </a>
                        <form action="" method="post" style="width:110px; display: inline-block; margin-top: -10px;">
                            <input type="hidden" name="idreporte" value="<?php echo $row['id_reporte']; ?>">
                            <input type="submit" style="width:150px; margin-top: -10px;" class="btn btn-danger" name="eliminareportep" value="Eliminar">
                        </form>
                        <?php
                                    if (isset($_POST['eliminareportep'])) {
                                        $idreporte = $_POST['idreporte'];
                                        if (@$_SESSION['rolusu'] == "a1") {
                                            $sqlborrar = "UPDATE reporteproducto SET elimin_cliente= '1' 
                                            WHERE id_reporte='$idreporte'";
                                            $resborrar = mysqli_query($mysqli, $sqlborrar);
                                            if ($resborrar) {
                                                echo '<div class="alert alert-primary" role="alert">Eliminado exitosamente. </div>';
                                                echo "<script>location.href='adm.php?productoreportados=1'</script>";
                                            } else {
                                                echo "Error: " . $sqlborrar . "<br>" . mysqli_error($mysqli);
                                                //echo "<script>location.href='registro.php'</script>";
                                            }
                                        } elseif (@$_SESSION['rolusu'] == "empresa") {
                                            $sqlborrar = "UPDATE reporteproducto SET elimin_empresa= '1' 
                                            WHERE id_reporte='$idreporte'";
                                            $resborrar = mysqli_query($mysqli, $sqlborrar);
                                            if ($resborrar) {
                                                echo '<div class="alert alert-primary" role="alert">Eliminado exitosamente. </div>';
                                                echo "<script>location.href='admproductosreportados.php'</script>";
                                            } else {
                                                echo "Error: " . $sqlborrar . "<br>" . mysqli_error($mysqli);
                                                //echo "<script>location.href='registro.php'</script>";
                                            }
                                        }
                                    }
                                    ?>
                    </div>
                    <div style="width: 90%; margin-left: 16px; background: blue; height: 3px; margin-top: 4px;"></div>
                <?php } else { ?>
                    <div style="display: inline-block; ">
                        <img src="img/favorito.png" style="width: 30px; height: 20px;" alt="registration_killaripostres" class="img-fluid">
                    </div>
                    <div style="display: inline-block;">
                        <h3 style="" class="text-center text-uppercase poppins-regular font-weight-bold">
                            <strong>Producto no existe.</strong></h3>
                        <form action="" method="post" style="width:110px; display: inline-block; margin-top: -10px;">
                            <input type="hidden" name="idreporte" value="<?php echo $row['id_reporte']; ?>">
                            <input type="submit" style="width:150px; margin-top: -10px;" class="btn btn-danger" name="eliminareporte" value="Eliminar">
                        </form>
                        <?php
                                    if (isset($_POST['eliminareporte'])) {
                                        $idreporte = $_POST['idreporte'];
                                        if (@$_SESSION['rolusu'] == "a1") {
                                            $sqlborrar = "UPDATE reporteproducto SET elimin_cliente= '1' 
                                            WHERE id_reporte='$idreporte'";
                                            $resborrar = mysqli_query($mysqli, $sqlborrar);
                                            if ($resborrar) {
                                                echo '<div class="alert alert-primary" role="alert">Eliminado exitosamente. </div>';
                                                echo "<script>location.href='adm.php?productoreportados=1'</script>";
                                            } else {
                                                echo "Error: " . $sqlborrar . "<br>" . mysqli_error($mysqli);
                                                //echo "<script>location.href='registro.php'</script>";
                                            }
                                        } elseif (@$_SESSION['rolusu'] == "empresa") {
                                            $sqlborrar = "UPDATE reporteproducto SET elimin_empresa= '1' 
                                            WHERE id_reporte='$idreporte'";
                                            $resborrar = mysqli_query($mysqli, $sqlborrar);
                                            if ($resborrar) {
                                                echo '<div class="alert alert-primary" role="alert">Eliminado exitosamente. </div>';
                                                echo "<script>location.href='admproductosreportados.php'</script>";
                                            } else {
                                                echo "Error: " . $sqlborrar . "<br>" . mysqli_error($mysqli);
                                                //echo "<script>location.href='registro.php'</script>";
                                            }
                                        }
                                    }
                                    ?>
                    </div>
                    <div style="width: 90%; margin-left: 16px; background: blue; height: 3px; margin-top: 4px;"></div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
<?php } else { ?>
    <div class="container container-web-page ">
        <div class="row justify-content-md-center border-primary" style="background-color: orange;border-radius: 35px; width: 100%; margin-left: 0;">
            <div class="col-12 col-md-6">
                <figure class="full-box">
                    <center>
                        <img src="img/reportar.png" alt="registration_killaripostres" class="img-fluid">
                    </center>
                </figure>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-md-6">
                <h3 style="color:white;" class="text-center text-uppercase poppins-regular font-weight-bold">
                    <strong>PRODUCTOS REPORTADOS</strong></h3>

                <p class="text-justify">
                    <center>
                        <strong style="color:white;">
                            Aquí se mostrarán los productos que los usuarios reportan.</strong>

                    </center>
                </p>
            </div>
        </div>
    </div>
<?php } ?>