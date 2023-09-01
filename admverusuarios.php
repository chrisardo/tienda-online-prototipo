<?php
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
require("connectdb.php");
include("conexion.php");
include 'sed.php';
$idlog = @$_SESSION['idusu'];
extract($_GET);
if (@$empresas == 1 || @$solicitudempresa == 1) {
    $consulta = ("SELECT * FROM logueo_empresa INNER JOIN rol
    on logueo_empresa.codigorol = rol.codigorol  WHERE logueo_empresa.id_empresa='$id'");
    $query1 = mysqli_query($mysqli, $consulta);
    $persona = mysqli_fetch_all($query1, MYSQLI_ASSOC);
    foreach ($persona as $array) {
        $idlogi = $array['id_empresa'];
        $imagperfi = base64_encode($array['imagempresa']);
        $nom = sed::decryption($array["nombreempresa"]);
        $contrase = sed::decryption($array['contrase_empresa']);
        $email = sed::decryption($array['correoempresa']);
        $usernam = sed::decryption($array['username_empresa']);
        $direccion = sed::decryption($array['direccionempresa']);
        $celular = $array['celularempresa'];
        $rol = sed::decryption($array['rol']);
        $fecharegistro = $array['fecharegistro_empresa'];
        $estado = $array['estado'];
        $codciud = $array['codciudad'];
    }
} else {
    $consulta = ("SELECT * FROM logueo INNER JOIN rol
    on logueo.codigorol = rol.codigorol  WHERE logueo.idusu='$id'");
    $query1 = mysqli_query($mysqli, $consulta);
    $persona = mysqli_fetch_all($query1, MYSQLI_ASSOC);
    foreach ($persona as $array) {
        @$idlogi = @$array['idusu'];
        $imagperfi = base64_encode($array['imagperfil']);
        $nom = sed::decryption($array["nombreusu"]);
        $apelli = sed::decryption($array["apellidousu"]);
        $contrase = sed::decryption($array['contrausu']);
        $genero = sed::decryption($array['generousu']);
        $email = sed::decryption($array['emailusu']);
        $usernam = sed::decryption($array['usernameusu']);
        $pasadmin = sed::decryption($array['contraadmin']);
        $celular = $array['celularusu'];
        $rol = sed::decryption($array['rol']);
        $fecharegistro = $array['fecharegistro'];
        $Edad = $array['fechanaci'];
        $estado = $array['baneo'];
        $codciud = $array['codciudad'];
    }
}
$sqlci = "SELECT * FROM ciudad where codciudad ='$codciud' group by ciudad ORDER BY idciudad DESC";
$resultadoci = mysqli_query($conexion, $sqlci);
$ciud = mysqli_fetch_all($resultadoci, MYSQLI_ASSOC);
foreach ($ciud as $rowciu) {
    $codciuda = $rowciu['codciudad'];
    $nombreciuda = sed::decryption($rowciu['ciudad']);
}
?>
<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $nom;; ?> | RestaurantApp</title>
    <link rel="icon" href='img/logo.png' sizes="32x32" type="img/jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css2/style.css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
        <div class="container-fluid">
            <?php
            if (!@empty($empresas == 1)) {
                ?>
                <a class="" href="adm.php?empresas=1">
                    <img src="img/atras.png" style="width: 30px; height: 40px;">
                </a>
            <?php
            } else if (!@empty($solicitudempresa == 1)) {
                ?>
                <a class="" href="adm.php?solicitudempresa=1">
                    <img src="img/atras.png" style="width: 30px; height: 40px;">
                </a>
            <?php } else { ?>
                <a class="" href="admclientes.php">
                    <img src="img/atras.png" style="width: 30px; height: 40px;">
                </a>
            <?php } ?>


            <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 15px;" href="#">

                <img src="img/logo.png" style="width: 30px; height: 30px;" alt="logo restaurantapp">
                <strong>Perikos's</strong>
            </a>
        </div>
    </nav><br><br><br>
    <center>
        <li>
            <div class="invi border-primary" style=" border:2px solid blue; width: 50%;height: 40%;" category="iquitos">
                <?php
                if ($imagperfi) {
                    ?>
                    <img src="data:image/jpg;base64,<?php echo $imagperfi; ?>" style="width: 100%; height: 200px;" alt="imagen invitado">
                <?php
                } else {
                    ?>
                    <img src="img/fotoperfil.png" style="width: 100%; height: 200px;" alt="imagen invitado">
                <?php
                }
                ?>
            </div>
        </li>
    </center>
    <center>
        <h2><?php echo $nom; ?> <?php if (!empty($apelli)) {
                                    echo $apelli;
                                }; ?></h2>
    </center>
    <div style="margin-left: 16px; margin-top: 3px;">
        <h1 style="color:green;"><strong>Información básica</strong></h1>
        <p><strong>Username: <?php echo $usernam; ?> </strong></p>
        <p><strong>Celular: <?php echo $celular; ?> </strong></p>
        <?php if (!empty($genero)) { ?>
            <p><strong>Genero: <?php echo $genero; ?> </strong></p>
        <?php } ?>
        <?php if (!empty($direccion)) { ?>
            <p><strong>Dirección de la empresa: <?php echo $direccion; ?> </strong></p>
        <?php } ?>
        <p><strong>Email: <?php echo $email; ?> </strong></p>
        <?php if ($rol == "user" || $rol == "empresa" || $rol == "repartidor") { ?>
            <p style=""><strong>Ciudad:
                    <?php if (!empty($rowciu['codciudad'])) {
                            echo sed::decryption($rowciu['ciudad']);
                        } else {
                            echo "No agregó ciudad";
                        } ?>
                </strong>
            </p>
        <?php } ?>
        <?php if (!empty($Edad)) { ?>
            <p><strong>Edad:
                    <?php
                        function calculaedad($Edad)
                        {
                            list($ano, $mes, $dia) = explode("-", $Edad);
                            $ano_diferencia  = date("Y") - $ano;
                            $mes_diferencia = date("m") - $mes;
                            $dia_diferencia   = date("d") - $dia;
                            if ($dia_diferencia < 0 || $mes_diferencia < 0)
                                $ano_diferencia--;
                            return $ano_diferencia;
                        }
                        $edadusuario = calculaedad($Edad);
                        // Modo de uso
                        //echo calculaedad($fechnacimiento); // Imprimirá: 30
                        echo $edadusuario; // Imprimirá: 30
                        ?></strong>
            </p>
        <?php } elseif (!empty($Edadr)) { ?>
            <p><strong>Edad:
                    <?php
                        echo $Edadr;
                        ?></strong>
            </p>
        <?php } ?>

        <p style=""><strong>Rol:
                <?php
                if ($rol == "user") {
                    echo "Cliente";
                } else if ($rol == "empresa") {
                    echo "Empresa";
                }
                ?>
            </strong>
        </p>
        <?php if ($estado == 0 && @$solicitudempresa == 1) { ?>
            <br>
            <center>
                <form action="" method="post" style="width:110px; display: inline-block; margin-top: -30px;">
                    <input type="hidden" name="idempresa" value="<?php echo $idlogi; ?>">
                    <input type="submit" style="width:160%; margin-top: -10px; color:white;" class="btn btn-warning" name="aceptar_empresa" value="Aceptar solicitud">
                </form>
            </center>
            <?php
                if (isset($_POST['aceptar_empresa'])) {
                    $idempresa = $_POST['idempresa'];
                    $sqlbanear = "UPDATE logueo_empresa SET estado= '1' WHERE id_empresa='$idempresa'";
                    $resbanear = mysqli_query($mysqli, $sqlbanear);
                    if ($resbanear) {
                        echo '<div class="alert alert-primary" role="alert">Solicitud aceptado. </div>';
                        echo "<script>location.href='adm.php?solicitudempresa=1'</script>";
                    } else {
                        echo "Error: " . $sqlbanear . "<br>" . mysqli_error($mysqli);
                        //echo "<script>location.href='registro.php'</script>";
                    }
                }
                ?>
        <?php } else { ?>
            <p style="float: left;"><strong>Estado:
                    <form action="" style="float: left; margin-left: 6px; margin-top: -2px;" method="post" class="formulario column  bg-orange">
                        <div class="row g-3">
                            <div class="col">
                                <select id="estado" style="border:2px solid green; color:green;" name="estadobaneo" class="form-control">
                                    <option value="<?php if ($estado == 1) {
                                                            echo "Habiliado";
                                                        } else if ($estado == 2) {
                                                            echo "baneado";
                                                        } ?>" selected=""><?php if ($estado == 1) {
                                                                                    echo "Habilitado";
                                                                                } else if ($estado == 2) {
                                                                                    echo "baneado";
                                                                                } ?></option>
                                    <option value="1">Habiliar </option>
                                    <option value="2">Banear </option>
                                </select>
                            </div>
                            <div class="col">
                                <input type="submit" style="margin-left: -15px;" class="btn btn-success" name='cambiarestado' value="Cambiar estado">
                            </div>
                        </div>
                    </form>
                    <?php
                        if (isset($_POST['cambiarestado'])) {
                            $baneoesta = $_POST['estadobaneo'];
                            $baneo = mysqli_query($mysqli, "UPDATE logueo SET logueo.baneo = '$baneoesta' WHERE logueo.idusu='$idlogi'");
                            $baneo = mysqli_query($mysqli, "UPDATE logueo_empresa SET logueo_empresa.estado = '$baneoesta' WHERE logueo_empresa.id_empresa='$idlogi'");
                            $baneo = mysqli_query($mysqli, "UPDATE logueo_repartidor SET logueo_repartidor.baneo = '$baneoesta' WHERE logueo_repartidor.id_repartidor='$idlogi'");
                            if ($baneo) {
                                if (!@empty($empresas == 1)) {
                                    echo "<script>location.href='admverusuarios.php?id=$id&empresas=1'</script>";
                                } else {
                                    echo "<script>location.href='admverusuarios.php?id=$id'</script>";
                                }
                            } else {
                                echo '<div class="alert alert-danger" role="alert">No se cambió el estado. </div>';
                            }
                        }
                        ?>
                </strong>
            </p>
        <?php } ?>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>