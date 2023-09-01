<?php
//validar
session_start();
if (@!$_SESSION['idusu']) {
    echo "<script>location.href='logueo.php'</script>";
} elseif ($_SESSION['rolusu'] == "a1" || $_SESSION['rolusu'] == "empresa") {
    /*¡if ((time() - $_SESSION['last_login_timestamp']) > 240) { // 900 = 15 * 60  
        setcookie("cerrarsesion", 1, time() + 60000); //6o segundos es 1 minuto, 86400 segundos es por 24 horas
        echo "<script>location.href='desconectar.php'</script>";
    } else {
        $_SESSION['last_login_timestamp'] = time();
    }*/ } else {
    echo "<script>location.href='logueo.php'</script>";
}
//include 'sed.php';
?>
<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar | RestaurantApp</title>
    <link rel="icon" href='img/logo.png' sizes="32x32" type="img/jpg">
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css2/style.css" />
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
    <?php
    include 'sed.php';
    require("connectdb.php");
    require("conexion.php");
    $idlog = @$_SESSION['idusu'];
    extract($_GET);
    $sqlr = "SELECT * FROM logueo_repartidor WHERE id_repartidor=$id";
    //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
    $resultado_r = mysqli_query($conexion, $sqlr);
    $reparti = mysqli_fetch_all($resultado_r, MYSQLI_ASSOC);
    foreach ($reparti as $rowr) {
        $codciud = $rowr['codciudad'];
    }
    $sqlci = "SELECT * FROM ciudad where codciudad ='$codciud' group by ciudad ORDER BY idciudad DESC";
    $resultadoci = mysqli_query($conexion, $sqlci);
    $ciud = mysqli_fetch_all($resultadoci, MYSQLI_ASSOC);
    foreach ($ciud as $rowciu) {
        $codciuda = $rowciu['codciudad'];
        $nombreciuda = sed::decryption($rowciu['ciudad']);
    }
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
        <div class="container-fluid">
            <a class="" href="adm.php?verrepartidor=1">
                <img src="img/atras.png" style="width: 30px; height: 40px;">
            </a>
            <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 15px;" href="#">
                <img src="img/logo.png" style="width: 30px; height: 30px;" alt="logo restaurantapp">
                <strong>Perikos's</strong>
            </a>
        </div>
    </nav><br><br><br>
    <div style="margin-top:8px;max-width: 620px; border-radius: 16px;" class="container container--flex">
        <div class="panel panel-info" style="background-color: rgba(0, 0, 0, 0.575);">
            <div class="panel-heading" style="background-color:blue;">
                <center>
                    <div class="panel-title" style="color:white;">Editar repartidor</div>
                </center>
            </div>
            <div style="padding:6px;" class="panel-body">
                <form class="formulario column" enctype="multipart/form-data" action="" method="post">
                    <div class="row g-3">
                        <div class="col">
                            <label style="height: 14px; color:#fff;">Nombre:</label>
                            <input type="text" name="nombre" value="<?php echo sed::decryption($rowr['nombre_repartidor']); ?>" style="height:12x;" class="form-control" required />
                        </div>
                        <div class="col">
                            <label style="height: 14px; color:#fff;">Apellidos:</label>
                            <input style="height:12x;" type="text" name="apellido" value="<?php echo sed::decryption($rowr['apellido_repartidor']); ?>" class="form-control" required placeholder="" />
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col">
                            <label style="height:14x; color: #fff;">Email:</label>
                            <input type="email" name="emai" value="<?php echo sed::decryption($rowr['correo_repartidor']); ?>" style="height:14x;" style="height:14px;" class="form-control" required />
                        </div>
                        <div class="col">
                            <label style="height:14x; color: #fff;">Username:</label>
                            <input type="text" value="<?php echo sed::decryption($rowr['username_repartidor']); ?>" style="height:14x;" name="username" require style="height:14px;" class="form-control" />
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col">
                            <label for="" style="height:14x; color: #fff;">Celular:</label>
                            <input style="height:14x;" value="<?php echo $rowr['celular_repartidor']; ?>" type="number" class="form-control" name="celular" required="required">
                        </div>
                        <div class="col">
                            <label for="" style="color:white;" class="formulario__label"><strong>Ciudad: </strong></label>
                            <select id="ciudad" required="required" name="ciudad" class="form-control">

                                <option value="<?php if (!empty($rowciu['codciudad'])) {
                                                    echo $rowciu['codciudad'];
                                                } ?>" selected="<?php if (!empty($rowciu['codciudad'])) {
                                                                    echo sed::decryption($rowciu['ciudad']);
                                                                } ?>"><?php if (!empty($rowciu['codciudad'])) {
                                                                                                                                                            echo sed::decryption($rowciu['ciudad']);
                                                                                                                                                        }else{echo "Se eliminó la ciudad";} ?></option>
                                <?php
                                $sqlc = "SELECT * FROM ciudad group by ciudad ORDER BY idciudad DESC";
                                $resultadoc = mysqli_query($conexion, $sqlc);
                                $ciuda = mysqli_fetch_all($resultadoc, MYSQLI_ASSOC);
                                foreach ($ciuda as $rowci) {
                                    $codciudad = $rowci['codciudad'];
                                    $nombreciudad = sed::decryption($rowci['ciudad']);
                                    echo '<option value="' . $codciudad . '">' . $nombreciudad . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col">
                            <label for="" style="height:14x; color: #fff;">Edad:</label>
                            <input style="height:14x;" type="number" value="<?php echo sed::decryption($rowr['edad_repartidor']); ?>" class="form-control" name="edad" required="required">
                        </div>
                        <div class="col">
                            <label style="height:14x; color: #fff;">Contraseña:</label>
                            <div class="input-group">
                                <input type="password" value="<?php echo sed::decryption($rowr['contrase_repartidor']); ?>" style="height:14x;" name="pass" ID="txtPassword1" class="form-control" required />
                                <div class="input-group-append">
                                    <button id="show_password1" class="btn btn-primary" type="button" onclick="mostrarPassword1()"> <span class="fa fa-eye-slash icon"></span> </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col">
                            <label for="" style="color:white;" class="formulario__label"><strong>Genero: </strong></label>
                            <select id="gener" name="genero" class="form-control">
                                <option value="<?php echo sed::decryption($rowr['genero_repartidor']); ?>" selected="<?php echo sed::decryption($rowr['genero_repartidor']); ?>"><?php echo sed::decryption($rowr['genero_repartidor']); ?></option>
                                <option value="Hombre">Masculino</option>
                                <option value="Mujer">Femenino</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="" style="color:white;" class="formulario__label"><strong>Estado: </strong></label>
                            <select id="estado" name="estado" class="form-control">
                                <option value="<?php echo $rowr['baneo']; ?>" selected="<?php echo $rowr['baneo']; ?>">
                                    <?php if ($rowr['baneo'] == 0) {
                                        echo "Activo";
                                    } else if ($rowr['baneo'] == 1) {
                                        echo "baneado";
                                    } ?></option>
                                <option value="0">Habilitar</option>
                                <option value="1">Banear</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col">
                            <label for="" style="height:14x; color: #fff;">Dirección:</label>
                            <input type="text" value="<?php echo sed::decryption($rowr['direcci_repartidor']); ?>" class="form-control" name="direccion" style="height:14x;" required="required">
                        </div>
                    </div>
                    <center>
                        <input class="btn btn-warning" id="entrar" style="width: 30%; height: 40px; border-radius: 16px; background-color: orange; color: white; margin-top:6px;" type="submit" name="editar" value="Actualizar">
                    </center>
                </form>
                <?php
                if (isset($_POST['editar'])) {
                    $nombreuser = $_POST['nombre'];
                    $apellidouser = $_POST['apellido'];
                    $mail = $_POST['emai'];
                    $nombreusuario = $_POST['username'];
                    $celular = $_POST['celular'];
                    $ciudaduse = $_POST['ciudad'];
                    $estador = $_POST['estado'];
                    $generouse = $_POST['genero'];
                    $edad_r = $_POST['edad'];
                    $pass_r = $_POST['pass'];
                    $direccion_r = $_POST['direccion'];
                    if (!empty($nombreuser) && !empty($apellidouser) && !empty($mail) && !empty($nombreusuario) && $celular > 0 && !empty($pass_r) && !empty($direccion_r)) {
                        $nombree = sed::encryption($nombreuser);
                        $apellidoe = sed::encryption($apellidouser);
                        $maile = sed::encryption($mail);
                        $nombreusuarioe = sed::encryption($nombreusuario);
                        $celularp = "51" . $celular;
                        $generousue = sed::encryption($generouse);
                        $edade_r = sed::encryption($edad_r);
                        $clavee = sed::encryption($pass_r);
                        $direccione_r = sed::encryption($direccion_r);
                        if ($celularp <= 51999999999 && $celularp >= 51900000000) {
                            if ($edad_r >= 17) {
                                $checkemail = mysqli_query($mysqli, "SELECT * FROM logueo_repartidor WHERE correo_repartidor='$maile'or username_repartidor='$nombreusuarioe'");
                                $check_mail = mysqli_num_rows($checkemail);
                                if ($check_mail > 0) {
                                    $query_r = "UPDATE logueo_repartidor  
                                    SET nombre_repartidor = '$nombree', apellido_repartidor='$apellidoe', contrase_repartidor='$clavee', edad_repartidor='$edade_r',
                                    genero_repartidor='$generousue',celular_repartidor= '$celular',
                                    direcci_repartidor='$direccione_r', baneo='$estador', codciudad='$ciudaduse'
                                    WHERE id_repartidor='$id'";
                                    $resultado_r = mysqli_query($mysqli, $query_r);
                                    if ($resultado_r) {
                                        echo '<div class="alert alert-primary" role="alert">Datos actualizados.</div>';
                                        echo "<script>location.href='admeditrepartidor.php?id=$id'</script>";
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert"> Hubo problemas al insertar los datos del logueo </div>';
                                        echo "Error: " . $query_r . "<br>" . mysqli_error($mysqli);
                                        //echo "<script>location.href='registro.php'</script>";
                                    }
                                    //echo "<script>location.href='registro.php'</script>";
                                } else {
                                    $query_r = "UPDATE logueo_repartidor  
                                    SET nombre_repartidor = '$nombree', apellido_repartidor='$apellidoe', username_repartidor= '$nombreusuarioe', contrase_repartidor='$clavee', correo_repartidor='$maile',edad_repartidor='$edade_r',
                                    genero_repartidor='$generousue',celular_repartidor= '$celular',
                                    direcci_repartidor='$direccione_r', baneo='$estador'
                                    WHERE id_repartidor='$id'";
                                    $resultado_r = mysqli_query($mysqli, $query_r);
                                    if ($resultado_r) {
                                        echo '<div class="alert alert-primary" role="alert">Datos actualizados. </div>';
                                        echo "<script>location.href='admeditrepartidor.php?id=$id'</script>";
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert"> Hubo problemas al insertar los datos del logueo </div>';
                                        echo "Error: " . $query_r . "<br>" . mysqli_error($mysqli);
                                        //echo "<script>location.href='registro.php'</script>";
                                    }
                                }
                            } else if ($edad_r < 17) {
                                echo '<div class="alert alert-danger" role="alert">
                                Usuarios menores de 17 años no pueden registrarse.
                                </div>';
                                //echo "<script>location.href='registro.php'</script>";
                            }
                        } else {
                            echo '<div class="alert alert-danger" role="alert">
                            El numero de celular tiene que ser de 9.
                            </div>';
                            //echo "<script>location.href='registro.php'</script>";
                        }
                    } else {
                        echo '<div class="alert alert-danger" role="alert">
                        Te faltan datos por completar.
                        </div>';
                        //echo "<script>location.href='registro.php'</script>";
                    }
                }
                ?>
                <!--<div class="form-group">
                    <div class="col-md-12 control">
                        <div style="border-top: 1px solid#888; padding-top:5px; color:#fff; font-size:85%">
                            Ya tienes una cuenta? <a href="logueo.php" style="color: orangered;">Ir a iniciar sesión</a>
                        </div>
                    </div>
                </div>-->
                <script>
                    $(document).ready(function() {
                        $('#entrar').click(function() { //Se desabilita al darle click al boton
                            if ($(this).val() != '') {
                                $('#entrar').prop('disabled', false);
                            } else {
                                $('#entrar').prop('disabled', true);
                            }
                        });
                    });

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
            </div>
        </div>
        <!-------------------------------------------------------------------->
    </div>
</body>

</html>