<?php session_start(); //inciar session
include 'sed.php';
require("connectdb.php"); //requerir la conexion a la base de datos
//require("conexion.php"); //requerir la conexion a la base de datos
/*if (isset($_POST['token']) && isset($_POST['action'])) {
    $token = $_POST['token'];
    $action = $_POST['action'];
    $secret = '6LdaxhsiAAAAAC160Xum7car1OsGqy5F4xX9oddv'; // Ingresa tu clave secreta.....
    @$response2 = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$token");
    $datos = json_decode($response2, true);*/
if (isset($_POST['inicio'])) {
    $nombreusuario = $_POST['username']; //mail es el nombre del cuadro de texto del input
    $contrase = $_POST['pass']; //recoge el password que ingresamos
    $username1 = sed::encryption($nombreusuario);
    $username2 = sed::encryption($nombreusuario);
    $contra1 = sed::encryption($contrase);
    $contra2 = sed::encryption($contrase);
    //para la empresa
    $sqlem = mysqli_query($mysqli, "SELECT * FROM logueo_empresa
   INNER JOIN rol on logueo_empresa.codigorol=rol.codigorol
   WHERE logueo_empresa.username_empresa='$username2' and logueo_empresa.contrase_empresa='$contra2' ");
    $cantem = mysqli_num_rows($sqlem);
    //para el administrador
    $sqladm = mysqli_query($mysqli, "SELECT * FROM logueo INNER JOIN rol 
   on logueo.codigorol=rol.codigorol WHERE usernameusu='$username2' and contraadmin='$contra2'");
    $cantadmin = mysqli_num_rows($sqladm);
    //para los usuarios normales
    $sqlu = mysqli_query($mysqli, "SELECT * FROM logueo INNER JOIN rol 
      on logueo.codigorol=rol.codigorol WHERE usernameusu='$username2' and contrausu='$contra2'");
    $cantusu = mysqli_num_rows($sqlu);
    //para el repartidor
    $sqlre = mysqli_query($mysqli, "SELECT * FROM logueo_repartidor INNER JOIN rol 
       on logueo_repartidor.codigorol=rol.codigorol 
       WHERE logueo_repartidor.username_repartidor='$username2' and logueo_repartidor.contrase_repartidor='$contra2'");
    $cantrepar = mysqli_num_rows($sqlre);
    if (isset($_COOKIE["blocke" . $username2])) { } else {
        if ($cantusu > 0) {
            if ($use = mysqli_fetch_assoc($sqlu)) {
                $apelliuse = sed::encryption($use['apellidousu']);
                $baneado = $use['baneo'];
                $idlogus = $use['idusu'];
                if ($contrase == sed::decryption($use['contrausu'])) {
                    if ($use['baneo'] == 1) { //si cuenta está habilitado
                        //print_r($datos);
                        // verificar la respuesta
                        //if (@$datos['success'] == 1 && @$datos['score'] >= 0.9) {
                        //if ($datos['action'] == 'validarUsuario') {
                        $_SESSION['idusu'] = $use['idusu'];
                        $_SESSION['nombreusu'] = sed::decryption($use['nombreusu']);
                        $_SESSION['apellidousu'] = sed::decryption($use['apellidousu']);
                        $_SESSION['emailusu'] = sed::decryption($use['emailusu']);
                        $_SESSION['rolusu'] = sed::decryption($use['rol']);
                        $_SESSION['last_login_timestamp'] = time();
                        echo "<script>location.href='index.php?index=1'</script>";
                        //}
                        //} else { }
                    }
                }
            }
            //echo "<script>location.href='registro.php'</script>";
        } elseif ($cantadmin > 0) {
            if ($us2 = mysqli_fetch_assoc($sqladm)) { //verificamo si $f2 que es una variable cualquiera que obtenga los datos de la consulta $sql2
                //my_fetch_assoc();->Devuelve una matriz asociativa que corresponde a la fila recuperada y mueve el apuntador de datos interno hacia adelante.
                if ($contrase == sed::decryption($us2['contraadmin'])) { //si $f2 encuentra que el username es igual al pasadmin o la $pass quiere decir que es el administrador que se esta autentificando en el login
                    if ($us2['baneo'] == 0) { //si cuenta está habilitado
                        $_SESSION['idusu'] = $us2['idusu'];
                        $_SESSION['nombreusu'] = sed::decryption($us2['nombreusu']); //es el nombre de quien se esta autentificandose con el query
                        $_SESSION['apellidousu'] = sed::decryption($us2['apellidousu']);
                        $_SESSION['emailusu'] = sed::decryption($us2['emailusu']);
                        $_SESSION['rolusu'] = SED::decryption($us2['rol']);
                        $_SESSION['last_login_timestamp'] = time();
                        echo "<script>location.href='adm.php?inicio=1'</script>"; //y lo referenciara a la pagina del administrador{
                    }
                }
            }
        } elseif ($cantem > 0) {
            if ($empre = mysqli_fetch_assoc($sqlem)) {
                if ($contrase == sed::decryption($empre['contrase_empresa'])) {
                    if ($empre['estado'] == 1) { //si cuenta está habilitado
                        $idempre = $empre['id_empresa'];
                        $rolempre = sed::decryption($empre['rol']);
                        //print_r($datos);
                        // verificar la respuesta
                        //if (@$datos['success'] == 1 && @$datos['score'] >= 0.9) {
                        //if ($datos['action'] == 'validarUsuario') {
                        $_SESSION['idusu'] = $idempre;
                        $_SESSION['nombreusu'] = sed::decryption($empre['nombreempresa']);
                        $_SESSION['emailusu'] = sed::decryption($empre['correoempresa']);
                        $_SESSION['rolusu'] = sed::decryption($empre['rol']);
                        $_SESSION['last_login_timestamp'] = time();
                        echo "<script>location.href='adm.php'</script>";
                        //echo "<div class='alert alert-danger' role='alert'>$idempre $rolempre existe la empresa.</div>";
                        //}
                        //} else { }
                    } else  if ($empre['estado'] == 0) {
                        $idempre = $empre['id_empresa'];
                        $rolempre = sed::decryption($empre['rol']);
                        //print_r($datos);
                        // verificar la respuesta
                        //if (@$datos['success'] == 1 && @$datos['score'] >= 0.9) {
                        //if ($datos['action'] == 'validarUsuario') {
                        $_SESSION['idusu'] = $idempre;
                        $_SESSION['nombreusu'] = sed::decryption($empre['nombreempresa']);
                        $_SESSION['emailusu'] = sed::decryption($empre['correoempresa']);
                        $_SESSION['rolusu'] = sed::decryption($empre['rol']);
                        $_SESSION['last_login_timestamp'] = time();
                        //echo "<div class='alert alert-danger' role='alert'>$idempre $rolempre existe la empresa.</div>";
                        //}
                        //} else { }
                        echo "<script>location.href='salaespera.php'</script>";
                    }
                }
            }
        } elseif ($cantrepar > 0) {
            if ($repartidor = mysqli_fetch_assoc($sqlre)) {
                if ($repartidor['baneo'] == 0) { //si no está baneado
                    if ($contrase == sed::decryption($repartidor['contrase_repartidor'])) {
                        $idre = $repartidor['id_repartidor'];
                        $rolre = sed::decryption($repartidor['rol']);
                        //print_r($datos);
                        // verificar la respuesta
                        //if (@$datos['success'] == 1 && @$datos['score'] >= 0.9) {
                        //if ($datos['action'] == 'validarUsuario') {
                        $_SESSION['idusu'] = $idre;
                        $_SESSION['nombreusu'] = sed::decryption($repartidor['nombre_repartidor']);
                        $_SESSION['emailusu'] = sed::decryption($repartidor['correo_repartidor']);
                        $_SESSION['rolusu'] = sed::decryption($repartidor['rol']);
                        $_SESSION['last_login_timestamp'] = time();
                        echo "<script>location.href='adm.php'</script>";
                        echo "<div class='alert alert-danger' role='alert'>$idre $rolre existe .</div>";
                        //}
                        //} else { }
                    }
                }
            }
        } else {
            if (isset($_COOKIE["$username2"])) {
                $contcoockie = $_COOKIE["$username2"];
                $contcoockie++;
                setcookie($username2, $contcoockie, time() + 120);
                if ($contcoockie >= 4) {
                    setcookie("blocke" . $username2, $contcoockie, time() + 43200); //6o segundos es 1 minuto, 86400 segundos es por 24 horas, 43200 segundos es 12 horas.
                }
            } else {
                setcookie($username2, 1, time() + 120);
            }
        }
    }
}
if (isset($_COOKIE["cerrarsesion"])) {
    //mensajesessioninactivo();
    //echo "<div class='alert alert-danger' role='alert'> Se detecto 4 minuto de inactividad. Inicia sesión nuevamente</div>";
    setcookie("cerrarsesion", 1, time() - 60000); //6o segundos es 1 minuto, 86400 segundos es por 24 horas
}
?>
<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | RestaurantApp</title>
    <link rel="icon" href='img/ilogo.png' sizes="32x32" type="img/jpg">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <script src="js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
    <nav style="width: 100%; height: 50px;" class="fixed-top bg-primary">
        <div class="">
            <a class="" style="margin-left: 16px;" href="index.php">
                <img src="img/atras.png" style="margin-top: 5px; width: 30px; height: 40px;">
            </a>
            <a class="" style="font-size: 22px; margin-top: 12px; color:white;">
                <img src="img/ilogo.png" style="width: 35px; height: 34px;" alt="logo restaurantapp">
                <strong>Perikos's</strong>
            </a>
        </div>
    </nav>
    <div class="container">
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <center>
                        <div class="panel-title" style="color:blue;">Iniciar Sesi&oacute;n</div>
                    </center>
                </div>
                <div style="padding-top:20px" class="panel-body">
                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                    <form class="formulario column" action="logueo.php" method="post">
                        <!-- id="form-login"-->
                        <label style="font-size: 14pt; color:#000;"><b>Username:</b></label>
                        <!--Etiqueta correo con estilo de tamaño de fuente:14pt de color blanco-->
                        <input type="text" name="username" class="form-control" placeholder="Ingrese su nombre de usuario" required><br>
                        <!--Entrada clase "inp" de tipo "texto" con un nombre "mail" de valor "nulo" con marcador de posicion "email"-->
                        <label style="font-size: 14pt; color:#000;"><b>Contraseña:</b></label>
                        <div style="width: 100%;">
                            <input type="password" name="pass" ID="txtPassword" class="form-control" style="float: left; width: 85%;" placeholder="Ingrese su contraseña" required>
                            <button id="show_password" class="btn btn-primary" style="float:left;height: 34px; margin-left: 3px;" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                        </div>
                        <div>
                            <center>
                                <input class="btn btn-primary" type="submit" name="inicio" style="margin-top: 10px;" value="Iniciar Sesión">
                                <!--<button type="button" id="entrar" style="color: white; margin-top: 6px;" class="btn btn-primary g-recaptcha">Ingresar</button>-->
                            </center><br>
                        </div>
                        <!--Entrada de clase boton tipo "envio" de nombre "inicio" como valor poniendole "Iniciar session"-->
                        <div class="form-group">
                            <div class="col-md-12 control">
                                <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%">
                                    <a href="registrarme.php?logueo=1">Registrate aquí</a>
                                    <!--<a style="float:right; position: relative; " href="recupe.php">¿Se te olvidó tu contraseña?</a>-->
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                    /*if (isset($_POST['token']) && isset($_POST['action'])) {
                        $token = $_POST['token'];
                        $action = $_POST['action'];
                        $secret = '6LdaxhsiAAAAAC160Xum7car1OsGqy5F4xX9oddv'; // Ingresa tu clave secreta.....
                        @$response2 = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$token");
                        $datos = json_decode($response2, true);*/
                    if (isset($_POST['inicio'])) {
                        $nombreusuario = $_POST['username']; //mail es el nombre del cuadro de texto del input
                        $contrase = $_POST['pass']; //recoge el password que ingresamos
                        $username1 = sed::encryption($nombreusuario);
                        $username2 = sed::encryption($nombreusuario);
                        $contra1 = sed::encryption($contrase);
                        $contra2 = sed::encryption($contrase);
                        $sqle = mysqli_query($mysqli, "SELECT * FROM logueo_empresa
   INNER JOIN rol on logueo_empresa.codigorol=rol.codigorol
   WHERE logueo_empresa.username_empresa='$username2' and logueo_empresa.contrase_empresa='$contra2' ");
                        $cante = mysqli_num_rows($sqle);
                        //para el administrador
                        $sqladm = mysqli_query($mysqli, "SELECT * FROM logueo INNER JOIN rol 
   on logueo.codigorol=rol.codigorol WHERE usernameusu='$username2' and contraadmin='$contra2'");
                        $cantadmin = mysqli_num_rows($sqladm);
                        //para los usuarios normales
                        $sqlu = mysqli_query($mysqli, "SELECT * FROM logueo INNER JOIN rol 
      on logueo.codigorol=rol.codigorol WHERE usernameusu='$username2' and contrausu='$contra2'");
                        $cantusu = mysqli_num_rows($sqlu);

                        //para el repartidor
                        $sqlre = mysqli_query($mysqli, "SELECT * FROM logueo_repartidor INNER JOIN rol 
on logueo_repartidor.codigorol=rol.codigorol 
WHERE logueo_repartidor.username_repartidor='$username2' and logueo_repartidor.contrase_repartidor='$contra2'");
                        if (isset($_COOKIE["blocke" . $username2])) {
                            echo "<div class='alert alert-danger' role='alert'>$nombreusuario ha sido bloqueado.</div>";
                        } else {
                            if ($cantusu > 0) {
                                //echo '<div class="alert alert-danger" role="alert">Cliente</div>';
                                if ($use = mysqli_fetch_assoc($sqlu)) {
                                    $apelliuse = sed::encryption($use['apellidousu']);
                                    $baneado = $use['baneo'];
                                    $idlogus = $use['idusu'];
                                    if ($contrase == sed::decryption($use['contrausu'])) {
                                        if ($use['baneo'] == 2) { //si está baneado
                                            echo "<div class='alert alert-danger' role='alert'>$nombreusuario su cuenta ha sido inhabilitada.</div>";
                                        } else { }
                                    } else {
                                        echo "<div class='alert alert-danger' role='alert'>$nombreusuario su contraseña es incorrecta.</div>";
                                    }
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>No existe el usuario.</div>";
                                }
                                //echo "<script>location.href='registro.php'</script>";
                            } elseif ($cantadmin > 0) {
                                //echo '<div class="alert alert-danger" role="alert">Administrador</div>';
                                if ($us2 = mysqli_fetch_assoc($sqladm)) { //verificamo si $f2 que es una variable cualquiera que obtenga los datos de la consulta $sql2
                                    //my_fetch_assoc();->Devuelve una matriz asociativa que corresponde a la fila recuperada y mueve el apuntador de datos interno hacia adelante.
                                    if ($contrase == sed::decryption($us2['contraadmin'])) { //si $f2 encuentra que el username es igual al pasadmin o la $pass quiere decir que es el administrador que se esta autentificando en el login
                                        if ($us2['baneo'] == 2) { //si está baneado$_SESSION['idusu'] = $us2['idusu'];
                                            echo "<div class='alert alert-danger' role='alert'>$nombreusuario su cuenta ha sido inhabilitada.</div>";
                                        } else { }
                                    } else {
                                        echo "<div class='alert alert-danger' role='alert'>$nombreusuario su contraseña es incorrecta.</div>";
                                    }
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>No existe el administrador.</div>";
                                }
                            } elseif ($cante > 0) {
                                if ($empre = mysqli_fetch_assoc($sqle)) {
                                    if ($contrase == sed::decryption($empre['contrase_empresa'])) {
                                        if ($empre['estado'] == 2) { //si está baneado
                                            echo "<div class='alert alert-danger' role='alert'>$nombreusuario su cuenta ha sido inhabilitada.</div>";
                                        } else { }
                                    } else {
                                        echo "<div class='alert alert-danger' role='alert'>$nombreusuario su contraseña es incorrecta.</div>";
                                    }
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>No existe la empresa.</div>";
                                }
                            } elseif ($cantrepar > 0) {
                                if ($repartidor = mysqli_fetch_assoc($sqlre)) {
                                    if ($repartidor['baneo'] == 1) { //si está baneado
                                        echo "<div class='alert alert-danger' role='alert'>$nombreusuario su cuenta ha sido inhabilitada.</div>";
                                    } else {
                                        if ($contrase == sed::decryption($repartidor['contrase_repartidor'])) { } else {
                                            echo "<div class='alert alert-danger' role='alert'>$nombreusuario su contraseña es incorrecto.</div>";
                                        }
                                    }
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>$nombreusuario no existe repartidor.</div>";
                                }
                            } else {
                                echo '<div class="alert alert-danger" role="alert">Nombre de usuario incorrecto</div>';
                            }
                        }
                    }
                    if (isset($_COOKIE["cerrarsesion"])) {
                        echo "<div class='alert alert-danger' role='alert'> Se detecto 4 minuto de inactividad. Inicia sesión nuevamente</div>";
                    }
                    ?>
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
                            $('#usernam').on('input change', function() { //El boton se habilita cuando se escribe el formulario nombre
                                if ($(this).val() != '') {
                                    $('#entrar').prop('disabled', false);
                                } else {
                                    $('#entrar').prop('disabled', true);
                                }
                            });
                            //CheckBox mostrar contraseña
                            $('#ShowPassword').click(function() {
                                $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</body>

</html>