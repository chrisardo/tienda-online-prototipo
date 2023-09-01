<?php
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
<br><br>
<div style="margin-top:8px;max-width: 620px; border-radius: 16px;" class="container container--flex">
    <div class="panel panel-info" style="background-color: rgba(0, 0, 0, 0.575);">
        <div class="panel-heading" style="background-color:blue;">
            <center>
                <div class="panel-title" style="color:white;">Regstrar repartidor</div>
            </center>
        </div>
        <div style="padding:6px;" class="panel-body">
            <form class="formulario column" enctype="multipart/form-data" action="" method="post">
                <div class="row g-3">
                    <div class="col">
                        <label style="height: 14px; color:#fff;">Nombre:</label>
                        <input style="height:12x;" type="text" name="nombre" class="form-control" required />

                    </div>
                    <div class="col">
                        <label style="height: 14px; color:#fff;">Apellidos:</label>
                        <input style="height:12x;" type="text" name="apellido" class="form-control" required placeholder="" />
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col">
                        <label style="height:14x; color: #fff;">Email:</label>
                        <input type="email" style="height:14x;" name="emai" style="height:14px;" class="form-control" required placeholder="" />
                    </div>
                    <div class="col">
                        <label style="height:14x; color: #fff;">Username:</label>
                        <input type="text" style="height:14x;" name="username" require style="height:14px;" class="form-control" placeholder="" />
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col">
                        <label for="" style="height:14x; color: #fff;">Celular:</label>
                        <input style="height:14x;" type="number" class="form-control" name="celular" required="required" placeholder="Ejemplo: 912345678">
                    </div>
                    <div class="col">
                        <label for="" style="color:white;" class="formulario__label"><strong>Ciudad: </strong></label>
                        <select id="ciudad" required="required" name="ciudad" class="form-control">
                            <option value="-" selected="">Seleccione su ciudad</option>
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
                        <label for="" style="height:14x; color: #fff;">Rol:</label>
                        <select id="rol" name="rol" class="form-control">
                            <option value="-" selected="">Seleccione rol</option>
                            <?php
                            $sqlrol = "SELECT * FROM rol group by rol ORDER BY idrol DESC";
                            $resultadorol = mysqli_query($conexion, $sqlrol);
                            $roles = mysqli_fetch_all($resultadorol, MYSQLI_ASSOC);
                            foreach ($roles as $rowrol) {
                                $idrol = sed::decryption($rowrol['idrol']);
                                echo '<option value="' . $rowrol['codigorol'] . '">' . sed::decryption($rowrol['rol']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <label for="" style="height:14x; color: #fff;">Género:</label>
                        <select id="gener" name="genero" class="form-control">
                            <option value="-" selected="">Seleccione su genero</option>
                            <option value="Hombre">Masculino</option>
                            <option value="Mujer">Femenino</option>
                        </select>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col">
                        <label for="" style="height:14x; color: #fff;">Edad:</label>
                        <input style="height:14x;" type="numbr" class="form-control" name="edad" required="required" placeholder="Ejemplo: 23">
                    </div>
                    <div class="col">
                        <label style="height:14x; color: #fff;">Contraseña:</label>
                        <div class="input-group">
                            <input type="password" style="height:14x;" name="pass" ID="txtPassword1" class="form-control" required placeholder="Ingresa contraseña" />
                            <div class="input-group-append">
                                <button id="show_password1" class="btn btn-primary" type="button" onclick="mostrarPassword1()"> <span class="fa fa-eye-slash icon"></span> </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col">
                        <label for="" style="height:14x; color: #fff;">Dirección:</label>
                        <input style="height:14x;" type="text" class="form-control" name="direccion" required="required" placeholder="">
                    </div>
                </div>
                <center>
                    <input class="btn btn-warning" id="entrar" style="width: 30%; height: 40px; border-radius: 16px; background-color: orange; color: white; margin-top:6px;" type="submit" name="registro" value="Registrar">
                </center>
            </form>
            <?php
            if (isset($_POST['registro'])) {
                $nombreuser = $_POST['nombre'];
                $apellidouser = $_POST['apellido'];
                $mail = $_POST['emai'];
                $nombreusuario = $_POST['username'];
                $celular = $_POST['celular'];
                $ciudaduse = $_POST['ciudad'];
                $codrol = $_POST['rol'];
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
                                echo '<div class="alert alert-danger" role="alert">
                                            Atencion, ya existe el email y/o username designado para un usuario, verifique sus datos.
                                          </div>';
                                //echo "<script>location.href='registro.php'</script>";
                            } else {
                                $qlogueo = "INSERT INTO logueo_repartidor 
                                    (nombre_repartidor, apellido_repartidor, username_repartidor,contrase_repartidor, correo_repartidor, codigorol, edad_repartidor, fecharegistro_repartidor, genero_repartidor,celular_repartidor, direcci_repartidor, baneo, codciudad) 
                                    VALUES('$nombree', '$apellidoe', '$nombreusuarioe','$clavee','$maile','$codrol', '$edade_r', now(),'$generousue','$celular', '$direccione_r', '0', '$ciudaduse')";
                                $resultlogueo = $mysqli->query($qlogueo);
                                if ($resultlogueo) {
                                    echo '<div class="alert alert-primary" role="alert">Empleado registrado. </div>';
                                    //echo "<script>location.href='logueo.php'</script>";
                                } else {
                                    echo '<div class="alert alert-danger" role="alert"> Hubo problemas al insertar los datos del logueo </div>';
                                    echo "Error: " . $query . "<br>" . mysqli_error($mysqli);
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