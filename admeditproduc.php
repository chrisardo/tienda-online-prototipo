<?php
//validar
session_start();
if (@!$_SESSION['idusu']) {
    echo "<script>location.href='logueo.php'</script>";
} elseif ($_SESSION['rolusu'] == "a1" || $_SESSION['rolusu'] == "empresa") {
    /*if ((time() - $_SESSION['last_login_timestamp']) > 240) { // 900 = 15 * 60  
        setcookie("cerrarsesion", 1, time() + 60000); //6o segundos es 1 minuto, 86400 segundos es por 24 horas
        echo "<script>location.href='desconectar.php'</script>";
    } else {
        $_SESSION['last_login_timestamp'] = time();
    }*/ } else {
    echo "<script>location.href='logueo.php'</script>";
}
?>
<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar producto | RestaurantApp</title>
    <link rel="icon" href='img/ilogo.png' sizes="32x32" type="img/jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css2/style.css" />
</head>

<body>
    <?php
    include 'sed.php';
    require("connectdb.php");
    require("conexion.php");
    $idlog = $_SESSION['idusu'];
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
        <div class="container-fluid">
            <a class="" href="adm.php?verproducto=1">
                <img src="img/atras.png" style="width: 30px; height: 40px;">
            </a>
            <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 15px;" href="#">
                <img src="img/ilogo.png" style="width: 30px; height: 30px;" alt="logo restaurantapp">
                <strong>Perikos's</strong>
            </a>
        </div>
    </nav><br><br><br>
    <center>
        <h2>Editar producto</h2>
    </center>
    <?php
    extract($_GET);
    $sqlq = "SELECT*FROM productos where idproducto='$id'";
    $resultado = mysqli_query($conexion, $sqlq);
    $producto = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    foreach ($producto as $row) {
        $idproducto = $row['idproducto'];
        $precio_producto = sed::decryption($row['costoproducto']);
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
        foreach ($empres as $arraye) { }
    }
    ?>
    <div class="container container--flex" style="background-color:orange; width: 95%; margin-left: 46px;">
        <form action="" enctype="multipart/form-data" method="post" class="formulario column column--50 bg-orange">
            <div class="row g-3">
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Imagen producto: </label>
                    <img style="width: 150px; heigth: 185px;" src="data:image/jpg;base64, <?php echo base64_encode($row['imagproducto']); ?>" name="imagen" />
                </div>
            </div>
            <div class="row g-3">
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Elegir nueva imagen del producto: </label>
                    <input type="file" class="form-control" name="imagen">
                </div>
            </div>
            <div class="row g-3">
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Código del producto: </label>
                    <input type="text" class="form-control" name="codigoprod" value="<?php echo sed::decryption($row['codigoproducto']); ?>" required="required" />
                </div>
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Nombre del producto: </label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo sed::decryption($row['nombreproducto']); ?>" required="required" />
                </div>
            </div>
            <div class="row g-2">
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Categoria del producto: </label>
                    <select id="soporte" class="form-control" name="nomcateg" required="required">
                        <option selected="<?php if (!empty(sed::decryption(@$row['codigocate']))) {
                                                echo sed::decryption(@$row['codigocate']);
                                            } else {
                                                echo "Se eliminó la categoria";
                                            } ?>" value="<?php if (!empty(sed::decryption(@$row['codigocate']))) {
                                                                echo sed::decryption(@$row['codigocate']);
                                                            } else {
                                                                echo "Se eliminó la categoria";
                                                            } ?>" required="required"><?php
                                                                                        if (!empty(sed::decryption(@$row2['nombrecateg']))) {
                                                                                            echo sed::decryption(@$row2['nombrecateg']);
                                                                                        } else {
                                                                                            echo "Se eliminó la categoria";
                                                                                        } ?></option>
                        <?php
                        $sqlcateg = "SELECT*FROM categoria
                           inner join logueo_empresa on categoria.id_empresa=logueo_empresa.id_empresa
                           INNER JOIN rol on logueo_empresa.codigorol = rol.codigorol 
                            WHERE logueo_empresa.id_empresa='$idlog' ORDER BY idcategoria DESC";
                        $resultadocateg = mysqli_query($conexion, $sqlcateg);
                        $categorias = mysqli_fetch_all($resultadocateg, MYSQLI_ASSOC);
                        foreach ($categorias as $rowcat) {
                            $idcat = sed::decryption($rowcat['idcategoria']);
                            $nombrecatego = sed::decryption($rowcat['nombrecateg']);
                            echo '<option value="' . sed::decryption($rowcat['codigocate']) . '">' . $nombrecatego . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row g-2">
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Costo del producto: </label>
                    <input type="text" class="form-control" name="costoproducto" value="<?php echo sed::decryption(@$row['costoproducto']); ?>" />
                </div>
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Cantidad stock: </label>
                    <input type="text" class="form-control" name="cantistock" value="<?php echo @$row['cantistock']; ?>" />
                </div>
            </div>
            <div class="row g-2">
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Detalles del producto: </label>
                    <textarea type="text" class="form-control" maxlength="331" id="detalletorta" name="detalletorta"><?php echo sed::decryption(@$row['detalleproducto']); ?></textarea>
                </div>
            </div>
            <center>
                <input type="submit" style="width:150px; margin-top: 5px;" class="btn btn-primary" name="editarproduc" value="EDITAR">
            </center>
        </form>
        <?php
        if (isset($_POST['editarproduc'])) {
            $Imagen2 = addslashes(@file_get_contents($_FILES['imagen']['tmp_name']));
            $Imagen = $_FILES['imagen']['tmp_name'];
            //$idproduc = $_POST['idprod'];
            $cod_produc = $_POST['codigoprod'];
            $nombre = $_POST['nombre'];
            $tamano_imagen = $_FILES['imagen']['size'];
            $tipoimagen = $_FILES['imagen']['type'];
            $costoproduc = $_POST['costoproducto'];
            $detalletort = $_POST['detalletorta'];
            $cantistock = $_POST['cantistock'];
            $codicateg = $_POST['nomcateg'];
            $codproe = sed::encryption($cod_produc);
            $nombree = sed::encryption($nombre);
            $costoproduce = sed::encryption($costoproduc);
            $detalletortae = sed::encryption($detalletort);
            $code = sed::encryption($codicateg);
            $cantistocke = sed::encryption($cantistock);
            $sql2produc = "SELECT * FROM productos 
            inner join logueo_empresa on productos.id_empresa=logueo_empresa.id_empresa
                        INNER JOIN rol on logueo_empresa.codigorol = rol.codigorol 
            where productos.codigoproducto='$codproe' or productos.nombreproducto='$nombree' and logueo_empresa.id_empresa='$idlog'";
            $resultado2produc = mysqli_query($conexion, $sql2produc);
            $produc2 = mysqli_fetch_all($resultado2produc, MYSQLI_ASSOC);
            $cantidproduc = mysqli_num_rows($resultado2produc);
            if (!empty($nombre) && !empty($codproe)  && !empty($costoproduc) && $cantistock > 0) {
                if (!empty($Imagen2)) {
                    if ($tamano_imagen <= 3000000) {
                        if ($tipoimagen == "image/jpeg" || $tipoimagen == "image/jpg" || $tipoimagen == "image/png" || $tipoimagen == "image/gif") {
                            if ($cantidproduc > 0) { // si existe el codigo del usuario
                                $query2 = "UPDATE productos SET imagproducto='$Imagen2', nombreproducto= '$nombree',costoproducto= '$costoproduce', detalleproducto='$detalletortae', 
                                cantistock='$cantistock', codigocate='$code'  
                                 WHERE idproducto='$id'";
                            } else {
                                $query2 = "UPDATE productos SET codigoproducto='$codproe', imagproducto='$Imagen2', nombreproducto= '$nombree', 
                            costoproducto= '$costoproduce', detalleproducto='$detalletortae', cantistock='$cantistock', codigocate='$code'  
                            WHERE idproducto='$id'";
                            }

                            $resultado2 = $conexion->query($query2);
                            if ($resultado2) {
                                echo '<div class="alert alert-primary" role="alert">Actualizado con exito! El código de cada producto es único, no se pueden repetir.. </div>';
                                echo "<script>location.href='admeditproduc.php?id=$id'</script>";
                            } else {
                                echo '<div class="alert alert-danger" role="alert">Hubo problemas al actualizar. </div>';
                                //echo "<script>location.href='veregistorta.php'</script>";
                            }
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Tipo de la imagen debe ser jpeg, jpg, png  o gif. </div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger" role="alert">El tamaño de la imagen debe ser menor de 2 millones de bytes. </div>';
                    }
                } else { //si la imagen está vacio, no se modifca la imagen
                    if ($cantidproduc > 0) { //si el codigo del producto del la empresa existe
                        $query2 = "UPDATE productos SET nombreproducto= '$nombree', costoproducto= '$costoproduce', detalleproducto='$detalletortae', cantistock='$cantistock'
                        , codigocate='$code' 
                        WHERE idproducto='$id'";
                    } else {
                        $query2 = "UPDATE productos SET codigoproducto='$codproe', nombreproducto= '$nombree', 
                    costoproducto= '$costoproduce', detalleproducto='$detalletortae', cantistock='$cantistock', codigocate='$code' 
                    WHERE idproducto='$id'";
                    }

                    $resultado2 = $conexion->query($query2);
                    if ($resultado2) {
                        echo '<div class="alert alert-primary" role="alert">Actualizado con exito! El código de cada producto es único, no se pueden repetir.. </div>';
                        echo "<script>location.href='admeditproduc.php?id=$id'</script>";
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Hubo problemas al actualizar. </div>';
                    }
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Completa todos datos del registro. </div>';
            }
        }
        ?>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>