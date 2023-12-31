<?php
session_start();
if (@$_SESSION['rolusu'] == "user") { //sino si la session rol no esta 
    /*if ((time() - $_SESSION['last_login_timestamp']) > 1240) { // 900 = 15 * 60  
    setcookie("cerrarsesion", 1, time() + 860000); //6o segundos es 1 minuto, 86400 segundos es por 24 horas
    echo "<script>location.href='desconectar.php'</script>";
  } else {
    $_SESSION['last_login_timestamp'] = time();
  }*/
}
extract($_GET);
?>
<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?php if (!@empty($productos == 1)) { ?>
        PRODUCTOS
        <?php } else if (!@empty($vereservas == 1)) { ?>
        ORDENES
        <?php } else if (!@empty($index == 1)) { ?>
        INICIO
        <?php } ?>
        | Tienda Only</title>
    <link rel="icon" href='img/ilogo.png' sizes="32x32" type="img/jpg">

    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css2/style.css" />
    <?php if (!@empty($productos == 1)) { ?>
    <link rel="stylesheet" href="css2/invitado.css">
    <link rel="stylesheet" href="css/estilosgaleria.css">
    <!--<link rel="stylesheet" href="css/contact.css">-->
    <?php } ?>
    <?php ?>
</head>

<body>
    <?php
    //require("connectdb.php");
    include("controlador/conexion.php");
    include 'sed.php';
    $idlog = @$_SESSION['idusu'];
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 13px;" href="#">
                <img src="img/ilogo.png" style="width: 30px; height: 40px;" alt="logo RestaurantApp">
                <strong></strong>
            </a>
            <button style="border:2px solid white;" class="navbar-toggler align-self-start" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse bg-primary p-3 p-lg-0 mt-5 mt-lg-0 d-flex flex-column flex-lg-row flex-xl-row justify-content-lg-end mobileMenu"
                id="navbarSupportedContent">
                <ul class="navbar-nav align-self-stretch" style="margin-right: 30px;">
                    <li class="nav-item ">
                        <a class="nav-link <?php if (!@empty($index == 1)) { ?>active<?php } ?>" href="?index=1">
                            <img src="img/inicio.png" style="width: 26px; height: 22px;"><strong>INICIO</strong></a>
                    </li>
                    <div class="dropdown-divider"></div>
                    <li class="nav-item">
                        <a class="nav-link <?php if (!@empty($productos == 1)) { ?>active<?php } ?>"
                            href="?productos=1">
                            <img src="img/producto.png" style="width: 26px; height: 22px;">
                            <strong>PRODUCTOS</strong></a>
                    </li>
                    <div class="dropdown-divider"></div>
                    <li class="nav-item">
                        <a class="nav-link <?php if (!@empty($vereservas == 1)) { ?>active<?php } ?>"
                            href="?vereservas=1">
                            <img src="img/ordenes.png" style="width: 24px; height: 20px;"><strong> MIS
                                ORDENES</strong></a>
                    </li>
                </ul>
            </div>
            <a class="navbar-brand order-1 order-justify-content-end" style="margin-left: 14px;" href="buscador.php">
                <img src="img/buscar.png" style="width: 36px; height: 40px;" alt="login">
            </a>
            <a href="carrito.php" style="margin-left: 4px;" class="navbar-brand order-1 order-justify-content-end">
                <img src="img/carrito.png" style="width: 36px; height: 40px;" alt="carrito">
                <?php
                $querycat = "SELECT*FROM carrito where idusu='$idlog' and estadocarrito ='1'";
                $resultcat = mysqli_query($conexion, $querycat);
                $catego = mysqli_fetch_all($resultcat, MYSQLI_ASSOC);
                $cantcarrito = mysqli_num_rows($resultcat);
                ?>
                <strong style="font-size: 14px;"> <?php
                                                    echo "(" . $cantcarrito . ")";
                                                    ?></strong>

            </a>
            <?php
            $consulta = ("SELECT * FROM logueo  WHERE logueo.idusu='$idlog'");
            $query1 = mysqli_query($conexion, $consulta);
            $persona = mysqli_fetch_all($query1, MYSQLI_ASSOC);
            foreach ($persona as $array) {
                $imagperfi = base64_encode($array['imagperfil']);
                $nom = sed::decryption($array["nombreusu"]);
                $apelli = sed::decryption($array["apellidousu"]);
            }
            ?>
            <?php
            if (@!$_SESSION['idusu']) { //si la session del usuario esta vacia
                //El @ oculta los mensajes de error que pueda salir
            } else if ($_SESSION['rolusu'] == "user") { //sino si la session rol no esta vacia
            ?>
            <a style="margin-left: 4px;" href="" class="navbar-brand order-1 order-justify-content-end">
                <?php
                    if ($imagperfi) {
                    ?>
                <img src="data:image/jpg;base64, <?php echo $imagperfi; ?>"
                    style="width: 36px; height: 40px; border-radius: 14px;" alt="login">
                <?php
                    } else {
                    ?>
                <img src="img/fotoperfil.png" style="width: 40px; height: 40px;" alt="login">
                <?php
                    }
                    ?>
            </a>
            <?php
            }
            ?>
            <div style="margin-left: 1px;" class="navbar-brand order-1 order-justify-content-end dropdown show"
                id="yui_3_17_2_1_1636218170770_38">
                <a href="#" tabindex="0" class=" dropdown-toggle" style="color: white;" id="action-menu-toggle-1"
                    aria-label="Menú de usuario" data-toggle="dropdown" role="button" aria-haspopup="true"
                    aria-expanded="true" aria-controls="action-menu-1-menu">
                    <b class="caret"></b>
                </a>
                <div class="dropdown-menu dropdown-menu-right menu align-tr-br" id="action-menu-1-menu"
                    data-rel="menu-content" aria-labelledby="action-menu-toggle-1" role="menu" data-align="tr-br">
                    <a href="opciones.php" class="dropdown-item menu-action select" role="menuitem"
                        data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                        <img src="img/opcione.png" style="width: 26px; height: 22px;"><strong>MÁS OPCIONES</strong>
                    </a>
                    <?php
                    if (@!$_SESSION['idusu']) { //si la session del usuario esta vacia
                    ?>
                    <div class="dropdown-divider border-primary" style="background-color:blue;"></div>
                    <a href="logueo.php" class="dropdown-item menu-action select" role="menuitem"
                        data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                        <img src="img/login.png" style="width: 26px; height: 22px;"><strong>LOGIN</strong>
                    </a>
                    <div class="dropdown-divider border-primary" style="background-color:blue;"></div>
                    <a href="registrarme.php" class="dropdown-item menu-action" role="menuitem"
                        data-title="profile,moodle" aria-labelledby="actionmenuaction-2">
                        <img src="img/registro.png" style="width: 26px; height: 22px;"><strong> CREAR CUENTA</strong>
                    </a>
                    <?php
                        //El @ oculta los mensajes de error que pueda salir
                    } else if ($_SESSION['rolusu'] == "user") { //sino si la session rol no esta vacia
                    ?>
                    <div class="dropdown-divider border-primary" style="background-color:blue;"></div>
                    <a href="verperfil.php" class="dropdown-item menu-action select" role="menuitem"
                        data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                        <img src="img/perfil.png" style="width: 26px; height: 22px;"> <strong>PERFIL</strong>
                    </a>
                    <div class="dropdown-divider border-primary" style="background-color: blue;"></div>
                    <a href="desconectar.php" class="dropdown-item menu-action" role="menuitem"
                        data-title="profile,moodle" aria-labelledby="actionmenuaction-2">
                        <img src="img/exi.png" style="width: 26px; height: 22px;"> <strong>SALIR</strong>
                    </a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </nav>
    <?php

    if (!@empty($inicio == 1)) {
        require("inicio.php");
    } elseif (!@empty($productos == 1)) {
        require("productos.php");
    } elseif (!@empty($vereservas == 1)) {
    ?>
    <?php if (@$_SESSION['rolusu'] == "a1" || @$_SESSION['rolusu'] == "empresa" || @$_SESSION['rolusu'] == "user") {
            require("vereservas.php");
        } else { ?>
    <br><br><br>
    <div class=" container container-web-page ">
        <div class=" row justify-content-md-center border-primary"
            style="background-color: orange;border-radius: 35px; width: 100%; margin-left: 0;">
            <div class="col-12 col-md-6">
                <figure class="full-box">
                    <center>
                        <img src="img/ordenes.png" alt="registration_killaripostres" class="img-fluid">
                    </center>
                </figure>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-md-6">
                <h3 style="color:white;" class="text-center text-uppercase poppins-regular font-weight-bold">
                    <strong>MIS ORDENES</strong>
                </h3>

                <p class="text-justify">
                    <center>
                        <strong style="color:white;">
                            Aquí se mostrarán los pedidos que ordenes.</strong>
                    </center>
                </p>
                </p>
            </div>
        </div>
    </div><br>
    <?php } ?>
    <?php
    } else {
        require("inicio.php");
    }
    ?>
    <?php
    include('footer.php');
    ?>
</body>

</html>