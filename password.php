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
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contraseña|RestaurantApp</title>
    <link rel="icon" href='img/logo.png' sizes="32x32" type="img/jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css2/style.css" />
    <script src="js/jquery-3.2.1.js"></script>
    <script src="js/script.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="https://www.google.com/recaptcha/api.js?render=6LdaxhsiAAAAAJf10JdThCppbMHLyiDH24SPp4r9"></script>
    <script>
        $(document).ready(function() {
            $('#entrar').click(function() {
                grecaptcha.ready(function() {
                    grecaptcha.execute('6LdaxhsiAAAAAJf10JdThCppbMHLyiDH24SPp4r9', {
                        action: 'validarUsuario'
                    }).then(function(token) {
                        $('#form-login').prepend('<input type="hidden" name="token" value="' + token + '">');
                        $('#form-login').prepend('<input type="hidden" name="action" value="validarUsuario">');
                        $('#form-login').submit();
                    });
                });
            })
        })
    </script>
</head>

<body>
    <?php
    extract($_GET);
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
        <div class="container-fluid">
            <div class="navbar-brand ">
                <?php
                if (@$adm == 1) {
                    ?>
                    <a href="informacion.php?adm=1">
                        <img src="img/atras.png" style="width: 36px; height: 40px;">
                    </a>
                <?php
                } else {
                    ?>
                    <a href="informacion.php">
                        <img src="img/atras.png" style="width: 36px; height: 40px;">
                    </a>
                <?php
                }
                ?>
                <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto">
                    <img src="img/logo.png" style="width: 36px; height: 40px;">Perikos
                </a>
            </div>
        </div>
    </nav><br><br><br><br>
    <?php
    extract($_GET);
    require("connectdb.php");
    include 'sed.php';
    $id = $_SESSION['idusu'];
    ?>
    <center>
        <h2 style="color:blue;"><strong>Editar contraseña <?php //echo $contrase;
                                                            ?></strong></h2>
    </center>
    <div class="container">
        <div class="container " style="background-color:orange; ">
            <form action="" id="form-login" method="post">
                <div class="row g-3">
                    <div class="col">
                        <label for="" style="color:white;" class="formulario__label"><strong>Nueva contraseña:</strong> </label>
                        <div class="input-group">
                            <input type="password" ID="txtPassword" class="form-control" name="contrasenuevo" placeholder="">
                            <div class="input-group-append">
                                <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col">
                        <label for="" style="color:white;" class="formulario__label"><strong>Contraseña actual: </strong></label>
                        <div class="input-group">
                            <input type="password" ID="txtPassword1" class="form-control" name="contraseantigua" placeholder="Ingrese su contraseña actual para verificar">
                            <div class="input-group-append">
                                <button id="show_password1" class="btn btn-primary" type="button" onclick="mostrarPassword1()"> <span class="fa fa-eye-slash icon"></span> </button>
                            </div>
                        </div>
                    </div>
                </div>
                <center>
                    <!--<input type="submit" name="edit_infor" value="Cambiar" class="btn btn-primary" style="width:150px; margin-top: 16px;">-->
                    <button type="button" id="entrar" style="color: white; margin-top: 4px;" class="btn btn-primary g-recaptcha">Cambiar</button><br>
                </center><br>
            </form>
            <script>
                function mostrarPassword1() {
                    var cambio1 = document.getElementById("txtPassword1");
                    if (cambio1.type == "password") {
                        cambio1.type = "text";
                        $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                    } else {
                        cambio1.type = "password";
                        $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                    }
                }

                function mostrarPassword() {
                    var cambio = document.getElementById("txtPassword");

                    if (cambio.type == "password") {
                        cambio.type = "text";
                        $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                    } else {
                        cambio.type = "password";
                        $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                    }
                }

                $(document).ready(function() {
                    //CheckBox mostrar contraseña
                    $('#ShowPassword1').click(function() {
                        $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
                    });
                    $('#ShowPassword').click(function() {
                        $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
                    });
                });
            </script>
            <?php
            require("connectdb.php"); //requerir la conexion a la base de datos
            //if (isset($_POST['edit_infor'])) {
            if (!empty($_POST['token']) && !empty($_POST['action'])) {
                $token = $_POST['token'];
                $action = $_POST['action'];
                $secret = '6LdaxhsiAAAAAC1|60Xum7car1OsGqy5F4xX9oddv'; // Ingresa tu clave secreta.....

                @$response2 = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$token");
                $datos = json_decode($response2, true);
                $id_session = $_SESSION['idusu'];
                $contrasenuevo = $_POST['contrasenuevo'];
                $contraseantigua = $_POST['contraseantigua'];
                $contranuevoe = sed::encryption($contrasenuevo);
                if (!empty($_POST['contrasenuevo']) && !empty($_POST['contraseantigua'])) {
                    $contra_cliente = mysqli_query($mysqli, "SELECT * FROM logueo  WHERE contrausu='$contranuevoe' or contraadmin='$contranuevoe'");
                    $check_contracliente = mysqli_num_rows($contra_cliente);
                    $contra_empresa = mysqli_query($mysqli, "SELECT * FROM logueo_empresa  WHERE contrase_empresa='$contranuevoe'");
                    $check_contraempresa = mysqli_num_rows($contra_empresa);
                    $contra_repartidor = mysqli_query($mysqli, "SELECT * FROM logueo_repartidor  WHERE contrase_repartidor=' $contranuevoe'");
                    $check_contrarepartidor = mysqli_num_rows($contra_repartidor);

                    $sql = "SELECT * FROM logueo  WHERE idusu='$id_session'";
                    //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
                    $resultado = mysqli_query($mysqli, $sql);
                    $persona = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
                    foreach ($persona as $row) {
                        $id = $row['idusu'];
                        $nombreusuario=@SED::decryption($row['nombreusu']);
                        $contrase = SED::decryption($row['contrausu']);
                        $contradmi = SED::decryption($row['contraadmin']);
                    }
                    $check = mysqli_num_rows($resultado);
                    $sqle = "SELECT * FROM logueo_empresa  WHERE id_empresa='$id_session'";
                    //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
                    $resultadoe = mysqli_query($mysqli, $sqle);
                    $empresa = mysqli_fetch_all($resultadoe, MYSQLI_ASSOC);
                    foreach ($empresa as $rowe) {
                        $id = @$rowe['id_empresa'];
                        $nombreempresa=@SED::decryption($rowe['nombreempresa']);
                        $contras_em = @SED::decryption($rowe['contrase_empresa']);
                    }
                    $checke = mysqli_num_rows($resultadoe);
                    $sqlr = "SELECT * FROM logueo_repartidor  WHERE id_repartidor='$id_session'";
                    //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
                    $resultador = mysqli_query($mysqli, $sqlr);
                    $repartidor = mysqli_fetch_all($resultador, MYSQLI_ASSOC);
                    foreach ($repartidor as $rowr) {
                        $id = $rowr['id_repartidor'];
                        $nombre_repartido=@SED::decryption($rowr['nombre_repartidor']);
                        $contrase_re = SED::decryption($rowr['contrase_repartidor']);
                    }
                    $checkr = mysqli_num_rows($resultador);
                    //Si la contraseña se repite en logueo, empresa, repartidor
                    if ($check_contracliente > 0 || $check_contraempresa > 0 || $check_contrarepartidor > 0) { 
                        if ($_SESSION['rolusu'] == "user") {
                            if ($check > 0) { //si existe el usuario cliente
                                if ($contrase == $contraseantigua) { // Si la contraseña del cliente es correcto
                                    if ($contrase == $contrasenuevo) {
                                        echo "<div class='alert alert-danger' role='alert'>$nombreusuario Es tu misma contraseña.</div>";
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert">La nueva contraseña que ingresaste ya existe. </div>';
                                    }
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>$nombreusuario tu contraseña actual es incorrecto.</div>";
                                    //echo "<script>location.href='password.php'</script>";
                                }
                            }
                        } elseif ($_SESSION['rolusu'] == "a1") {
                            if ($check > 0) {
                                if ($contradmi == $contraseantigua) { // Si la contrase antigua ingresada es correcta
                                    if ($contradmi == $contrasenuevo) {
                                        echo "<div class='alert alert-danger' role='alert'>$nombreusuario Es tu misma contraseña.</div>";
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert">La nueva contraseña que ingresaste ya existe. </div>';
                                    }
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>$nombreusuario tu contraseña actual de administrador es incorrecto.</div>";
                                    //echo "<script>location.href='password.php'</script>";
                                }
                            }
                        } elseif ($_SESSION['rolusu'] == "empresa") {
                            if ($checke > 0) {
                                if ($contras_em == $contraseantigua) { // Si la contrase antigua ingresada es correcta
                                    if ($contras_em == $contrasenuevo) {
                                        echo "<div class='alert alert-danger' role='alert'>$nombreempresa Es tu misma contraseña.</div>";
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert">La nueva contraseña que ingresaste ya existe. </div>';
                                    }
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>$nombreempresa tu contraseña actual es incorrecto.</div>";
                                    //echo "<script>location.href='password.php'</script>";
                                }
                            }
                        } elseif ($_SESSION['rolusu'] == "repartidor") {
                            if ($checkr > 0) {
                                if ($contrase_re == $contraseantigua) { // Si la contrase antigua ingresada es correcta
                                    if ($contrase_re == $contrasenuevo) {
                                        echo "<div class='alert alert-danger' role='alert'>$nombre_repartido Es tu misma contraseña.</div>";
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert">La nueva contraseña que ingresaste ya existe. </div>';
                                    }
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'> $nombre_repartido tu contraseña actual es incorrecto.</div>";
                                    //echo "<script>location.href='password.php'</script>";
                                }
                            }
                        }
                    } else { //Si la contraseña acutal no se repite en la contraseña del cliente o adm o empresa o repartidor
                        if ($_SESSION['rolusu'] == "user") {
                            if ($check > 0) { //si existe el usuario cliente
                                if ($contrase == $contraseantigua) { // Si la contraseña del cliente es correcto
                                    echo '<div class="alert alert-primary" role="alert">Actualizado con Exito. </div>';
                                    $resul = mysqli_query($mysqli, "UPDATE logueo
                                    SET logueo.contrausu= '$contranuevoe' WHERE logueo.idusu='$id_session'");
                                    if (@$resul) {
                                        echo "<script>location.href='password.php'</script>";
                                    } else {
                                        echo "Error: " . $resul . "<br>" . mysqli_error($mysqli);
                                    }
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>$nombreusuario tu contraseña actual es incorrecto.</div>";
                                    //echo "<script>location.href='password.php'</script>";
                                }
                            }
                        } elseif ($_SESSION['rolusu'] == "a1") {
                            $check = mysqli_num_rows($resultado);
                            if ($check > 0) {
                                if ($contradmi == $contraseantigua) { // Si la contrase antigua ingresada es correcta
                                    echo '<div class="alert alert-primary" role="alert">Actualizado con Exito. </div>';
                                    $resul = mysqli_query($mysqli, "UPDATE logueo
                                SET logueo.contraadmin= '$contranuevoe' WHERE logueo.idusu='$id_session'");
                                    if (@$resul) {
                                        echo "<script>location.href='password.php'</script>";
                                    } else {
                                        echo "Error: " . $resul . "<br>" . mysqli_error($mysqli);
                                    }
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>$nombreusuario tu contraseña actual es incorrecto.</div>";
                                    //echo "<script>location.href='password.php'</script>";
                                }
                            }
                        } elseif ($_SESSION['rolusu'] == "empresa") {
                            if ($checke > 0) {
                                if ($contras_em == $contraseantigua) { // Si la contrase antigua ingresada es correcta
                                    echo '<div class="alert alert-primary" role="alert">Actualizado con Exito. </div>';
                                    $resul = mysqli_query($mysqli, "UPDATE logueo_empresa
                                SET contrase_empresa= '$contranuevoe' WHERE id_empresa='$id_session'");
                                    if (@$resul) {
                                        echo "<script>location.href='password.php'</script>";
                                    } else {
                                        echo "Error: " . $resul . "<br>" . mysqli_error($mysqli);
                                    }
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>$nombreempresa tu contraseña actual es incorrecto.</div>";
                                    //echo "<script>location.href='password.php'</script>";
                                }
                            }
                        } elseif ($_SESSION['rolusu'] == "repartidor") {
                            if ($checkr > 0) {
                                if ($contrase_re == $contraseantigua) { // Si la contrase antigua ingresada es correcta
                                    echo '<div class="alert alert-primary" role="alert">Actualizado con Exito. </div>';
                                    $resul = mysqli_query($mysqli, "UPDATE logueo_repartidor
                                SET contrase_repartidor= '$contranuevoe' WHERE id_repartidor='$id_session'");
                                    if (@$resul) {
                                        echo "<script>location.href='password.php'</script>";
                                    } else {
                                        echo "Error: " . $resul . "<br>" . mysqli_error($mysqli);
                                    }
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>$nombre_repartido tu contraseña actual es incorrecto.</div>";
                                    //echo "<script>location.href='password.php'</script>";
                                }
                            }
                        }
                    }
                }
            }
            ?>
        </div><br>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha256-OUFW7hFO0/r5aEGTQOz9F/aXQOt+TwqI1Z4fbVvww04=" crossorigin="anonymous"></script>

    <script src="./js/script2.js"></script>
</body>

</html>