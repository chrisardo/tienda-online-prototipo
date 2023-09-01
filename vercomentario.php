<?php
session_start();
require("connectdb.php");
include("conexion.php");
include 'sed.php';
extract($_GET);
$sql1 = "SELECT * FROM productos WHERE idproducto=$idproducto";
$resultado = mysqli_query($conexion, $sql1);
$persona = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
foreach ($persona as $rows) {
    $idproducto = $rows['idproducto'];
    $img_producto = base64_encode($rows['imagproducto']);
    $nombre_producto = sed::decryption($rows['nombreproducto']);
    $idcate_producto = $rows['codigocate'];
    $precio_producto = sed::decryption($rows['costoproducto']);
}
if (@$_SESSION['rolusu'] == "user") { //sino si la session rol no esta vacia
    /*if ((time() - @$_SESSION['last_login_timestamp']) > 1260) { // 900 = 15 * 60  
        setcookie("cerrarsesion", 1, time() + 960000); //6o segundos es 1 minuto, 86400 segundos es por 24 horas
        echo "<script>location.href='desconectar.php'</script>";
    } else {
        @$_SESSION['last_login_timestamp'] = time();
    }*/ }
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title><?php echo $nombre_producto; ?>| Periko's</title>
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
            <?php
            if (@$ft == 1) {
                ?>
                <a class="" href="favoritos.php">
                    <img src="img/atras.png" style="width: 30px; height: 40px;">
                </a>
            <?php
            } else if (@$idempresa) {
                ?>
                <a class="" href="verempresa.php?id=<?php echo $idempresa; ?>">
                    <img src="img/atras.png" style="width: 30px; height: 40px;">
                </a>
            <?php
            } else if (@$_SESSION['rolusu'] == "empresa") {
                ?>
                <a class="" href="admdetalleproduc.php?id=<?php echo $idproducto; ?>">
                    <img src="img/atras.png" style="width: 30px; height: 40px;">
                </a>
            <?php
            } else {
                ?>
                <a class="" href="verproducto.php?idproducto=<?php echo $idproducto; ?>">
                    <img src="img/atras.png" style="width: 30px; height: 40px;">
                </a>
            <?php
            }
            ?>
            <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 16px;" href="#">
                <img src="img/logo.png" style="width: 30px; height: 30px;" alt="logo restaurantapp">
                <strong>Periko's</strong>
            </a>
        </div>
    </nav>
    <?php
    foreach ($persona as $ro) {
        $id = $ro['idproducto'];
        $ide_prod = $ro['id_empresa'];
        $image = base64_encode($ro['imagproducto']);
        $nombretort = sed::decryption($ro['nombreproducto']);
        $preciotorta = sed::decryption($ro['costoproducto']);
        $detalletorta = sed::decryption($ro['detalleproducto']);
        $idcategprod = $ro['codigocate'];
        $querycat = "SELECT*FROM categoria where codigocate='$idcategprod' ORDER BY idcategoria DESC";
        $resultcat = mysqli_query($conexion, $querycat);
        $catego = mysqli_fetch_all($resultcat, MYSQLI_ASSOC);
        foreach ($catego as $row2) {
            $id_categ = $row2['idcategoria'];
            $imag_categ = base64_encode($row2['imagen']);
            $nombre_categ = sed::decryption($row2['nombrecateg']);
            $descripcion_categ = sed::decryption($row2['descripcioncateg']);
        }
        $consulta_u = ("SELECT * FROM logueo_empresa  WHERE logueo_empresa.id_empresa='$ide_prod'");
        $query1u = mysqli_query($mysqli, $consulta_u);
        $empres = mysqli_fetch_all($query1u, MYSQLI_ASSOC);
        foreach ($empres as $arraye) { }
        ?>
        <li class="" style="margin-top: 8px;">
            <div class="invi border-primary " style="width: 100%;height: 180%;" category="iquitos">
                <img src="data:image/jpg;base64,<?php echo $image; ?>" style="width: 100%" alt="imagen invitado">
                <p class="p"><?php echo $nombretort; ?></p>
            </div>
        </li>
    <?php
    }
    ?>
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
    <?php } else { ?>
        <form name="form1" method="post" action="">
            <label for="textarea"></label>
            <div style="width: 100%;">
                <input type="hidden" class="form-control" name="idproducto" value="<?php echo $id; ?>" required="required" />
                <textarea name="comentario" style="width: 74%;display:inline-block;  margin-left:24px;" rows="2" id="textarea" class="form-control"><?php if (isset($_GET['user'])) { ?>@<?php echo $_GET['user']; ?><?php } else { ?> Agrega un comentario acerca del producto...<?php } ?></textarea>
                <input type="submit" <?php if (isset($_GET['comentario'])) { ?>name="reply" value="Responder" <?php } else { ?>name="comentar" value="Comentar" <?php } ?> class="btn btn-primary" style="display:inline-block; margin-top:-38px;">
            </div>
        </form>
    <?php } ?>
    <?php
    if (isset($_POST['comentar'])) {
        if (@$_SESSION['rolusu'] == "user") { //sino si la session rol no esta 
            $comentarios = sed::encryption($_POST['comentario']);
            if (!empty($_POST['comentario'])) {
                $query = mysqli_query($mysqli, "INSERT INTO comentarios (idproducto, idusu,comentario,fecha) 
      value ('" . $_POST['idproducto'] . "','" . $_SESSION['idusu'] . "','$comentarios',NOW())");
                if ($query) {
                    echo "<script>location.href='verproducto.php?idproducto=$id'</script>";
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">El comentario no debe ir vacío. </div>';
            }
        } else { }
    }
    if (isset($_POST['reply'])) {
        $comentarios = sed::encryption($_POST['comentario']);
        if (@$_SESSION['rolusu'] == "user") { //sino si la session rol no esta
            if (!empty($_POST['comentario'])) {
                $query = mysqli_query($mysqli, "INSERT INTO comentarios(idproducto, idusu,comentario,reply,fecha) 
      value ('" . $_POST['idproducto'] . "','" . $_SESSION['idusu'] . "','$comentarios','" . $_GET['comentario'] . "',NOW())");
                if ($query) {
                    echo "<script>location.href='vercomentario.php?idproducto=$id'</script>";
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
                    echo "<script>location.href='vercomentario.php?idproducto=$id'</script>";
                } else {
                    echo "Error: " . $query . "<br>" . mysqli_error($mysqli);
                    echo "No se pudo agregar";
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">El comentario no debe ir vacío. </div>';
            }
        }
    }
    ?>
    <div style="width: 96%; margin-left: 28px; border:2px solid blue;">
        <div style="width: 100%; border:2px solid blue; background: greenyellow;">
            <center>
                <img src="img/favorito.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -0px;">
                <h1 style="display: inline-block; font-size: 18px; color:blue;">Comentarios</h1>
            </center>
        </div>
        <div style="width: 99%; margin-left: 10px;">
            <ul id="comments">
                <?php
                $queryc = "SELECT * FROM comentarios 
                WHERE reply = 0 and idproducto='$idproducto' ORDER BY id_comentario DESC ";
                $sqlcomentarios = mysqli_query($mysqli, $queryc);
                $comentarios = mysqli_fetch_all($sqlcomentarios, MYSQLI_ASSOC);
                foreach ($comentarios as $rowco) {
                    $idcomen = $rowco['id_comentario'];
                    $idcom_use = $rowco['idusu'];
                    $queryu = "SELECT * FROM logueo WHERE logueo.idusu = '$idcom_use'";
                    $sqlusuario = mysqli_query($mysqli, $queryu);
                    $usuarios = mysqli_fetch_all($sqlusuario, MYSQLI_ASSOC);
                    foreach ($usuarios as $u) {
                        $imp = base64_encode($u['imagperfil']);
                        $nomusu = sed::decryption($u['nombreusu']);
                    }
                    ?>
                    <li class="cmmnt">
                        <div style="width: 95%; margin-left: 10px; background: blue; height: 2px; margin-top: 0px;"></div>

                        <div style="display: inline-block; ">
                            <?php if (@$imp) { ?>
                                <img src="data:image/jpg;base64,<?php echo base64_encode($users['imagperfil']); ?>" style="width: 50px; height: 66px; <?php if (@$_SESSION['idusu'] == $idcom_use) { ?>margin-top: -50px; <?php } else { ?><?php } ?>">
                            <?php } else { ?>
                                <img src="img/fotoperfil.png" style="width: 50px; height: 57px; border: 2px solid green;  <?php if (@$_SESSION['idusu'] == $idcom_use) { ?>margin-top: -50px; <?php } else { ?><?php } ?>">
                            <?php } ?>
                        </div>
                        <div style="display: inline-block;">
                            <div style="display: inline-block;">
                                <p style="color:blue; font-size: 14px;"><strong><?php echo $nomusu . " " . sed::decryption($u['apellidousu']) . " "; ?></strong></p>
                            </div>
                            <div style="display: inline-block;">
                                <p style="font-size: 14px;"><strong><?php echo  $rowco["fecha"]; ?></strong></p>
                            </div>
                            <p style="color:orange; font-size: 14px; margin-top:-16px;">
                                <strong><?php echo sed::decryption($rowco["comentario"]);
                                            ?>
                                </strong>
                            </p>
                            <div style="margin-top:-12px;">
                                <?php if (@$_SESSION['rolusu'] == "empresa") { ?>
                                    <a href="vercomentario.php?idproducto=<?php echo $id; ?>&user=<?php echo  $nomusu; ?>&comentario=<?php echo $rowco['id_comentario']; ?>" style="">
                                        Responder
                                    </a>
                                <?php } ?>
                                <?php if (@$_SESSION['idusu'] == $idcom_use) { ?>
                                    <a href="?idproducto=<?php echo $id; ?>&id_comentar=<?php echo $rowco['id_comentario']; ?>" style="">
                                        Eliminar
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                        <?php
                            $contar = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM comentarios WHERE reply = '" . $rowco['id_comentario'] . "' and idproducto='$idproducto'"));
                            if ($contar != '0') {
                                $reply = mysqli_query($mysqli, "SELECT * FROM comentarios WHERE reply = '" . $rowco['id_comentario'] . "'  and idproducto='$idproducto' ORDER BY id_comentario ASC");
                                while ($rep = mysqli_fetch_array($reply)) {
                                    $usuario2 = mysqli_query($mysqli, "SELECT * FROM logueo WHERE idusu = '" . $rep['idusu'] . "'");
                                    $user2 = mysqli_fetch_array($usuario2);
                                    $sqlempresa2 = mysqli_query($mysqli, "SELECT * FROM logueo_empresa WHERE id_empresa = '" . $rep['id_empresa'] . "'");
                                    $empresa2 = mysqli_fetch_array($sqlempresa2);
                                    ?>
                                <ul class="replies">
                                    <li class="cmmnt">
                                        <div style="margin-left:42px;" class="replies">
                                            <div style="width: 95%; margin-left: 12px; background: blue; height: 2px; margin-top: 4px;"></div>

                                            <div style="display: inline-block; ">
                                                <?php if (base64_encode(@$user2['imagperfil'])) { ?>
                                                    <img src="data:image/jpg;base64,<?php echo base64_encode(@$user2['imagperfil']); ?>" style="width: 50px; height: 66px; <?php if (@$_SESSION['idusu'] == $idcom_use) { ?>margin-top: -50px; <?php } else { ?><?php } ?>">
                                                <?php }
                                                            if (base64_encode(@$empresa2['imagempresa'])) { ?>
                                                    <img src="data:image/jpg;base64,<?php echo base64_encode(@$empresa2['imagempresa']); ?>" style="width: 50px; height: 66px; <?php if (@$_SESSION['idusu'] == $idcom_use) { ?>margin-top: -50px; <?php } else { ?><?php } ?>">
                                                <?php } else { ?>
                                                    <img src="img/fotoperfil.png" style="width: 50px; height: 56px; border: 2px solid green; <?php if (@$_SESSION['idusu'] == $idcom_use) { ?>margin-top: -50px; <?php } else { ?><?php } ?>">
                                                <?php } ?>
                                            </div>
                                            <div style="display: inline-block;">
                                                <div style="display: inline-block;">
                                                    <p style="color:blue; font-size: 14px;">
                                                        <strong>
                                                            <?php
                                                                        if (!empty(sed::decryption(@$user2["nombreusu"])) && !empty(sed::decryption(@$user2['apellidousu']))) {
                                                                            echo sed::decryption($user2["nombreusu"]) . " " . sed::decryption($user2['apellidousu']) . " ";
                                                                        } else if (!empty(sed::decryption($empresa2["nombreempresa"]))) {
                                                                            echo sed::decryption($empresa2["nombreempresa"]);
                                                                        } ?></strong></p>
                                                </div>
                                                <div style="display: inline-block;">
                                                    <p style="font-size: 14px;"><strong><?php echo  $rep["fecha"]; ?></strong></p>
                                                </div>
                                                <p style="color:orange; font-size: 14px; margin-top:-16px;">
                                                    <strong><?php echo sed::decryption($rep["comentario"]);
                                                                        ?>
                                                    </strong>
                                                </p>
                                                <div style="margin-top:-12px;">
                                                    <?php if (@$_SESSION['idusu']) { ?>
                                                        <?php if (@$_SESSION['idusu'] == $idcom_use) { ?>
                                                            <a href="vercomentario.php?idproducto=<?php echo $id; ?>&comentario=<?php echo $rowco['id_comentario']; ?>&user=<?php if (!empty(sed::decryption(@$user2["nombreusu"]))) {
                                                                                                                                                    echo sed::decryption($user2["nombreusu"]);
                                                                                                                                                } else if (!empty(sed::decryption(@$empresa2["nombreempresa"]))) {
                                                                                                                                                    echo sed::decryption(@$empresa2["nombreempresa"]);
                                                                                                                                                } ?>" style="">
                                                                Responder
                                                            </a>
                                                        <?php } ?>
                                                        <?php if (@$_SESSION['rolusu'] == "empresa" && $rep['idusu']) { ?>
                                                            <a href="vercomentario.php?idproducto=<?php echo $id; ?>&user=<?php echo  sed::decryption(@$user2["nombreusu"]); ?>&comentario=<?php echo $rowco['id_comentario']; ?>" style="">
                                                                Responder
                                                            </a>
                                                        <?php } ?>
                                                        <?php if (@$_SESSION['idusu'] == $rep['idusu']) { ?>
                                                            <a href="vercomentario.php?idproducto=<?php echo $id; ?>&id_comenta=<?php echo $rep['id_comentario']; ?>" style="">
                                                                Eliminar
                                                            </a>
                                                        <?php } elseif (@$_SESSION['idusu'] == $rep['id_empresa']) { ?>
                                                            <a href="vercomentario.php?idproducto=<?php echo $id; ?>&id_comenta=<?php echo $rep['id_comentario']; ?>" style="">
                                                                Eliminar
                                                            </a>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            <?php } ?>
                        <?php  } ?>
                    <?php } ?>
                    </li>
            </ul>
        </div>
    </div>
    <?php
    if (@$id_comentar) {
        extract($_GET);
        $eliminarcomen = mysqli_query($mysqli, "DELETE FROM comentarios WHERE id_comentario='$id_comentar'");
        if ($eliminarcomen) {
            echo "<script>location.href='?idproducto=$id'</script>";
        }
    }
    if (@$id_comenta) {
        extract($_GET);
        $eliminarcomen = mysqli_query($mysqli, "DELETE FROM comentarios WHERE id_comentario='$id_comenta'");
        if ($eliminarcomen) {
            echo "<script>location.href='?idproducto=$id'</script>";
        }
    }
    ?>
</body>

</html>