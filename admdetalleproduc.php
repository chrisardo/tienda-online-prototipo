<?php
session_start();
require("connectdb.php");
include("conexion.php");
include 'sed.php';
//validar
if (@!$_SESSION['idusu']) {
    echo "<script>location.href='logueo.php'</script>";
} elseif ($_SESSION['rolusu'] == "a1" || $_SESSION['rolusu'] == "empresa") {
    /*if ((time() - $_SESSION['last_login_timestamp']) > 1240) { // 900 = 15 * 60  
        setcookie("cerrarsesion", 1, time() + 86400); //6o segundos es 1 minuto, 86400 segundos es por 24 horas
        echo "<script>location.href='desconectar.php'</script>";
    } else {
        $_SESSION['last_login_timestamp'] = time();
    }*/ } else {
    echo "<script>location.href='logueo.php'</script>";
}
extract($_GET);
$sql1 = "SELECT * FROM productos WHERE productos.idproducto=$id";
$resultado = mysqli_query($conexion, $sql1);
$persona = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
foreach ($persona as $row) {
    $idproducto = $row['idproducto'];
    $img_producto = base64_encode($row['imagproducto']);
    $precio_producto = sed::decryption($row['costoproducto']);
    $ide_prod = $row['id_empresa'];
    $codigocate = $row['codigocate'];
    @$idcategprod = $row['idcategoria'];
    $querycat = "SELECT*FROM categoria where codigocate='$codigocate' ORDER BY idcategoria DESC";
    $resultcat = mysqli_query($conexion, $querycat);
    $catego = mysqli_fetch_all($resultcat, MYSQLI_ASSOC);
    foreach ($catego as $row2) {
        $id_categ = $row2['idcategoria'];
    }
    $consulta_u = ("SELECT * FROM logueo_empresa  WHERE logueo_empresa.id_empresa='$ide_prod'");
    $query1u = mysqli_query($mysqli, $consulta_u);
    $empres = mysqli_fetch_all($query1u, MYSQLI_ASSOC);
    foreach ($empres as $arraye) { }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title><?php echo sed::decryption($row["nombreproducto"]); ?>| Periko's</title>
    <link rel="icon" href='data:image/jpg;base64,<?php echo $img_producto; ?>' sizes="32x32" type="img/jpg">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css2/style.css" />

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css2/invitado.css">
    <link rel="stylesheet" href="css/estilosgaleria.css">
    <link rel="stylesheet" href="css/contact.css">
    <!--compartir-->
    <!--<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=61a8fa9ed0a9e10012e4df83&product=sticky-share-buttons' async='async'></script>-->
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
        <div class="container-fluid">
            <a class="" href="adm.php?verproducto=1">
                <img src="img/atras.png" style="width: 30px; height: 40px;">
            </a>
            <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 16px;" href="#">
                <img src="img/ilogo.png" style="width: 30px; height: 30px;" alt="logo restaurantapp">
                <strong></strong>
            </a>
            <div style="margin-left: 1px;" class="navbar-brand order-1 order-justify-content-end dropdown show" id="yui_3_17_2_1_1636218170770_38">
                <a href="#" tabindex="0" class="" style="color: white;" id="action-menu-toggle-1" aria-label="Menú de usuario" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" aria-controls="action-menu-1-menu">

                    <img src="img/puntosblancos.png" style="width: 30px; height: 30px;">
                </a>
                <div class="dropdown-menu dropdown-menu-right menu align-tr-br" id="action-menu-1-menu" data-rel="menu-content" aria-labelledby="action-menu-toggle-1" role="menu" data-align="tr-br">
                    <a href="admeditproduc.php?id=<?php echo $idproducto; ?>&ft=1" class="dropdown-item menu-action select" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                        <img src="img/ordenes.png" style="width: 26px; height: 22px;"><strong> Editar producto</strong>
                    </a>
                    <div class="dropdown-divider border-primary" style="background-color:blue;"></div>
                    <a href="admreporteproduc.php?id=<?php echo $idproducto; ?>&ft=1" class="dropdown-item menu-action select" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
                        <img src="img/pdf.png" style="width: 26px; height: 22px;"><strong> Ver como PDF</strong>
                    </a>
                </div>
                <script>
                    function Copy() {
                        let url = document.location.href

                        navigator.clipboard.writeText(url).then(function() {
                            console.log('link copiado!');
                        }, function() {
                            console.log('link copiado!');
                        });

                    }
                </script>
            </div>
        </div>
    </nav>
    <br><br><br>
    <div style="width: 99%; margin-left: 20px;">
        <div style="display: inline-block; width: 30%; border: 2px solid orange;">
            <img src="data:image/jpg;base64,<?php echo $img_producto; ?>" style="border-radius:6px; width: 100%; height: 135px; ">
        </div>
        <div style="display: inline-block; width: 65%; border: 2px solid orange;">
            <div style="width: 100%; border: 2px solid orange;">
                <p style="color:blue; font-size: 14px;">
                    <strong><?php echo sed::decryption($row["nombreproducto"]); ?></strong>
                </p>
            </div>
            <div style="width: 100%; border: 2px solid orange;">
                <p style="color:orange; font-size: 14px;">
                    <strong>Empresa: <?php echo sed::decryption($arraye["nombreempresa"]);
                                        ?>
                    </strong>
                </p>
            </div>
        </div>
    </div>
    <br>
    <div style="width: 29%; margin-left: 20px; border: 2px solid blue;  display: inline-block;">
        <div style="border: 2px solid blue;">
            <center>
                <h1 style="color:blue; font-size: 22px;"><strong> Categoria</strong></h1>
            </center>
        </div>
        <div style="border: 2px solid blue;">
            <center>
                <p><strong><?php
                            if (!empty(sed::decryption(@$row2['nombrecateg']))) {
                                echo sed::decryption(@$row2['nombrecateg']);
                            } else {
                                echo "Se eliminó la categoria";
                            } ?></strong></p>
            </center>
        </div>
    </div>
    <div style="width: 28%; margin-left: 20px; border: 2px solid blue; display: inline-block; ">
        <div style="border: 2px solid blue;">
            <center>
                <h1 style="color:blue; font-size: 22px;"><strong> Precio</strong></h1>
            </center>
        </div>
        <div style="border: 2px solid blue;">
            <center>
                <p><strong>S/.
                        <?php
                        if (!empty($precio_producto)) {
                            echo $precio_producto;
                        } else {
                            echo "No se agregó el precio";
                        } ?></strong></p>
            </center>
        </div>
    </div>
    <div style="width: 28%; margin-left: 20px; border: 2px solid blue; display: inline-block; ">
        <div style="border: 2px solid blue;">
            <center>
                <h1 style="color:blue; font-size: 22px;"><strong> Cantidad stock</strong></h1>
            </center>
        </div>
        <div style="border: 2px solid blue;">
            <center>
                <p><strong>
                        <?php
                        if (!empty(sed::decryption($row['cantistock']))) {
                            echo sed::decryption($row['cantistock']);
                        } else {
                            echo "No agregó el stock";
                        } ?></strong></p>
            </center>
        </div>
    </div>
    <div style="width: 92%; margin-left: 20px; border: 2px solid blue;  display: inline-block; margin-top: 15px;">
        <div style="border: 2px solid blue; background: orange;">
            <h1 style="color:white; font-size: 22px; margin-left: 12px;"><strong>Detalles del producto</strong></h1>

        </div>
        <div style="border: 2px solid blue;">
            <p style="margin-left:12px; text-align:initial;"><strong><?php
                                                                        if (!empty(sed::decryption($row['detalleproducto']))) {
                                                                            echo sed::decryption($row['detalleproducto']);
                                                                        } else {
                                                                            echo "No se agregó el detalle";
                                                                        } ?></strong></p>
        </div>
    </div>
    <?php if (@$_SESSION['rolusu'] == "empresa") { ?>
        <?php if (isset($_GET['user'])) { ?>
            <form name="form1" method="post" action="">
                <label for="textarea"></label>
                <div style="width: 100%;">
                    <input type="hidden" class="form-control" name="idproducto" value="<?php echo $id; ?>" required="required" />
                    <textarea name="comentario" style="width: 74%;display:inline-block;  margin-left:24px;" rows="2" id="textarea" class="form-control"><?php if (isset($_GET['user'])) { ?>@<?php echo $_GET['user']; ?><?php } else { ?> Agrega un comentario acerca del producto...<?php } ?></textarea>
                    <input type="submit" <?php if (isset($_GET['comentario'])) { ?>name="reply" value="Responder" <?php } else { ?>name="comentar" value="Comentar" <?php } ?> class="btn btn-primary" style="display:inline-block; margin-top:-38px;">
                </div>
            </form>
        <?php } ?>
    <?php } ?>

    <?php
    if (isset($_POST['reply'])) {
        $comentarios = sed::encryption($_POST['comentario']);
        if (@$_SESSION['rolusu'] == "user") { //sino si la session rol no esta
            if (!empty($_POST['comentario'])) {
                $query = mysqli_query($mysqli, "INSERT INTO comentarios(idproducto, idusu,comentario,reply,fecha) 
  value ('" . $_POST['idproducto'] . "','" . $_SESSION['idusu'] . "','$comentarios','" . $_GET['comentario'] . "',NOW())");
                if ($query) {
                    echo "<script>location.href='?idproducto=$id'</script>";
                } else {
                    echo "Error: " . $query . "<br>" . mysqli_error($mysqli);
                    echo "No se pudo agregar";
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">El comentario no debe ir vacío. </div>';
            }
        } else if (@$_SESSION['rolusu'] == "empresa") { //sino si la session rol no esta
            if (!empty($_POST['comentario'])) {
                $query = mysqli_query($mysqli, "INSERT INTO comentarios(idproducto, id_empresa,comentario,reply,fecha) 
  value ('" . $_POST['idproducto'] . "','" . $_SESSION['idusu'] . "','$comentarios','" . $_GET['comentario'] . "',NOW())");
                if ($query) {
                    echo "<script>location.href='?idproducto=$id'</script>";
                } else {
                    echo "Error: " . $query . "<br>" . mysqli_error($mysqli);
                    echo "No se pudo agregar";
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">El comentario no debe ir vacío. </div>';
            }
        }
    }
    include "comentarios.php";
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha256-OUFW7hFO0/r5aEGTQOz9F/aXQOt+TwqI1Z4fbVvww04=" crossorigin="anonymous"></script>

    <script src="./js/script2.js"></script>
</body>

</html>