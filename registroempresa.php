<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Regístrate | RestaurantApp</title>
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
    <nav style="width: 100%; height: 50px;" class="fixed-top bg-primary">
        <div class="">
            <a class="" href="registrarme.php">
                <img src="img/atras.png" style="width: 30px; height: 40px;">
            </a>
            <a class="" style="font-size: 22px; margin-top: 12px; color:white;">
                <img src="img/logo.png" style="width: 35px; height: 34px;" alt="logo restaurantapp">
                <strong>RestaurantApp</strong>
            </a>
        </div>
    </nav><br><br>
    <div style="margin-top:8px;max-width: 620px; border-radius: 16px;" class="container container--flex">
        <div class="panel panel-info" style="background-color: rgba(0, 0, 0, 0.575);">
            <div class="panel-heading" style="background-color:blue;">
                <center>
                    <div class="panel-title" style="color:white;">REG&Iacute;STRATE</div>
                </center>
            </div>
            <div style="padding:6px;" class="panel-body">
                <form class="formulario column" enctype="multipart/form-data" action="" method="post">
                    <div class="row g-3">
                        <div class="col">
                            <label for="" style="color:white;" class="formulario__label">Imagen : </label>
                            <input type="file" class="form-control" name="imagen" required="required">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col">
                            <label style="height: 14px; color:#fff;">Empresa:</label>
                            <input style="height:12x;" type="text" name="nombre" class="form-control" placeholder="Ingrese nombre de la empresa" required />
                        </div>
                        <div class="col">
                            <label style="height:14x; color: #fff;">Username:</label>
                            <input type="text" name="username" class="form-control" placeholder="Ingrese nombre de usuario" required>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col">
                            <label style="height:14x; color: #fff;">Email:</label>
                            <input type="email" style="height:14x;" name="emai" style="height:14px;" class="form-control" required placeholder="Ingrese el correo de la empresa" />
                        </div>

                    </div>
                    <div class="row g-3">
                        <div class="col">
                            <label for="" style="color:white;" class="formulario__label"><strong>Ciudad: </strong></label>
                            <select id="ciudad" required="required" name="ciudad" class="form-control">
                                <option value="-" selected="">Seleccione su ciudad</option>
                                <?php
                                require("conexion.php");
                                include 'sed.php';
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
                        <div class="col">
                            <label for="" style="height:14x; color: #fff;">Celular:</label>
                            <input style="height:14x;" type="number" class="form-control" name="celular" required="required" placeholder="Ejemplo: 912345678">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col">
                            <label style="height:14x; color: #fff;">Dirección:</label>
                            <input type="text" style="height:14x;" name="direccion" require style="height:14px;" class="form-control" placeholder="Ingrese direccion de la empresa" />
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col">
                            <label style="height:14x; color: #fff;">Contraseña:</label>
                            <div class="input-group">
                                <input type="password" style="height:14x;" name="pass" ID="txtPassword1" class="form-control" required placeholder="Ingresa contraseña" />
                                <div class="input-group-append">
                                    <button id="show_password1" class="btn btn-primary" type="button" onclick="mostrarPassword1()"> <span class="fa fa-eye-slash icon"></span> </button>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <label style="height:14x; color:#fff;">Repite tu contraseña:</label>
                            <div class="input-group">
                                <input type="password" style="height:14x;" name="rpass" ID="txtPassword" class="form-control" required placeholder="repite contraseña" />
                                <div class="input-group-append">
                                    <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="g-recaptcha" style="margin-top: 8px;" data-sitekey="6Lf4uRsiAAAAADArr8A8rRUlnK6HFQb9bZXfbKLF"></div>

                    <a style="font-size: 18px; color:#fff; margin-top: 5px;">
                        <input type="radio" name="politica" value="Aceptado"> Acepto los
                        <a style="font-size: 20px;" href="politicaprivacidad.php?priv=1"> Términos y condiciones</a><br>
                    </a>
                    <center>
                        <input class="btn btn-warning" id="entrar" style="width: 100px; height: 40px; border-radius: 16px; background-color: orange; color: white;" type="submit" name="registro" value="Registrarse">
                    </center>
                </form>
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
                <?php
                if (isset($_POST['registro'])) {
                    require("regisempresa.php");
                }
                ?>
            </div>
        </div>
        <!-------------------------------------------------------------------->
    </div>
</body>

</html>