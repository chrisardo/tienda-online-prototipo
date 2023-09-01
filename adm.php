<?php
session_start();
if (@!$_SESSION['idusu']) {
    echo "<script>location.href='logueo.php'</script>";
} elseif ($_SESSION['rolusu'] == "a1" || $_SESSION['rolusu'] == "empresa" || $_SESSION['rolusu'] == "repartidor") {
    /*¡if ((time() - $_SESSION['last_login_timestamp']) > 240) { // 900 = 15 * 60  
        setcookie("cerrarsesion", 1, time() + 60000); //6o segundos es 1 minuto, 86400 segundos es por 24 horas
        echo "<script>location.href='desconectar.php'</script>";
    } else {
        $_SESSION['last_login_timestamp'] = time();
    }*/ } else {
    echo "<script>location.href='logueo.php'</script>";
}
?>
<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio|RestaurantApp</title>
    <link rel="icon" href='img/ilogo.png' sizes="32x32" type="img/jpg">

    <?php if (!@empty($regisproducto == 1) || !@empty($regiscategoria == 1)) { ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
        <link rel="stylesheet" href="css2/style.css" />
    <?php } else { ?>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
        <link rel="stylesheet" href="css2/style.css" />

        <link rel="stylesheet" href="css2/invitado.css">
    <?php } ?>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size:13px;" href="#">
                <img src="img/ilogo.png" style="width: 32px; height: 32px;" alt="logo restaurantapp">
                <strong></strong>
            </a>
            <button class="navbar-toggler align-self-start" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse bg-primary p-3 p-lg-0 mt-5 mt-lg-0 d-flex flex-column flex-lg-row flex-xl-row justify-content-lg-end mobileMenu" id="navbarSupportedContent">
                <ul class="navbar-nav align-self-stretch">
                    <li class="nav-item active">
                        <a class="nav-link" href="adm.php?inicio=1">INICIO </a>
                    </li>
                    <?php
                    if ($_SESSION['rolusu'] == "a1") {
                        ?>
                        <div class="dropdown-divider"></div>
                        <li class="nav-item">
                            <div style="margin-left: 1px;" class="navbar-brand order-1 order-justify-content-end dropdown show" id="yui_3_17_2_1_1636218170770_38">
                                <a href="#" tabindex="0" class=" dropdown-toggle" style="color: white;" id="action-menu-toggle-1" aria-label="Menú de usuario" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" aria-controls="action-menu-1-menu">
                                    <!--<a class="nav-link" href="admregisproducto.php">PRODUCTOS</a>-->
                                    EMPRESAS<b class="caret"></b>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right menu align-tr-br" id="action-menu-1-menu" data-rel="menu-content" aria-labelledby="action-menu-toggle-1" role="menu" data-align="tr-br">
                                    <a href="?solicitudempresa=1" class="dropdown-item menu-action" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                                        <img src="img/useregis.png" style="width: 30px; height: 30px;">
                                        <strong>Solicitud de empresas</strong>
                                    </a>
                                    <div class="dropdown-divider border-primary" style="background-color:blue;"></div>
                                    <a href="?empresas=1" class="dropdown-item menu-action select" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                                        <img src="img/venta.png" style="width: 26px; height: 22px;"> <strong>Empresas aceptadas</strong>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <div class="dropdown-divider"></div>
                        <li class="nav-item">
                            <div style="margin-left: 1px;" class="navbar-brand order-1 order-justify-content-end dropdown show" id="yui_3_17_2_1_1636218170770_38">
                                <a href="#" tabindex="0" class=" dropdown-toggle" style="color: white;" id="action-menu-toggle-1" aria-label="Menú de usuario" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" aria-controls="action-menu-1-menu">
                                    <!--<a class="nav-link" href="admregisproducto.php">PRODUCTOS</a>-->
                                    ROL<b class="caret"></b>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right menu align-tr-br" id="action-menu-1-menu" data-rel="menu-content" aria-labelledby="action-menu-toggle-1" role="menu" data-align="tr-br">
                                    <a href="?registrorol=1" class="dropdown-item menu-action" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                                        <img src="img/ordenes.png" style="width: 30px; height: 30px;">
                                        <strong>Registrar rol</strong>
                                    </a>
                                    <div class="dropdown-divider border-primary" style="background-color:blue;"></div>
                                    <a href="?verrol=1" class="dropdown-item menu-action select" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                                        <img src="img/opciones.png" style="width: 26px; height: 22px;"> <strong>Ver rol</strong>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <div class="dropdown-divider"></div>
                        <li class="nav-item">
                            <div style="margin-left: 1px;" class="navbar-brand order-1 order-justify-content-end dropdown show" id="yui_3_17_2_1_1636218170770_38">
                                <a href="#" tabindex="0" class=" dropdown-toggle" style="color: white;" id="action-menu-toggle-1" aria-label="Menú de usuario" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" aria-controls="action-menu-1-menu">
                                    <!--<a class="nav-link" href="admregisproducto.php">PRODUCTOS</a>-->
                                    REPARTIDOR<b class="caret"></b>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right menu align-tr-br" id="action-menu-1-menu" data-rel="menu-content" aria-labelledby="action-menu-toggle-1" role="menu" data-align="tr-br">
                                    <a href="?regisrepartidor=1" class="dropdown-item menu-action" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                                        <img src="img/ordenes.png" style="width: 30px; height: 30px;">
                                        <strong>Registrar repartidor</strong>
                                    </a>
                                    <div class="dropdown-divider border-primary" style="background-color:blue;"></div>
                                    <a href="?verrepartidor=1" class="dropdown-item menu-action select" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                                        <img src="img/opciones.png" style="width: 26px; height: 22px;"> <strong>Ver repartidor</strong>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <div class="dropdown-divider"></div>
                        <li class="nav-item">
                            <div style="margin-left: 1px;" class="navbar-brand order-1 order-justify-content-end dropdown show" id="yui_3_17_2_1_1636218170770_38">
                                <a href="#" tabindex="0" class=" dropdown-toggle" style="color: white;" id="action-menu-toggle-1" aria-label="Menú de usuario" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" aria-controls="action-menu-1-menu">
                                    <!--<a class="nav-link" href="admregisproducto.php">PRODUCTOS</a>-->
                                    REPORTADOS<b class="caret"></b>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right menu align-tr-br" id="action-menu-1-menu" data-rel="menu-content" aria-labelledby="action-menu-toggle-1" role="menu" data-align="tr-br">
                                    <a href="?productoreportados=1" class="dropdown-item menu-action" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                                        <img src="img/reportar.png" style="width: 30px; height: 30px;">
                                        <strong>Productos reportados</strong>
                                    </a>
                                    <div class="dropdown-divider border-primary" style="background-color:blue;"></div>
                                    <a href="?fallasreportadas=1" class="dropdown-item menu-action select" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                                        <img src="img/opciones.png" style="width: 26px; height: 22px;"> <strong>Fallas del sistema reportados</strong>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <div class="dropdown-divider"></div>
                        <li class="nav-item">
                            <div style="margin-left: 1px;" class="navbar-brand order-1 order-justify-content-end dropdown show" id="yui_3_17_2_1_1636218170770_38">
                                <a href="#" tabindex="0" class=" dropdown-toggle" style="color: white;" id="action-menu-toggle-1" aria-label="Menú de usuario" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" aria-controls="action-menu-1-menu">
                                    <!--<a class="nav-link" href="admregisproducto.php">PRODUCTOS</a>-->
                                    CIUDAD<b class="caret"></b>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right menu align-tr-br" id="action-menu-1-menu" data-rel="menu-content" aria-labelledby="action-menu-toggle-1" role="menu" data-align="tr-br">
                                    <a href="?regisciudad=1" class="dropdown-item menu-action" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                                        <img src="img/reportar.png" style="width: 30px; height: 30px;">
                                        <strong>Registrar ciudad</strong>
                                    </a>
                                    <div class="dropdown-divider border-primary" style="background-color:blue;"></div>
                                    <a href="?verciudad=1" class="dropdown-item menu-action select" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                                        <img src="img/opciones.png" style="width: 26px; height: 22px;"> <strong>Ver ciudades</strong>
                                    </a>
                                </div>
                            </div>
                        </li>
                    <?php } else if ($_SESSION['rolusu'] == "empresa") {  ?>
                        <div class="dropdown-divider"></div>
                        <li class="nav-item">

                            <div style="margin-left: 1px;" class="navbar-brand order-1 order-justify-content-end dropdown show" id="yui_3_17_2_1_1636218170770_38">
                                <a href="#" tabindex="0" class=" dropdown-toggle" style="color: white;" id="action-menu-toggle-1" aria-label="Menú de usuario" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" aria-controls="action-menu-1-menu">
                                    <!--<a class="nav-link" href="admregisproducto.php">PRODUCTOS</a>-->
                                    PRODUCTOS<b class="caret"></b>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right menu align-tr-br" id="action-menu-1-menu" data-rel="menu-content" aria-labelledby="action-menu-toggle-1" role="menu" data-align="tr-br">
                                    <a href="?regisproducto=1" class="dropdown-item menu-action" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                                        <img src="img/ordenes.png" style="width: 30px; height: 30px;">
                                        <strong>Registrar productos</strong>
                                    </a>
                                    <div class="dropdown-divider border-primary" style="background-color:blue;"></div>
                                    <a href="?verproducto=1" class="dropdown-item menu-action select" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                                        <img src="img/opciones.png" style="width: 26px; height: 22px;"> <strong>Ver productos</strong>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <div class="dropdown-divider"></div>
                        <li class="nav-item">
                            <!--<a class="nav-link" href="admregiscategoria.php">CATEGORIA</a>-->
                            <div style="margin-left: 1px;" class="navbar-brand order-1 order-justify-content-end dropdown show" id="yui_3_17_2_1_1636218170770_38">
                                <a href="#" tabindex="0" class=" dropdown-toggle" style="color: white;" id="action-menu-toggle-1" aria-label="Menú de usuario" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" aria-controls="action-menu-1-menu">
                                    <!--<a class="nav-link" href="admregisproducto.php">PRODUCTOS</a>-->
                                    CATEGORIA<b class="caret"></b>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right menu align-tr-br" id="action-menu-1-menu" data-rel="menu-content" aria-labelledby="action-menu-toggle-1" role="menu" data-align="tr-br">
                                    <a href="?regiscategoria=1" class="dropdown-item menu-action" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                                        <img src="img/ordenes.png" style="width: 30px; height: 30px;">
                                        <strong>Registrar categorias</strong>
                                    </a>
                                    <div class="dropdown-divider border-primary" style="background-color:blue;"></div>
                                    <a href="?vercategoria=1" class="dropdown-item menu-action select" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                                        <img src="img/opciones.png" style="width: 26px; height: 22px;"> <strong>Ver categorias</strong>
                                    </a>
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <?php
            require("connectdb.php");
            include("conexion.php");
            include 'sed.php';
            $idlog = @$_SESSION['idusu'];
            ?>
            <a style="margin-left: 4px;" href="" class="navbar-brand order-1 order-justify-content-end">
                <?php
                if ($_SESSION['rolusu'] == "a1") {
                    $consulta = ("SELECT * FROM logueo INNER JOIN rol on logueo.codigorol=rol.codigorol  
                    WHERE idusu='$idlog'");
                    $query1 = mysqli_query($mysqli, $consulta);
                    $persona = mysqli_fetch_all($query1, MYSQLI_ASSOC);
                    foreach ($persona as $array) {
                        $id = $array['idusu'];
                        $imagperfi = base64_encode($array['imagperfil']);
                        $nom = sed::decryption($array["nombreusu"]);
                        $apelli = sed::decryption($array["apellidousu"]);
                        $detalle_empresa = SED::decryption($array['detalleusu']);
                    }
                    ?>

                <?php
                } else if ($_SESSION['rolusu'] == "empresa") {
                    $consulta = ("SELECT * FROM logueo_empresa  WHERE id_empresa='$idlog'");
                    $query1 = mysqli_query($mysqli, $consulta);
                    $persona = mysqli_fetch_all($query1, MYSQLI_ASSOC);
                    foreach ($persona as $array) {
                        $id = $array['id_empresa'];
                        $imagperfi = base64_encode($array['imagempresa']);
                        $nom = sed::decryption($array["nombreempresa"]);
                        $detalle_empresa = SED::decryption($array['detalle_empresa']);
                    }
                    ?>
                <?php
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
                        $detalle_empresa = SED::decryption($array['detalle_repartidor']);
                    }
                    ?>
                <?php
                }
                ?>
                <?php
                if ($imagperfi) {
                    ?>
                    <img src="data:image/jpg;base64, <?php echo $imagperfi; ?>" style="width: 36px; height: 40px; border-radius: 14px;" alt="login">
                <?php
                } else {
                    ?>
                    <img src="img/fotoperfil.png" style="width: 40px; height: 40px;" alt="login">
                <?php
                }
                ?>

            </a>
            <div style="margin-left: 16px;" class="navbar-brand order-1 order-justify-content-end dropdown show" id="yui_3_17_2_1_1636218170770_38">
                <a href="#" tabindex="0" class=" " style="color: white;" id="action-menu-toggle-1" aria-label="Menú de usuario" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" aria-controls="action-menu-1-menu">
                    <img src="img/puntosblancos.png" style="width: 36px; height: 32px;">
                    <!--<b class="caret"></b>-->
                </a>
                <div class="dropdown-menu dropdown-menu-right menu align-tr-br" id="action-menu-1-menu" data-rel="menu-content" aria-labelledby="action-menu-toggle-1" role="menu" data-align="tr-br">
                    <?php if ($_SESSION['rolusu'] == "empresa") { ?>
                        <a href="admreporteventa.php" class="dropdown-item menu-action select" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                            <img src="img/ordenes.png" style="width: 26px; height: 22px;"> <strong>Reporte de productos vendidos</strong>
                        </a>
                    <?php } else { ?>
                        <a href="admreserva.php" class="dropdown-item menu-action select" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                            <img src="img/ordenes.png" style="width: 26px; height: 22px;"> <strong>ORDENES CLIENTES</strong>
                        </a>
                    <?php } ?>
                    <div class="dropdown-divider border-primary" style="background-color:blue;"></div>
                    <a href="verperfil.php?a=1" class="dropdown-item menu-action select" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                        <img src="img/perfil.png" style="width: 26px; height: 22px;"> <strong>PERFIL</strong>
                    </a>
                    <div class="dropdown-divider border-primary" style="background-color:blue;"></div>
                    <a href="informacion.php?adm=1" class="dropdown-item menu-action" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                        <img src="img/informa.png" style="width: 30px; height: 30px;">
                        <strong>Información sobre su cuenta</strong>
                    </a>
                    <div class="dropdown-divider border-primary"></div>
                    <a href="desconectar.php" class="dropdown-item menu-action" role="menuitem" data-title="profile,moodle" aria-labelledby="actionmenuaction-2">
                        <img src="img/exi.png" style="width: 26px; height: 22px;"><strong> SALIR</strong>
                    </a>
                </div>
            </div>
        </div>
    </nav><br><br><br>
    <?php
    extract($_GET);
    if (!@empty($inicio == 1)) {
        require("adminicio.php");
    } elseif (!@empty($solicitudempresa == 1)) {
        require("admsolicitudempresa.php");
    } elseif (!@empty($empresas == 1)) {
        require("admverempresa.php");
    } elseif (!@empty($regisproducto == 1)) {
        require("admregisproducto.php");
    } elseif (!@empty($verproducto == 1)) {
        require("admverproducto.php");
    } elseif (!@empty($regiscategoria == 1)) {
        require("admregiscategoria.php");
    } elseif (!@empty($vercategoria == 1)) {
        require("admvercategoria.php");
    } elseif (!@empty($registrorol == 1)) {
        require("admregistrorol.php");
    } elseif (!@empty($productoreportados == 1)) {
        require("productosreportados.php");
    } elseif (!@empty($verrol == 1)) {
        require("admverrol.php");
    } elseif (!@empty($regisrepartidor == 1)) {
        require("admregisrepartidor.php");
    } elseif (!@empty($verrepartidor == 1)) {
        require("admverrepartidor.php");
    } elseif (!@empty($regisciudad == 1)) {
        require("admregistrociudad.php");
    } elseif (!@empty($verciudad == 1)) {
        require("admverciudad.php");
    } else {
        require("adminicio.php");
    }
    ?>
    <?php
    include "footer.php";
    ?>
</body>

</html>