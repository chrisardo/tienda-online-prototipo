<?php
session_start();
if ($_SESSION['rolusu'] == "user") { //sino si la session rol no esta 
    /* if ((time() - $_SESSION['last_login_timestamp']) > 240) { // 900 = 15 * 60  
        setcookie("cerrarsesion", 1, time() + 60000); //6o segundos es 1 minuto, 86400 segundos es por 24 horas
        echo "<script>location.href='desconectar.php'</script>";
    } else {
        $_SESSION['last_login_timestamp'] = time();
    }*/ }
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mis favoritos|KillariPostres</title>
    <link rel="icon" href='img/logo.png' sizes="32x32" type="img/jpg">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css2/style.css" />
</head>

<body>
    <?php
    //include_once('class/database.php');
    require("connectdb.php");
    include("conexion.php");
    include 'sed.php';
    extract($_GET);
    $idlog = @$_SESSION['idusu'];
    $sql = ("SELECT * FROM logueo WHERE idusu='$idlog'");
    //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
    $resultado = mysqli_query($mysqli, $sql);
    $persona = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    foreach ($persona as $row) {
        $id = $row['idusu'];
        $nombre = SED::decryption($row['nombreusu']);
        $apellido = SED::decryption($row['apellidousu']);
        $usename = SED::decryption($row['usernameusu']);
        $celular = $row['celularusu'];
        $f_nacimiento = $row['fechanaci'];
        $gener = SED::decryption($row['generousu']);
        $codciud = $row['codciudad'];
    }
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
        <div class="container-fluid">
            <a class="" href="index.php">
                <img src="img/atras.png" style="width: 30px; height: 40px;">
            </a>
            <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 15px;" href="#">

                <img src="img/logo.png" style="width: 30px; height: 30px;" alt="logo killaripostres">
                <strong>Periko's</strong>
            </a>
        </div>
    </nav><br><br><br>
    <?php
    if (@!$_SESSION['idusu']) { //si la session del usuario esta vacia
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
                                Aquí se mostrarán las tortas favoritas que guardes.</strong>
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
        $query = "SELECT*FROM favoritos WHERE idusu=$idlog";
        $resul_cant = mysqli_query($conexion, $query);
        $cantidad = mysqli_num_rows($resul_cant);
        $favoritos = mysqli_fetch_all($resul_cant, MYSQLI_ASSOC);
        ?>
        <?php
            if ($cantidad > 0) {
                ?>
            <div style="width: 96%; margin-left: 12px; border:2px solid blue;">
                <div style="width: 100%; border:2px solid blue;">
                    <img src="img/favorito.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">
                    <h1 style="display: inline-block; font-size: 18px;">Favoritos: <?php echo $cantidad; ?></h1>
                </div>
                <div style="width: 99%; margin-left: 10px;">
                    <?php
                            foreach ($favoritos as $row) {
                                $id_favorito = $row['id_fav'];
                                $id_prod = $row['idproducto'];
                                $id_usu = $row['idusu'];
                                $queryp = "SELECT*FROM productos WHERE productos.idproducto='$id_prod'
                                ORDER BY idproducto DESC";
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
                                    $consulta_u = ("SELECT * FROM logueo INNER JOIN rol on logueo.codigorol = rol.codigorol
                                                    WHERE logueo.idusu='$id_usu'");
                                    $query1u = mysqli_query($mysqli, $consulta_u);
                                    $personau = mysqli_fetch_all($query1u, MYSQLI_ASSOC);
                                    foreach ($personau as $arrayu) {
                                        $imgperfi = base64_encode($arrayu['imagperfil']);
                                        $apellidop = sed::decryption($arrayu["apellidousu"]);
                                    }
                                    ?>
                            <div style="display: inline-block; ">
                                <img src="data:image/jpg;base64,<?php echo base64_encode($rowp['imagproducto']);; ?>" style="width: 96px; height: 110px; margin-top: -120px;">
                            </div>
                            <div style="display: inline-block;">
                                <p style="color:blue; font-size: 14px;"><strong><?php echo sed::decryption($rowp['nombreproducto']);; ?></strong></p>
                                <p style="color:orange; font-size: 14px; margin-top:-16px;">
                                    <strong>Empresa: <?php echo sed::decryption($arraye["nombreempresa"]);
                                                                        ?>
                                    </strong>
                                </p>
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

                                <div style="margin-top: -15px; ">
                                    <div style="display: inline-block;">
                                        <p>
                                            <strong>Guardado: <?php echo $row['fecha_guardado']; ?> </strong>
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
                                <a class="btn btn-primary" href="verproducto.php?id=<?php echo $row['idproducto']; ?>" style="width:110px; display: inline-block; margin-top: -10px;" role="button" value="Ver torta">
                                    <strong>Ver</strong>
                                </a>
                                <form action="" method="post" style="width:110px; display: inline-block; margin-top: -10px;">
                                    <input type="hidden" name="idfavo" value="<?php echo $row['id_fav']; ?>">
                                    <input type="submit" name="eliminarfavo" style="width:150px; margin-top: -10px;" class="btn btn-danger" value="Eliminar">
                                </form>
                                <?php
                                                if (isset($_POST['eliminarfavo'])) {
                                                    $idfavo = $_POST['idfavo'];
                                                    $sqlborrar = "DELETE FROM favoritos WHERE id_fav = '$idfavo'";
                                                    $resborrar = mysqli_query($mysqli, $sqlborrar);
                                                    if ($resborrar) {
                                                        echo '<div class="alert alert-primary" role="alert">Eliminado exitosamente. </div>';
                                                        echo "<script>location.href='adm.php?productoreportados=1'</script>";
                                                    } else {
                                                        echo "Error: " . $sqlborrar . "<br>" . mysqli_error($mysqli);
                                                        //echo "<script>location.href='registro.php'</script>";
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
                                <p>
                                    <strong>Guardado: <?php echo $row['fecha_guardado']; ?> </strong>
                                </p>
                                <form action="" method="post" style="width:110px; display: inline-block; margin-top: -10px;">
                                    <input type="hidden" name="idfavo" value="<?php echo $row['id_fav']; ?>">
                                    <input type="submit" name="eliminarfavo" style="width:150px; margin-top: -10px;" class="btn btn-danger" value="Eliminar">
                                </form>
                                <?php
                                                if (isset($_POST['eliminarfavo'])) {
                                                    $idfavo = $_POST['idfavo'];
                                                    $sqlborrar = "DELETE FROM favoritos WHERE id_fav = '$idfavo'";
                                                    $resborrar = mysqli_query($mysqli, $sqlborrar);
                                                    if ($resborrar) {
                                                        echo '<div class="alert alert-primary" role="alert">Eliminado exitosamente. </div>';
                                                        echo "<script>location.href='adm.php?productoreportados=1'</script>";
                                                    } else {
                                                        echo "Error: " . $sqlborrar . "<br>" . mysqli_error($mysqli);
                                                        //echo "<script>location.href='registro.php'</script>";
                                                    }
                                                }
                                                ?>
                            </div>
                            <div style="width: 90%; margin-left: 16px; background: blue; height: 3px; margin-top: 4px;"></div>
                        <?php } ?>
                    <?php } ?>
                </div>
                <div style="width: 90%; margin-left: 16px; background: blue; height: 3px; margin-top: 4px;"></div>
            </div>
        <?php } else { ?>
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
                                    Aquí se mostrarán las tortas favoritas que guardes.</strong>

                            </center>
                        </p>
                    </div>
                </div>
            </div>
        <?php } ?>

    <?php
    }
    if (@$eliminar == 1) {
        extract($_GET);
        $q_eliminar = "DELETE FROM favoritos WHERE id_fav = '$id_fav'";
        $result_eli = mysqli_query($conexion, $q_eliminar);
        if ($result_eli == 1) {
            echo "<script>location.href='favoritos.php'</script>";
        }
    }
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha256-OUFW7hFO0/r5aEGTQOz9F/aXQOt+TwqI1Z4fbVvww04=" crossorigin="anonymous"></script>

    <script src="./js/script2.js"></script>
</body>

</html>