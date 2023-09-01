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
    <title>Email|RestaurantApp</title>
    <link rel="icon" href='img/logo.png' sizes="32x32" type="img/jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css2/style.css" />
    <script src="js/jquery-3.2.1.js"></script>
    <script src="js/script.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!--<script src="https://www.google.com/recaptcha/api.js?render=6LdaxhsiAAAAAJf10JdThCppbMHLyiDH24SPp4r9"></script>
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
    </script>-->
</head>

<body>
    <?php
    extract($_GET);
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
        <div class="container-fluid">
            <div class="navbar-brand ">
                <a href="informacion.php">
                    <img src="img/atras.png" style="width: 36px; height: 40px;">
                </a>
                <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto">
                    <img src="img/logo.png" style="width: 36px; height: 40px;">Perikos
                </a>
            </div>
        </div>
    </nav><br><br><br><br>
    <center>
        <h2 style="color:blue;"><strong>Editar email</strong></h2>
    </center>
    <?php
    extract($_GET);
    require("connectdb.php");
    include 'sed.php';
    $id = $_SESSION['idusu'];
    if ($_SESSION['rolusu'] == "user" || $_SESSION['rolusu'] == "a1") {
        $sql = ("SELECT * FROM logueo  WHERE idusu='$id'");
        //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
        $resultado = mysqli_query($mysqli, $sql);
        $persona = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        foreach ($persona as $row) {
            $id = $row['idusu'];
            $emai = SED::decryption($row['emailusu']);
        }
    } elseif ($_SESSION['rolusu'] == "empresa") {
        $sql = ("SELECT * FROM logueo_empresa  WHERE id_empresa='$id'");
        //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
        $resultado = mysqli_query($mysqli, $sql);
        $persona = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        foreach ($persona as $row) {
            $id = $row['id_empresa'];
            $emai = SED::decryption($row['correoempresa']);
        }
    } elseif ($_SESSION['rolusu'] == "repartidor") {
        $sql = ("SELECT * FROM logueo_repartidor  WHERE id_repartidor='$id'");
        //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
        $resultado = mysqli_query($mysqli, $sql);
        $persona = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        foreach ($persona as $row) {
            $id = $row['id_repartidor'];
            $emai = SED::decryption($row['correo_repartidor']);
        }
    }
    ?>
    <div class="container">
        <div class="container " style="background-color:orange; ">
            <form action="" method="post">
                <!--id="form-login"-->
                <div class="row g-3">
                    <div class="col">
                        <h1 style="color:white;" class="formulario__label">Email: <?php echo $emai; ?></h1>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col">
                        <label for="" style="color:white;" class="formulario__label"><strong>Nuevo Email:</strong> </label>
                        <input type="email" class="form-control" name="emailnuevo" placeholder="Ingrese su nuevo email a cambiar">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col">
                        <label for="" style="color:white;" class="formulario__label"><strong>Ingrese su contraseña para verificar: </strong></label>
                        <div class="input-group">
                            <input type="password" class="form-control" ID="txtPassword" name="contrase" value="">
                            <div class="input-group-append">
                                <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                            </div>
                        </div>
                    </div>
                </div>
                <center>
                    <input type="submit" name="edit_infor" value="Editar" class="btn btn-primary" style="width:150px; margin-top: 16px;">
                    <!--<button type="button" id="entrar" style="color: white; margin-top: 6px;" class="btn btn-primary g-recaptcha">Editar</button>-->
                </center>
            </form>
            <script>
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
                    $('#ShowPassword').click(function() {
                        $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
                    });
                });
            </script>
            <?php
            if (isset($_POST['edit_infor'])) {
                /*if (!empty($_POST['token']) && !empty($_POST['action'])) {
                $token = $_POST['token'];
                $action = $_POST['action'];
                $secret = '6LdaxhsiAAAAAC160Xum7car1OsGqy5F4xX9oddv'; // Ingresa tu clave secreta.....

                @$response2 = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$token");
                $datos = json_decode($response2, true);*/
                $id_session = $_SESSION['idusu'];
                $emailnuevo = $_POST['emailnuevo'];
                $contraseantigua = $_POST['contrase'];
                $emaile = sed::encryption($emailnuevo);
                if (!empty($_POST['emailnuevo']) && !empty($_POST['contrase'])) {
                    $checkemailusu = mysqli_query($mysqli, "SELECT * FROM logueo WHERE emailusu='$emaile'");
                    $check_mail = mysqli_num_rows($checkemailusu);
                    $email_empresa = mysqli_query($mysqli, "SELECT * FROM logueo_empresa  WHERE correoempresa='$emaile'");
                    $check_emailempresa = mysqli_num_rows($email_empresa);
                    $email_repartidor = mysqli_query($mysqli, "SELECT * FROM logueo_repartidor  WHERE  correo_repartidor='$emaile'");
                    $check_emailrepartidor = mysqli_num_rows($email_repartidor);

                    $sql = "SELECT * FROM logueo  WHERE idusu='$id_session'";
                    //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
                    $resultado = mysqli_query($mysqli, $sql);
                    $persona = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
                    foreach ($persona as $row) {
                        $id = $row['idusu'];
                        $nombreusuario = @SED::decryption($row['nombreusu']);
                        $contrase = SED::decryption($row['contrausu']);
                        $contradmi = SED::decryption($row['contraadmin']);
                    }
                    $check_mail = mysqli_num_rows($resultado);
                    $sqle = "SELECT * FROM logueo_empresa  WHERE id_empresa='$id_session'";
                    //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
                    $resultadoe = mysqli_query($mysqli, $sqle);
                    $empresa = mysqli_fetch_all($resultadoe, MYSQLI_ASSOC);
                    foreach ($empresa as $rowe) {
                        $id = @$rowe['id_empresa'];
                        $nombreempresa = @SED::decryption($rowe['nombreempresa']);
                        $contras_em = @SED::decryption($rowe['contrase_empresa']);
                    }
                    $checke = mysqli_num_rows($resultadoe);
                    $sqlr = "SELECT * FROM logueo_repartidor  WHERE id_repartidor='$id_session'";
                    //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
                    $resultador = mysqli_query($mysqli, $sqlr);
                    $repartidor = mysqli_fetch_all($resultador, MYSQLI_ASSOC);
                    foreach ($repartidor as $rowr) {
                        $id = $rowr['id_repartidor'];
                        $nombre_repartido = @SED::decryption($rowr['nombre_repartidor']);
                        $contrase_re = SED::decryption($rowr['contrase_repartidor']);
                    }
                    $checkr = mysqli_num_rows($resultador);
                    if ($check_mail > 0 || $check_emailempresa  > 0 || $check_emailrepartidor > 0) { //Si el email nuevo existe en logueo, empresa, repartidor
                        if ($_SESSION['rolusu'] == "user") {
                            if ($check_mail > 0) { // Si existe el email
                                if ($contrase == $contraseantigua) { // Si la contraseña del cliente es correcto
                                    if ($emai == $emailnuevo) {
                                        echo "<div class='alert alert-danger' role='alert'>$nombreusuario Es tu mismo correo.</div>";
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert">Ya existe ese email. </div>';
                                    }
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>$nombreusuario tu contraseña actual es incorrecto.</div>";
                                    //echo "<script>location.href='password.php'</script>";
                                }
                            }
                        } elseif ($_SESSION['rolusu'] == "a1") {
                            if ($check_mail > 0) { // Si existe el email
                                if ($contradmi == $contraseantigua) { // Si la contrase antigua ingresada es correcta
                                    if ($emai == $emailnuevo) {
                                        echo "<div class='alert alert-danger' role='alert'>$nombreusuario Es tu mismo correo.</div>";
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert">Ya existe ese email. </div>';
                                    }
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>$nombreusuario tu contraseña actual de administrador es incorrecto.</div>";
                                    //echo "<script>location.href='password.php'</script>";
                                }
                            }
                        } elseif ($_SESSION['rolusu'] == "empresa") {
                            if ($checke > 0) {
                                if ($contras_em == $contraseantigua) { // Si la contrase antigua ingresada es correcta
                                    if ($emai == $emailnuevo) {
                                        echo "<div class='alert alert-danger' role='alert'>$nombreempresa Es tu mismo correo de empresa.</div>";
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert">Ya existe ese email de una empresa. </div>';
                                    }
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>$nombreempresa tu contraseña actual de empresa es incorrecto.</div>";
                                    //echo "<script>location.href='password.php'</script>";
                                }
                            }
                        } elseif ($_SESSION['rolusu'] == "repartidor") {
                            if ($checkr > 0) {
                                if ($contrase_re == $contraseantigua) { // Si la contrase antigua ingresada es correcta
                                    if ($emai == $emailnuevo) {
                                        echo "<div class='alert alert-danger' role='alert'>$nombre_repartido Es tu mismo correo.</div>";
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert">Ya existe ese email de una empresa. </div>';
                                    }
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>Repartidor $nombre_repartido tu contraseña actual es incorrecto.</div>";
                                    //echo "<script>location.href='password.php'</script>";
                                }
                            }
                        }
                    } else { //Si email nuevo no se repite  del cliente o adm o empresa o repartidor
                        if ($_SESSION['rolusu'] == "user") {
                            if ($check_mail > 0) { // Si existe el email
                                if ($contrase == $contraseantigua) { // Si la contraseña antigua del cliente es correcto
                                    echo '<div class="alert alert-primary" role="alert">Actualizado con éxito. </div>';
                                    $resul = mysqli_query($mysqli, "UPDATE logueo SET logueo.emailusu = '$emaile' WHERE logueo.idusu='$id_session'");
                                    if (@$resul) {
                                        echo "<script>location.href='email.php'</script>";
                                    } else {
                                        echo "Error: " . $resul . "<br>" . mysqli_error($mysqli);
                                    }
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>$nombreusuario tu contraseña actual es incorrecto.</div>";
                                    //echo "<script>location.href='password.php'</script>";
                                }
                            }
                        } elseif ($_SESSION['rolusu'] == "a1") {
                            if ($check_mail > 0) { // Si existe el email
                                if ($contradmi == $contraseantigua) { // Si la contrase antigua ingresada es correcta
                                    echo '<div class="alert alert-primary" role="alert">Actualizado con éxito. </div>';
                                    $resul = mysqli_query($mysqli, "UPDATE logueo SET logueo.emailusu = '$emaile' WHERE logueo.idusu='$id_session'");
                                    if (@$resul) {
                                        echo "<script>location.href='email.php'</script>";
                                    } else {
                                        echo "Error: " . $resul . "<br>" . mysqli_error($mysqli);
                                    }
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>$nombreusuario tu contraseña actual de administrador es incorrecto.</div>";
                                    //echo "<script>location.href='password.php'</script>";
                                }
                            }
                        } elseif ($_SESSION['rolusu'] == "empresa") {
                            if ($checke > 0) {
                                if ($contras_em == $contraseantigua) { // Si la contrase antigua ingresada es correcta
                                    echo '<div class="alert alert-primary" role="alert">Actualizado con éxito. </div>';
                                    $result = mysqli_query($mysqli, "UPDATE logueo_empresa SET correoempresa = '$emaile' WHERE id_empresa='$id_session'");
                                    if (@$result) {
                                        echo "<script>location.href='email.php'</script>";
                                    } else {
                                        echo "Error: " . $result . "<br>" . mysqli_error($mysqli);
                                    }
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>$nombreempresa tu contraseña actual de empresa es incorrecto.</div>";
                                    //echo "<script>location.href='password.php'</script>";
                                }
                            }
                        } elseif ($_SESSION['rolusu'] == "repartidor") {
                            if ($checkr > 0) {
                                if ($contrase_re == $contraseantigua) { // Si la contrase antigua ingresada es correcta
                                    echo '<div class="alert alert-primary" role="alert">Actualizado con éxito. </div>';
                                    $result = mysqli_query($mysqli, "UPDATE logueo_repartidor SET correo_repartidor = '$emaile' WHERE id_repartidor='$id_session'");
                                    if (@$result) {
                                        echo "<script>location.href='email.php'</script>";
                                    } else {
                                        echo "Error: " . $result . "<br>" . mysqli_error($mysqli);
                                    }
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>Repartidor $nombre_repartido tu contraseña actual es incorrecto.</div>";
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