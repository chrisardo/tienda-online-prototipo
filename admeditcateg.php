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
    <title>Editar categoria | RestaurantApp</title>
    <link rel="icon" href='img/logo.png' sizes="32x32" type="img/jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css2/style.css" />
</head>

<body>
    <?php
    include 'sed.php';
    require("connectdb.php");
    require("conexion.php");
    $idlog = @$_SESSION['idusu'];
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
        <div class="container-fluid">
            <a class="" href="adm.php?vercategoria=1">
                <img src="img/atras.png" style="width: 30px; height: 40px;">
            </a>
            <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 15px;" href="#">
                <img src="img/logo.png" style="width: 30px; height: 30px;" alt="logo restaurantapp">
                <strong>Perikos's</strong>
            </a>
        </div>
    </nav><br><br><br>
    <center>
        <h2>Editar </h2>
    </center>
    <?php
    extract($_GET);
    $sql = "SELECT * FROM categoria WHERE idcategoria=$id";
    //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
    $ressql = mysqli_query($mysqli, $sql);
    $categori = mysqli_fetch_all($ressql, MYSQLI_ASSOC);
    foreach ($categori as $row) {
        $id = $row['idcategoria'];
        $id_empresa = $row['id_empresa'];
        $imag_categ = base64_encode($row['imagen']);
        $nombre_categ = sed::decryption($row['nombrecateg']);
        $descripcion_categ = sed::decryption($row['descripcioncateg']);
    }

    ?>
    <div class="container container--flex" style="background-color:orange; width: 95%; margin-left: 10px;">
        <form action="" enctype="multipart/form-data" method="post" class="formulario column column--50 bg-orange">
            <div class="row g-3">
                <!--<input type="hidden" class="form-control" name="id" readonly="readonly" value="<?php //echo $id; 
                                                                                                    ?>" required="required" />-->
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Imagen de la cateogria: </label>
                    <?php if ($imag_categ) { ?>
                        <img style="width: 150px; heigth: 185px;" src="data:image/jpg;base64, <?php echo $imag_categ; ?>" name="imagen" />
                    <?php } ?>
                </div>
            </div>
            <div class="row g-3">
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Elegir nueva imagen de la categoria: </label>
                    <input type="file" class="form-control" name="imagen">
                </div>
            </div>
            <div class="row g-2">
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Código categoria: </label>
                    <input type="text" class="form-control" maxlength="38" name="codigocate" value="<?php echo sed::decryption($row['codigocate']); ?>" required="required" />
                </div>
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Nombre de la categoria: </label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo $nombre_categ; ?>" required="required" />
                </div>
            </div>
            <div class="row g-2">
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Descripcion de la categoria: </label>
                    <input type="text" class="form-control" id="desripcioncateg" name="descripcioncateg" value="<?php echo $descripcion_categ; ?>" required="required">
                </div>
            </div>
            <center>
                <input type="submit" style="width:150px; margin-top: 5px;" class="btn btn-primary" name="editcateg" value="Editar categoria">
            </center>
        </form>
        <?php
        if (isset($_POST['editcateg'])) {
            //$id=$_REQUEST['id'];
            //$id = $_POST['id'];
            $Imagen2 = addslashes(@file_get_contents($_FILES['imagen']['tmp_name']));
            //$Imagen=$_FILES['imagen']['tmp_name'];
            //$Imagen2=$Imagen;
            $codigo = $_POST['codigocate'];
            $nombre = $_POST['nombre'];
            $descripcion_categ = $_POST['descripcioncateg'];
            $tamano_imagen = $_FILES['imagen']['size'];
            $tipoimagen = $_FILES['imagen']['type'];
            $codigoe = sed::encryption($codigo);
            $nombree = sed::encryption($nombre);
            $descripcione = sed::encryption($descripcion_categ);
            $sql2categ = "SELECT * FROM categoria where nombrecateg='$nombree' or codigocate='$codigoe'";
            $resultado2categ = mysqli_query($conexion, $sql2categ);
            $cantid_catego = mysqli_num_rows($resultado2categ);
            $categorias2 = mysqli_fetch_all($resultado2categ, MYSQLI_ASSOC);
            if (!empty($Imagen2)) {
                if ($tamano_imagen <= 3000000) {
                    if ($tipoimagen == "image/jpeg" || $tipoimagen == "image/jpg" || $tipoimagen == "image/png" || $tipoimagen == "image/gif") {
                        if ($cantid_catego > 0) {
                            $query2 = "UPDATE categoria SET imagen='$Imagen2', descripcioncateg= '$descripcione'  
                            WHERE idcategoria='$id'";
                            $resultado2 = $conexion->query($query2);
                            if ($resultado2) {
                                echo '<div class="alert alert-primary" role="alert">Actualizado con exito!El nombre de la categoria son únicos. </div>';
                                echo "<script>location.href='admeditcateg.php?id=$id'</script>";
                            } else {
                                echo '<div class="alert alert-danger" role="alert">Hubo problemas al actualizar. </div>';
                            }
                        } else {
                            $query2 = "UPDATE categoria SET codigocate='$codigoe', imagen='$Imagen2', nombrecateg= '$nombree', descripcioncateg= '$descripcione'  
                        WHERE idcategoria='$id'";
                            $resultado2 = $conexion->query($query2);
                            if ($resultado2) {
                                echo '<div class="alert alert-primary" role="alert">Actualizado con exito!. </div>';
                                echo "<script>location.href='admeditcateg.php?id=$id'</script>";
                            } else {
                                echo '<div class="alert alert-danger" role="alert">Hubo problemas al actualizar. </div>';
                            }
                        }
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Tipo de la imagen debe ser jpeg, jpg, png  o gif.. </div>';
                    }
                } else {
                    echo '<div class="alert alert-danger" role="alert">El tamaño de la imagen debe ser menor de 2 millones de bytes. </div>';
                }
            } else {
                if ($cantid_catego > 0) {
                    $query2 = "UPDATE categoria SET nombrecateg= '$nombree', descripcioncateg= '$descripcione'  
                    WHERE idcategoria='$id'";
                    $resultado2 = $conexion->query($query2);
                    if ($resultado2) {
                        echo '<div class="alert alert-primary" role="alert">Actualizado con exito!El nombre de la categoria son únicos. </div>';
                        echo "<script>location.href='admeditcateg.php?id=$id'</script>";
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Hubo problemas al actualizar. </div>';
                    }
                } else {
                    $query2 = "UPDATE categoria SET codigocate='$codigoe', nombrecateg= '$nombree', descripcioncateg= '$descripcione'
                WHERE idcategoria='$id'";
                    $resultado2 = $conexion->query($query2);
                    if ($resultado2) {
                        echo '<div class="alert alert-primary" role="alert">Actualizado con exito!. </div>';
                        echo "<script>location.href='admeditcateg.php?id=$id'</script>";
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Hubo problemas al actualizar. </div>';
                    }
                }
            }
        }
        ?>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>