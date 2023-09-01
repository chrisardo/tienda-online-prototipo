<?php
//validar
session_start();
if (@!$_SESSION['idusu']) {
    echo "<script>location.href='logueo.php'</script>";
} elseif ($_SESSION['rolusu'] == "user" || $_SESSION['rolusu'] == "a1" || $_SESSION['rolusu'] == "empresa" || $_SESSION['rolusu'] == "repartidor") {
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
if ($_SESSION['rolusu'] == "a1" || $_SESSION['rolusu'] == "user") {
    $consulta = ("SELECT * FROM logueo INNER JOIN rol on logueo.codigorol=rol.codigorol 
    WHERE idusu='$idlog'");
    $query1 = mysqli_query($mysqli, $consulta);
    $persona = mysqli_fetch_all($query1, MYSQLI_ASSOC);
    foreach ($persona as $array) {
        $id = $array['idusu'];
        $imagperfi = base64_encode($array['imagperfil']);
        $nom = sed::decryption($array["nombreusu"]);
        $apelli = sed::decryption($array["apellidousu"]);
        $celular = $array['celularusu'];
        $usernam = SED::decryption($array['usernameusu']);
        $Edad = $array['fechanaci'];
        $genero = SED::decryption($array['generousu']);
        $detalle_empresa = SED::decryption($array['detalleusu']);
        $rol = SED::decryption($array['rol']);
        $codciud = $array['codciudad'];
    }
} else if ($_SESSION['rolusu'] == "empresa") {
    $consulta = ("SELECT * FROM logueo_empresa INNER JOIN rol on logueo_empresa.codigorol=rol.codigorol
     WHERE id_empresa='$idlog'");
    $query1 = mysqli_query($mysqli, $consulta);
    $persona = mysqli_fetch_all($query1, MYSQLI_ASSOC);
    foreach ($persona as $array) {
        $id = $array['id_empresa'];
        $imagperfi = base64_encode($array['imagempresa']);
        $nom = sed::decryption($array["nombreempresa"]);
        $email = sed::decryption($array["correoempresa"]);
        $usernam = SED::decryption($array['username_empresa']);
        $celular = $array['celularempresa'];
        $direccion = SED::decryption($array['direccionempresa']);
        $rol = SED::decryption($array['rol']);
        $detalle_empresa = SED::decryption($array['detalle_empresa']);
        $codciud = $array['codciudad'];
    }
} else if ($_SESSION['rolusu'] == "repartidor") {
    $consulta = ("SELECT * FROM logueo_repartidor INNER JOIN rol on logueo_repartidor.codigorol=rol.codigorol 
    WHERE id_repartidor='$idlog'");
    $query1 = mysqli_query($mysqli, $consulta);
    $persona = mysqli_fetch_all($query1, MYSQLI_ASSOC);
    foreach ($persona as $array) {
        $id = $array['id_repartidor'];
        $imagperfi = base64_encode($array['imagperfil']);
        $nom = sed::decryption($array["nombre_repartidor"]);
        $apelli = sed::decryption($array["apellido_repartidor"]);
        $usernam = SED::decryption($array['username_repartidor']);
        $celular = $array['celular_repartidor'];
        $Edadr =  SED::decryption($array['edad_repartidor']);
        $gener = SED::decryption($array['genero_repartidor']);
        $rol = SED::decryption($array['rol']);
        $detalle_empresa = SED::decryption($array['detalle_repartidor']);
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
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $nom; ?>|Periko's</title>
    <?php
    if ($imagperfi) {
        ?>
        <link rel="icon" href='data:image/jpg;base64,<?php echo $imagperfi; ?>' sizes="32x32" type="img/jpg">
    <?php
    } else {
        ?>
        <link rel="icon" href='img/logo.png' sizes="32x32" type="img/jpg">
    <?php
    }
    ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css2/style.css" />
    <link rel="stylesheet" href="css2/invitado.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
        <div class="container-fluid">
            <a class="" <?php if (@$a == 1) { ?> href="adm.php" <?php } else { ?> href="index.php" <?php } ?>>
                <img src="img/atras.png" style="width: 30px; height: 40px;">
            </a>
            <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 16px;" href="#">
                <img src="img/logo.png" style="width: 30px; height: 30px;" alt="logo restaurantapp">
                <strong>Periko's</strong>
            </a>
        </div>
    </nav>
    <br><br>
    <center>
        <li>
            <div class="invi border-primary " style=" border:2px solid blue; width: 50%;height: 180%;" category="iquitos">
                <?php
                if ($imagperfi) {
                    ?>
                    <img src="data:image/jpg;base64,<?php echo $imagperfi; ?>" style="width: 100%" alt="imagen invitado">
                <?php
                } else {
                    ?>
                    <img src="img/fotoperfil.png" style="width: 100%" alt="imagen invitado">
                <?php
                }
                ?>

                <p class="p"><?php echo $nom; ?></p>

            </div>
        </li>
    </center>
    <?php if ($_SESSION['rolusu'] == "empresa") { ?>
        <center>
            <div style="margin-top: 3px;">
                <form method="POST" action="" enctype="multipart/form-data">
                    <input type="file" name="archivo" class="form-control" style="display: inline-block; width: 381px; border: 2px solid orangered; background-color:blue; color:white;" aria-label="Archivo">
                    <input type="submit" name="editar_foto" id="boton" style="display: inline-block; width: 82px;" class="btn btn-primary" value="Cambiar">
                </form>
            </div>
        </center>
    <?php } else { ?>
        <?php if ($imagperfi) { ?>
            <center>
                <div style="margin-top: 0px;">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <input type="submit" class="btn btn-warning" style="color:white;" name="eliminar_foto" value="Eliminar foto">
                    </form>
                </div>
            </center>
        <?php } else { ?>
            <center>
                <div style="margin-top: 3px;">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <input type="file" name="archivo" class="form-control" style="display: inline-block; width: 381px; border: 2px solid orangered; background-color:blue; color:white;" aria-label="Archivo">
                        <input type="submit" name="editar_foto" id="boton" style="display: inline-block; width: 82px;" class="btn btn-primary" value="Cambiar">
                    </form>
                </div>
            </center>
        <?php } ?>
    <?php } ?>
    <br>
    <?php
    if ($detalle_empresa) {
        ?>
        <center>
            <div style="margin-top: 0px;">
                <?php if ($_SESSION['rolusu'] == "empresa" || $_SESSION['rolusu'] == "repartidor" || $_SESSION['rolusu'] == "user") { ?>
                    <div style="display: inline-block;">
                        <p><strong><?php echo $detalle_empresa; ?></strong></p>
                    </div>
                    <div style="display: inline-block;">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <input type="submit" class="btn btn-warning" style="color:white; display: inline-block;" name="eliminardetalle" value="Eliminar">
                        </form>

                    </div>
                <?php } ?>
            </div>
        </center>
    <?php
    } else {
        ?>
        <center>
            <div style="margin-top: 3px;">
                <form method="POST" action="" enctype="multipart/form-data">
                    <?php if ($_SESSION['rolusu'] == "empresa") { ?>
                        <input type="text" name="detalleempresa" class="form-control" placeholder="Agrega una breve descripcion acerca de la empresa" maxlength="64" style="display: inline-block; width: 55%; border: 2px solid orangered;" aria-label="Archivo">
                        <input type="submit" name="agregardetalle" id="boton" style="display: inline-block; width: 82px;" class="btn btn-primary" value="Agregar">
                    <?php   } else if ($_SESSION['rolusu'] == "repartidor" || $_SESSION['rolusu'] == "user") { ?>
                        <input type="text" name="detalleempresa" class="form-control" placeholder="Agrega una breve descripcion sobre ti" maxlength="64" style="display: inline-block; width: 55%; border: 2px solid orangered;" aria-label="Archivo">
                        <input type="submit" name="agregardetalle" id="boton" style="display: inline-block; width: 82px;" class="btn btn-primary" value="Agregar">
                    <?php } ?>
                </form>
            </div>
        </center>
    <?php
    }
    ?>
    <script>
        if ($('#boton').val() != "boton")
            $('#boton').attr("disabled", true);
        else
            $('#boton').attr("disabled", false);
    </script>
    <?php
    if (isset($_POST['eliminardetalle'])) {
        $id_session = $_SESSION['idusu'];
        if ($_SESSION['rolusu'] == "a1") {
            $eliminard = mysqli_query($mysqli, "UPDATE logueo SET logueo.detalleusu = '' WHERE logueo.idusu='$id_session'");
        } else if ($_SESSION['rolusu'] == "empresa") {
            $eliminard = mysqli_query($mysqli, "UPDATE logueo_empresa SET logueo_empresa.detalle_empresa = '' WHERE logueo_empresa.id_empresa='$id_session'");
        } else if ($_SESSION['rolusu'] == "repartidor") {
            $eliminard = mysqli_query($mysqli, "UPDATE logueo_repartidor SET logueo_repartidor.detalle_repartidor = '' WHERE logueo_repartidor.id_repartidor='$id_session'");
        }
        if ($eliminard) {
            echo '<div class="alert alert-primary" role="alert">Se quitó la foto de perfil. </div>';
            if (@$a == 1) {
                echo "<script>location.href='verperfil.php?a=1'</script>";
            } else {
                echo "<script>location.href='verperfil.php'</script>";
            }
        }
    }
    if (isset($_POST['agregardetalle'])) {
        $id_session = $_SESSION['idusu'];
        $detalle = SED::encryption($_POST["detalleempresa"]);
        if ($_SESSION['rolusu'] == "a1" || $_SESSION['rolusu'] == "user") {
            $detalleempre = mysqli_query($mysqli, "UPDATE logueo SET logueo.detalleusu = '$detalle'
            WHERE logueo.idusu='$id_session'");
        } else if ($_SESSION['rolusu'] == "empresa") {
            $detalleempre = mysqli_query($mysqli, "UPDATE logueo_empresa SET logueo_empresa.detalle_empresa = '$detalle'
                WHERE logueo_empresa.id_empresa='$id_session'");
        } else if ($_SESSION['rolusu'] == "repartidor") {
            $detalleempre = mysqli_query($mysqli, "UPDATE logueo_repartidor SET logueo_repartidor.detalle_repartidor = '$detalle'
                                        WHERE logueo_repartidor.id_repartidor='$id_session'");
        }
        if ($detalleempre) {
            echo '<div class="alert alert-primary" role="alert">Se actualizó. </div>';
            if (@$a == 1) {
                echo "<script>location.href='verperfil.php?a=1'</script>";
            } else {
                echo "<script>location.href='verperfil.php'</script>";
            }
        }
    }
    if (isset($_POST['eliminar_foto'])) {
        $id_session = $_SESSION['idusu'];
        if ($_SESSION['rolusu'] == "a1") {
            $eliminar = mysqli_query($mysqli, "UPDATE logueo SET logueo.imagperfil = '' WHERE logueo.idusu='$id_session'");
        } else if ($_SESSION['rolusu'] == "empresa") {
            $eliminar = mysqli_query($mysqli, "UPDATE logueo_empresa SET logueo_empresa.imagempresa = '' WHERE logueo_empresa.id_empresa='$id_session'");
        } else if ($_SESSION['rolusu'] == "repartidor") {
            $eliminar = mysqli_query($mysqli, "UPDATE logueo_repartidor SET logueo_repartidor.imagperfil = '' WHERE logueo_repartidor.id_repartidor='$id_session'");
        }
        if ($eliminar) {
            echo '<div class="alert alert-primary" role="alert">Se quitó la foto de perfil. </div>';
            if (@$a == 1) {
                echo "<script>location.href='verperfil.php?a=1'</script>";
            } else {
                echo "<script>location.href='verperfil.php'</script>";
            }
        }
    }
    if (isset($_POST['editar_foto'])) {
        $id_session = $_SESSION['idusu'];
        //Recogemos el archivo enviado por el formulario
        $archivo = $_FILES['archivo']['name'];
        //Si el archivo contiene algo y es diferente de vacio
        if (isset($archivo) && $archivo != "") {
            //Obtenemos algunos datos necesarios sobre el archivo
            $tipo = $_FILES['archivo']['type'];
            $tamano = $_FILES['archivo']['size'];
            $temp = addslashes(file_get_contents($_FILES['archivo']['tmp_name']));
            if ($temp) {
                //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
                if (($tipo == "image/jpeg") || ($tipo == "image/jpg") || ($tipo == "image/png")) {
                    if ($tamano < 3000000) {
                        if ($_SESSION['rolusu'] == "a1") {
                            $imgeperfil = mysqli_query($mysqli, "UPDATE logueo SET logueo.imagperfil = '$temp'
                        WHERE logueo.idusu='$id_session'");
                        } else if ($_SESSION['rolusu'] == "empresa") {
                            $imgeperfil = mysqli_query($mysqli, "UPDATE logueo_empresa SET logueo_empresa.imagempresa = '$temp'
                            WHERE logueo_empresa.id_empresa='$id_session'");
                        } else if ($_SESSION['rolusu'] == "repartidor") {
                            $imgeperfil = mysqli_query($mysqli, "UPDATE logueo_repartidor SET logueo_repartidor.imagperfil = '$temp'
                                                    WHERE logueo_repartidor.id_repartidor='$id_session'");
                        }
                        if ($imgeperfil) {
                            echo '<div class="alert alert-primary" role="alert">Se actualizó. </div>';
                            if (@$a == 1) {
                                echo "<script>location.href='verperfil.php?a=1'</script>";
                            } else {
                                echo "<script>location.href='verperfil.php'</script>";
                            }
                        }
                    } else {
                        echo '<div class="alert alert-danger" role="alert">El tamaño máximo de la imagen es: 3 MB. </div>';
                    }
                } else {
                    echo '<div class="alert alert-danger" role="alert">Solo se puede subir imagenes .jpg, .jpeg, .png. </div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Pon una imagen de tu empresa.</div>';
            }
        }
    }
    ?>
    <div>
    </div>
    <div style="margin-left: 16px; margin-top: 3px;">
        <h1 style="color:blue;"><strong>Información básica</strong></h1>
        <p><strong>Username: <?php echo $usernam; ?> </strong></p>
        <p><strong>Celular: <?php echo $celular; ?> </strong></p>
        <?php if (!empty($genero)) { ?>
            <p><strong>Genero: <?php echo $genero; ?> </strong></p>
        <?php } ?>
        <?php if (!empty($direccion)) { ?>
            <p><strong>Dirección de la empresa: <?php echo $direccion; ?> </strong></p>
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
                        echo $edadusuario . " años"; // Imprimirá: 30
                        ?></strong>
            </p>
        <?php } elseif (!empty($Edadr)) { ?>
            <p><strong>Edad:
                    <?php
                        echo $Edadr . " años";
                        ?></strong>
            </p>
        <?php } ?>
        <?php if ($rol == "a1" || $rol == "empresa" || $rol == "repartidor") { ?>
            <p style=""><strong>Rol:
                    <?php if ($rol == "empresa") {
                            echo "Empresa";
                        } else if ($rol == "repartidor") {
                            echo "Repartidor";
                        } else if ($rol == "a1") {
                            echo "Administrador general";
                        }
                        ?>
                </strong>
            </p>
        <?php } ?>
        <?php if ($rol == "user" || $rol == "empresa" || $rol == "repartidor") { ?>
            <p style=""><strong>Ciudad:
                    <?php if (!empty($rowciu['codciudad'])) {
                            echo sed::decryption($rowciu['ciudad']);
                        } else {
                            echo "Se eliminó la ciudad";
                        } ?>
                </strong>
            </p>
        <?php } ?>
    </div>
</body>

</html>