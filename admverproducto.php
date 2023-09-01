<?php if (@$_SESSION['rolusu'] == "a1" || @$_SESSION['rolusu'] == "empresa") { ?>
    <form style="margin-left: 18px; display: inline-block;" class="form-inline my-2 my-lg-0 align-self-stretch" name="buscador" action="adm.php?verproducto=1" method="POST">
        <input class="form-control mr-sm-2" style="width: 200px;" type="text" name="word" placeholder="Buscar productos" aria-label="Search" />
        <button class="btn btn-success my-2 my-sm-0" style="width: 67px;" name="buscarprod" alue="Buscar" type="submit">
            Buscar
        </button>
    </form>
    <a href="listareporteproducto.php" class="btn btn-primary" style="display: inline-block; color:white; margin-left:4px;">
        <img src="img/pdf.png" style="width: 30px; height: 30px;"> ver como PDF
    </a>
<?php } ?>
<?php
require 'class/bookproducto.php';
$word = sed::encryption(@$_POST['word']);
$objBook = new Bookproducto();
$words = explode(' ', $word);
$num = count($words);
$result = $objBook->buscar($word, $num);
include_once('class/database.php');
//echo $id_us;
if (@$_SESSION['rolusu'] == "a1" || @$_SESSION['rolusu'] == "user") {
    $query = "SELECT*FROM productos 
    ORDER BY idproducto DESC";
} elseif (@$_SESSION['rolusu'] == "empresa") {
    $query = "SELECT*FROM productos 
    WHERE productos.id_empresa='$idlog' ORDER BY idproducto DESC";
}

