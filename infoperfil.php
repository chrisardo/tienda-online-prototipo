<?php
//validar
session_start();
if (@!$_SESSION['idusu']) {
    echo "<script>location.href='logueo.php'</script>";
} elseif ($_SESSION['rolusu'] == "user" || $_SESSION['rolusu'] == "a1" || $_SESSION['rolusu'] == "empresa") {
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
    <title>Información básica| RestaurantApp</title>
    <link rel="icon" href='img/logo.png' sizes="32x32" type="img/jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css2/style.css" />
    <script src="js/jquery-3.2.1.js"></script>
    <script src="js/script.js"></script>

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
        <h2 style="color:blue;"><strong>Información básica</strong></h2>
    </center>
    <?php
    extract($_GET);
    require("connectdb.php");
    include 'sed.php';
    $id = $_SESSION['idusu'];
    $sql = ("SELECT * FROM logueo WHERE idusu='$id'");
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
    $sqlci = "SELECT * FROM ciudad where codciudad ='$codciud' group by ciudad ORDER BY idciudad DESC";
    $resultadoci = mysqli_query($mysqli, $sqlci);
    $ciud = mysqli_fetch_all($resultadoci, MYSQLI_ASSOC);
    foreach ($ciud as $rowciu) {
        $codciuda = $rowciu['codciudad'];
        $nombreciuda = sed::decryption($rowciu['ciudad']);
    }
    ?>
    <div class="container">
        <div class="container " style="background-color:orange; ">
            <form action="" method="post">
                <!--id="form-login"-->
                <div class="row g-3">
                    <div class="col">
                        <input type="hidden" class="form-control" name="id" value="<?php echo $id; ?>">
                        <label for="" style="color:white;" class="formulario__label"><strong>Nombre: </strong></label>
                        <input type="text" class="form-control" name="nombre" value="<?php echo $nombre; ?>">
                    </div>
                    <div class="col">
                        <label for="" style="color:white;" class="formulario__label"><strong>Apellido:</strong></label>
                        <input type="text" class="form-control" name="apellido" value="<?php echo $apellido; ?>">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col">
                        <label for="" style="color:white;" class="formulario__label"><strong>Username:</strong> </label>
                        <input type="text" class="form-control" name="username" value="<?php echo $usename; ?>">
                    </div>
                    <div class="col">
                        <label for="" style="color:white;" class="formulario__label"><strong>Celular: </strong></label>
                        <input type="number" class="form-control" name="celular" value="<?php echo $celular; ?>">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col">
                        <label for="" style="color:white;" class="formulario__label"><strong>Fecha de nacimiento: </strong></label>
                        <input type="date" class="form-control" name="fe_nacimiento" value="<?php echo $f_nacimiento; ?>">
                    </div>
                    <div class="col">
                        <label for="" style="color:white;" class="formulario__label"><strong>Genero: </strong></label>
                        <select id="gener" name="genero" class="form-control">
                            <option value="<?php echo $gener; ?>" selected="<?php echo $gener; ?>"><?php echo $gener; ?></option>
                            <option value="Hombre">Masculino</option>
                            <option value="Mujer">Femenino</option>
                        </select>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col">
                        <label for="" style="color:white;" class="formulario__label"><strong>Ciudad: </strong></label>
                        <select id="ciudad" required="required" name="ciudad" class="form-control">

                            <option value="<?php if (!empty($rowciu['codciudad'])) {
                                                    echo $rowciu['codciudad'];
                                                } ?>" selected="<?php if (!empty($rowciu['codciudad'])) {
                                                                    echo sed::decryption($rowciu['ciudad']);
                                                                } ?>"><?php if (!empty($rowciu['codciudad'])) {
                                                                            echo sed::decryption($rowciu['ciudad']);
                                                                        } else {
                                                                            echo "Se eliminó la ciudad";
                                                                        } ?></option>
                            <?php
                            $sqlc = "SELECT * FROM ciudad group by ciudad ORDER BY idciudad DESC";
                            $resultadoc = mysqli_query($mysqli, $sqlc);
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
                <center>
                    <input type="submit" id="boton" name="edit_infor" value="Editar" class="btn btn-primary" style="width:150px; margin-top: 16px;">
                    <!--<button type="button" id="entrar" style="color: white; margin-top: 4px;" class="btn btn-primary g-recaptcha">Cambiar</button>-->
                </center>
            </form>
            <script>
                if ($('#boton').val() != "boton")
                    $('#boton').attr("disabled", false);
                else
                    $('#boton').attr("disabled", true);
            </script>
            <?php
            require("connectdb.php"); //requerir la conexion a la base de datos
            if (isset($_POST['edit_infor'])) {
                /*if (!empty($_POST['token']) && !empty($_POST['action'])) {
                $token = $_POST['token'];
                $action = $_POST['action'];
                $secret = '6LdaxhsiAAAAAC160Xum7car1OsGqy5F4xX9oddv'; // Ingresa tu clave secreta.....

                @$response2 = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$token");
                $datos = json_decode($response2, true);*/
                $id_session = $_SESSION['idusu'];
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $usname = $_POST['username'];
                $celu = $_POST['celular'];
                $ciudaduse = $_POST['ciudad'];
                $fechanacimiento = $_POST['fe_nacimiento'];
                $generous = $_POST['genero'];
                $celular = "51" . $celu;
                $nombreus = sed::encryption($nombre);
                $apellidoe = sed::encryption($apellido);
                $user_nam = sed::encryption($usname);
                $generoe = sed::encryption($generous);
                function calculaedad($fechanacimiento)
                {
                    list($ano, $mes, $dia) = explode("-",  $fechanacimiento);
                    $ano_diferencia  = date("Y") - $ano;
                    $mes_diferencia = date("m") - $mes;
                    $dia_diferencia   = date("d") - $dia;
                    if ($dia_diferencia < 0 || $mes_diferencia < 0)
                        $ano_diferencia--;
                    return $ano_diferencia;
                }
                $edadusuario = calculaedad($fechanacimiento);
                if (!empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['username']) && !empty($_POST['fe_nacimiento']) && !empty($_POST['genero'])) {
                    if ($edadusuario >= 17) {
                        if ($celular <= 51999999999 && $celular >= 51900000000) {
                            echo '<div class="alert alert-primary" role="alert">Actualizado con éxito. </div>';
                            $resul = mysqli_query($mysqli, "UPDATE logueo  
                        SET logueo.nombreusu = '$nombreus', logueo.apellidousu='$apellidoe',logueo.usernameusu= '$user_nam',logueo.celularusu= '$celu',
                        logueo.fechanaci = '$fechanacimiento', logueo.generousu= '$generoe', codciudad='$ciudaduse'
                        WHERE logueo.idusu='$id_session'");
                            if (@$resul) {
                                echo "<script>location.href='infoperfil.php'</script>";
                            } else {
                                echo '<div class="alert alert-danger" role="alert"> Hubo problemas al insertar los datos del logueo </div>';
                                echo "Error: " . $resul . "<br>" . mysqli_error($mysqli);
                            }
                        } else {
                            echo '<div class="alert alert-danger" role="alert">El numero de celular tiene que ser de 9. </div>';
                        }
                    } else if ($edadusuario < 17) {
                        echo '<div class="alert alert-danger" role="alert">Menores de 17 años no pueden registrarse.</div>';
                        //echo "<script>location.href='registro.php'</script>";
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