//$query = "SELECT*FROM logueo where rolusu != '$rolusu' ORDER BY logueo.idusu DESC";
$resul_cant = mysqli_query($mysqli, $query);
$cantidprod = mysqli_num_rows($resul_cant);
$productos = mysqli_fetch_all($resul_cant, MYSQLI_ASSOC);
if ($cantidprod > 0) {
    ?>
    <?php if (isset($_POST['buscarprod'])) {
            //echo "se dio click"; 
            ?>
        <?php
                if (@$result) {
                    if ($_SESSION['rolusu'] == "a1" || $_SESSION['rolusu'] == "user") {
                        $Busca = 'SELECT * FROM productos 
                        INNER JOIN logueo_empresa on productos.id_empresa=logueo_empresa.id_empresa
                        INNER JOIN rol on logueo_empresa.codigorol = rol.codigorol
                        INNER JOIN categoria on categoria.codigocate=productos.codigocate 
                                WHERE nombreproducto LIKE "% ' . $word . '%" '
                            . 'OR nombreproducto LIKE "%' . $word . '%"'
                            . 'OR detalleproducto LIKE "%' . $word . '%"'
                            . 'OR nombrecateg LIKE "%' . $word . '%"';
                    } elseif ($_SESSION['rolusu'] == "empresa") {
                        $Busca = 'SELECT * FROM productos 
                        INNER JOIN logueo_empresa on productos.id_empresa=logueo_empresa.id_empresa
                        INNER JOIN rol on logueo_empresa.codigorol = rol.codigorol
                        INNER JOIN categoria on categoria.codigocate=productos.codigocate 
                       WHERE logueo_empresa.id_empresa="' . $idlog . '" AND productos.id_empresa="' . $idlog . '" AND nombreproducto LIKE "% ' . $word . '%" '
                            . 'OR nombreproducto LIKE "%' . $word . '%"'
                            . 'OR detalleproducto LIKE "%' . $word . '%"'
                            . 'OR nombrecateg LIKE "%' . $word . '%"';
                    }
                    $que = mysqli_query($conexion, $Busca);
                    $conta = mysqli_num_rows($que);
                    ?>
            <div style="width: 95%; margin-left: 15px; border:2px solid blue;">
                <div style="width: 100%; border:2px solid blue;">
                    <img src="img/buscar.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">
                    <h1 style="display: inline-block;">Encontradas: <?php echo $conta; ?></h1>
                </div>
                <?php
                            foreach ($result as $key => $row) { 
                                $idu_prod = $row['id_empresa'];
                                $querycat = "SELECT*FROM categoria where codigocate='$codigocate' ORDER BY idcategoria DESC";
                                $resultcat = mysqli_query($conexion, $querycat);
                                $catego = mysqli_fetch_all($resultcat, MYSQLI_ASSOC);
                                foreach ($catego as $row2) {
                                    $id_categ = $row2['idcategoria'];
                                }
                                $consulta_u = ("SELECT * FROM logueo_empresa  WHERE logueo_empresa.id_empresa='$ide_prod'");
                                $query1u = mysqli_query($mysqli, $consulta_u);
                                $empres = mysqli_fetch_all($query1u, MYSQLI_ASSOC);
                                foreach ($empres as $arraye) {
                                }
                                ?>
                    <div style="width: 95%; margin-left: 3px;">
                        <div style="display: inline-block; ">
                            <img src="data:image/jpg;base64, <?php echo base64_encode($row['imagproducto']); ?>" style="width: 90px; height: 135px; <?php if ($_SESSION['rolusu'] == "a1") { ?> margin-top: -130px; <?php } elseif ($_SESSION['rolusu'] == "empresa") { ?>margin-top: -140px; <?php } ?>">
                        </div>
                        <div style="display: inline-block;">
                            <p style="color:blue; font-size: 13px;"><strong><?php echo sed::decryption($row['nombreproducto']); ?></strong></p>
                            <p style="color:orange; font-size: 14px; margin-top:-16px;">
                                <strong>Empresa: <?php echo sed::decryption($arraye["nombreempresa"]);
                                                                    ?>
                                </strong>
                            </p>
                            <p style="margin-top: -16px; ">Categoria: <strong>
                                    <?php
                                                    if (!empty(sed::decryption(@$row2['nombrecateg']))) {
                                                        echo sed::decryption(@$row2['nombrecateg']);
                                                    } else {
                                                        echo "Categoria del producto no definido";
                                                    }
                                                    ?></strong>
                            </p>
                            <?php if (@$_SESSION['rolusu'] == "empresa" || @$_SESSION['rolusu'] == "a1") { ?>
                                <p style="margin-top: -16px; ">Cantidad en stock: <strong>
                                        <?php
                                                            if (@$row['cantistock']) {
                                                                echo @$row['cantistock'];
                                                            } else {
                                                                echo "Cantidad stock del producto no definido";
                                                            }
                                                            ?></strong>
                                </p>
                            <?php } ?>

                            <div style="margin-top: -15px; ">
                                <?php if (@$_SESSION['rolusu'] == "empresa" || @$_SESSION['rolusu'] == "a1") { ?>
                                    <div style="display: inline-block;">
                                        <p>
                                            <strong>Fecha registro: <?php echo $row['fecharegistro_produc']; ?> </strong>
                                        </p>
                                    </div>
                                <?php } ?>

                                <div style="display: inline-block;">
                                    <p style="margin-left: 25px; color:orangered; font-size: 22px; margin-top: -40px;">
                                        <strong> S/.<?php
                                                                    if (!empty(sed::decryption(@$row['costoproducto']))) {
                                                                        echo sed::decryption(@$row['costoproducto']);
                                                                    } else {
                                                                        echo "Precio no definido";
                                                                    } ?></strong>
                                    </p>
                                </div>
                            </div>
                            <!--<a class="btn btn-primary" href="verproducto.php?idproducto=<?php //echo $row['idproducto']; 
                                                                                                            ?>" style="width:150px; display: inline-block;" role="button" value="Ver torta">
                            <strong>Ver</strong>
                        </a>-->
                            <a class="btn btn-primary" href="admdetalleproduc.php?id=<?php echo $row['idproducto']; ?>&ft=1" style="width:110px; display: inline-block; margin-top: -30px;" role="button" value="Ver torta">
                                <strong> Ver</strong>
                            </a>
                            <form action="" method="post" style="width:110px; display: inline-block; margin-top: -30px;">
                                <input type="hidden" name="idproducto" value="<?php echo $row['idproducto']; ?>">
                                <input type="submit" style="width:150px; margin-top: -30px;" class="btn btn-danger" name="eliminarproduc" value="Eliminar">
                            </form>
                            <?php
                                            if (isset($_POST['eliminarproduc'])) {
                                                $idtorta = $_POST['idproducto'];
                                                $sqlborrar = "DELETE FROM productos WHERE idproducto=$idtorta";
                                                $resborrar = mysqli_query($mysqli, $sqlborrar);
                                                if ($resborrar) {
                                                    echo '<div class="alert alert-primary" role="alert">Eliminado exitosamente. </div>';
                                                    echo "<script>location.href='adm.php?verproducto=1'</script>";
                                                } else {
                                                    echo "Error: " . $sqlborrar . "<br>" . mysqli_error($mysqli);
                                                    //echo "<script>location.href='registro.php'</script>";
                                                }
                                            }
                                            ?>
                        </div>
                    </div>
                    <div style="width: 90%; margin-left: 6px; background: blue; height: 3px; margin-top: 3px;"></div>
                <?php } ?>
            </div><br>
        <?php } elseif (@!$result) { //echo "no se encontró el resultado";
                    ?>
            <div class="container container-web-page ">
                <div class="row justify-content-md-center border-primary" style="background-color: orange;border-radius: 35px; width: 100%; margin-left: 0;">
                    <div class="col-12 col-md-6">
                        <figure class="full-box">
                            <center>
                                <img src="img/buscar.png" alt="registration_killaripostres" class="img-fluid">
                            </center>
                        </figure>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 col-md-6">
                        <h3 style="color:white;" class="text-center text-uppercase poppins-regular font-weight-bold">
                            <strong>No se encontró. </strong></h3>

                        <p class="text-justify">
                            <center>
                                <strong style="color:white;">
                                    intente buscar nuevamente correctamente.
                                </strong>

                            </center>
                        </p>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } else {
            //echo "no se dio click"; 
            ?>
        <?php if (@$_SESSION['rolusu'] == "empresa" || @$_SESSION['rolusu'] == "a1") { ?>
            <div style="width: 95%; margin-left: 12px; border:2px solid blue;">
                <div style="width: 100%; border:2px solid blue;">
                    <img src="img/servicio.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">
                    <h1 style="display: inline-block; font-size: 18px;">Productos registradas: <?php echo $cantidprod; ?></h1>
                </div>

                <?php
                            foreach ($productos as $row) {
                                $id_torta = $row['idproducto'];
                                $ide_prod = $row['id_empresa'];
                                $codigocate = $row['codigocate'];
                                @$idcategprod = $row['idcategoria'];
                                $querycat = "SELECT*FROM categoria where codigocate='$codigocate' ORDER BY idcategoria DESC";
                                $resultcat = mysqli_query($conexion, $querycat);
                                $catego = mysqli_fetch_all($resultcat, MYSQLI_ASSOC);
                                foreach ($catego as $row2) {
                                    $id_categ = $row2['idcategoria'];
                                }
                                $consulta_u = ("SELECT * FROM logueo_empresa  WHERE logueo_empresa.id_empresa='$ide_prod'");
                                $query1u = mysqli_query($mysqli, $consulta_u);
                                $empres = mysqli_fetch_all($query1u, MYSQLI_ASSOC);
                                foreach ($empres as $arraye) {
                                }
                                ?>
                    <div style="width: 99%; margin-left: 4px;">
                        <div style="display: inline-block; ">
                            <img src="data:image/jpg;base64,<?php echo base64_encode($row['imagproducto']);; ?>" style="width: 96px; height: 135px; <?php if ($_SESSION['rolusu'] == "a1") { ?> margin-top: -130px; <?php } elseif ($_SESSION['rolusu'] == "empresa") { ?>margin-top: -140px; <?php } ?>">
                        </div>
                        <div style="display: inline-block;">
                            <p style="color:blue; font-size: 14px;"><strong><?php echo sed::decryption($row['nombreproducto']);; ?></strong></p>
                            <p style="color:orange; font-size: 14px; margin-top:-16px;">
                                <strong>Empresa: <?php echo sed::decryption($arraye["nombreempresa"]);
                                                                    ?>
                                </strong>
                            </p>
                            <p style="margin-top: -16px; ">Categoria: <strong>
                                    <?php
                                                    if (!empty(sed::decryption(@$row2['nombrecateg']))) {
                                                        echo sed::decryption(@$row2['nombrecateg']);
                                                    } else {
                                                        echo "Categoria del producto no definido";
                                                    }
                                                    ?></strong>
                            </p>
                            <?php if ($_SESSION['rolusu'] == "empresa" || $_SESSION['rolusu'] == "a1") { ?>
                                <p style="margin-top: -16px; ">Cantidad en stock: <strong>
                                        <?php
                                                            if (!empty(@$row['cantistock'])) {
                                                                echo $row['cantistock'];
                                                            } else {
                                                                echo "Cantidad stock del producto no definido";
                                                            }
                                                            ?></strong>
                                </p>
                            <?php } ?>
                            <div style="margin-top: -15px; ">
                                <?php if (@$_SESSION['rolusu'] == "empresa" || @$_SESSION['rolusu'] == "a1") { ?>
                                    <div style="display: inline-block;">
                                        <p>
                                            <strong>Producto registrado: <?php echo $row['fecharegistro_produc']; ?> </strong>
                                        </p>
                                    </div>
                                <?php } ?>
                                <div style="display: inline-block;">
                                    <p style="margin-left: 25px; color:orangered; font-size: 22px; margin-top: -40px;">
                                        <strong> S/.<?php
                                                                    if (!empty(sed::decryption(@$row['costoproducto']))) {
                                                                        echo sed::decryption(@$row['costoproducto']);
                                                                    } else {
                                                                        echo "Precio no definido";
                                                                    } ?></strong>
                                    </p>
                                </div>
                            </div>
                            <a class="btn btn-primary" href="admdetalleproduc.php?id=<?php echo $row['idproducto']; ?>" style="width:110px; display: inline-block; margin-top: -10px;" role="button" value="Ver torta">
                                <strong>Ver</strong>
                            </a>
                            <a class="btn btn-warning" href="admeditproduc.php?id=<?php echo $row['idproducto']; ?>&ft=1" style="width:110px; display: inline-block; margin-top: -10px; color:white;" role="button" value="Ver torta">
                                <strong>Ediar</strong>
                            </a>
                            <form action="" method="post" style="width:110px; display: inline-block; margin-top: -10px;">
                                <input type="hidden" name="idproducto" value="<?php echo $id_torta; ?>">
                                <input type="submit" style="width:150px; margin-top: -10px;" class="btn btn-danger" name="eliminarproduc" value="Eliminar">
                            </form>
                            <?php
                                            if (isset($_POST['eliminarproduc'])) {
                                                $idtorta = $_POST['idproducto'];
                                                $sqlborrar = "DELETE FROM productos WHERE idproducto=$idtorta";
                                                $resborrar = mysqli_query($mysqli, $sqlborrar);
                                                if ($resborrar) {
                                                    echo '<div class="alert alert-primary" role="alert">Eliminado exitosamente. </div>';
                                                    echo "<script>location.href='adm.php?verproducto=1'</script>";
                                                } else {
                                                    echo "Error: " . $sqlborrar . "<br>" . mysqli_error($mysqli);
                                                    //echo "<script>location.href='registro.php'</script>";
                                                }
                                            }
                                            ?>
                            <!--<a class="btn btn-danger" href="admregistorta.php?id_torta=<?php //echo $id_torta; 
                                                                                                            ?>&eliminar=1" style="width:110px; display: inline-block;" role="button" value="Ver torta">
                                <strong> Eliminar</strong>
                            </a>-->
                        </div>
                    </div>
                    <div style="width: 90%; margin-left: 16px; background: blue; height: 3px; margin-top: 4px;"></div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="container container-web-page ">
                <div class="row justify-content-md-center border-primary" style="background-color: orange;border-radius: 35px; width: 100%; margin-left: 0;">
                    <div class="col-12 col-md-6">
                        <figure class="full-box">
                            <center>
                                <img src="img/buscador.png" style="height: 340px;" alt="KillariPostres" class="img-fluid">
                            </center>
                        </figure>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 col-md-6">
                        <!--<h3 style="color:white;" class="text-center text-uppercase poppins-regular font-weight-bold">
            <strong> Aquí se mostrarán las tortas que busques</strong></h3>-->

                        <p class="text-justify">
                            <center>
                                <strong style="color:white; font-size: 18px;">
                                    Aquí se mostrarán los productos que busques.</strong>

                            </center>
                        </p>
                    </div>
                </div>
            </div><br>
        <?php } ?>
    <?php } ?>
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
                    <strong>Lista de los productos</strong></h3>

                <p class="text-justify">
                    <center>
                        <strong style="color:white;">
                            Aquí se mostrarán los productos que registres en el formulario.</strong>

                    </center>
                </p>
            </div>
        </div>
    </div>
<?php
}
?>