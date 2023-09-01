<?php
require("connectdb.php");
include("conexion.php");
include 'sed.php';
extract($_GET);
$idlog = @$_SESSION['idusu'];
$consulta = ("SELECT * FROM logueo_empresa  WHERE id_empresa='$id'");
$query1 = mysqli_query($mysqli, $consulta);
$persona = mysqli_fetch_all($query1, MYSQLI_ASSOC);
foreach ($persona as $array) {
    $id = $array['id_empresa'];
    $imagperfi = base64_encode($array['imagempresa']);
    $nom = sed::decryption($array["nombreempresa"]);
    $detalle_empresa = SED::decryption($array['detalle_empresa']);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $nom; ?>| Empresa</title>
    <?php if ($imagperfi) { ?>
        <link rel="icon" href='data:image/jpg;base64,<?php echo $imagperfi; ?>' sizes="32x32" type="img/jpg">
    <?php } else { ?>
        <link rel="icon" href='img/logo.png' sizes="32x32" type="img/jpg">
    <?php } ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css2/style.css" />
    <link rel="stylesheet" href="css2/invitado.css">
    <link rel="stylesheet" href="css/estilosgaleria.css">
    <link rel="stylesheet" href="css/contact.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
        <div class="container-fluid">
            <a class="" href="index.php?productos=1">
                <img src="img/atras.png" style="width: 30px; height: 40px;">
            </a>
            <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 16px;" href="#">
                <img src="img/logo.png" style="width: 30px; height: 30px;" alt="logo restaurantapp">
                <strong>Periko's</strong>
            </a>

        </div>
    </nav>
    <br><br>
    <center>
        <li>
            <div class="invi border-primary " style=" border:2px solid blue; width: 50%;height: 180%;" category="iquitos">
                <?php
                if ($imagperfi) {
                    ?>
                    <img src="data:image/jpg;base64,<?php echo $imagperfi; ?>" style="width: 100%" alt="imagen invitado">
                <?php
                } else {
                    ?>
                    <img src="img/fotoperfil.png" style="width: 100%" alt="imagen invitado">
                <?php
                }
                ?>
                <p class="p"><?php echo $nom; ?></p>

            </div>
        </li>
    </center>
    <br>
    <?php
    if ($detalle_empresa) {
        ?>
        <center>
            <div style="margin-top: 0px;">
                <div style="display: inline-block;">
                    <p><strong><?php echo $detalle_empresa; ?></strong></p>
                </div>
            </div>
        </center>
    <?php
    }
    ?>
    <br>
    <div>
        <div style="width: 94%; margin-left: 18px;">
            <form action="" method="post" class="formulario column column--50 bg-orange">
                <label for="" style="color:blue;font-size: 22px;" class="formulario__label"><strong>Categorias:</strong> </label>
                <select id="soporte" class="form-control" style="float: left; width: 64%;" name="nombrecategor" required="required">
                    <?php if (isset($_POST['seleccionar'])) {
                        $nombrecategor = $_POST['nombrecategor'];
                        $nombcate = sed::encryption($nombrecategor);
                        if ($nombrecategor == "-") {
                            echo "No seleccionó la cateogoria"; ?>
                        <?php } else { ?>
                            <?php if ($nombrecategor == "Todos") { ?>
                                <option value="Todos" selected="">Todos</option>
                            <?php } else { //selecciono la categoria
                                        $sql2categ = "SELECT * FROM categoria 
                                        where nombrecateg='$nombcate'";
                                        $resultado2categ = mysqli_query($conexion, $sql2categ);
                                        $categorias2 = mysqli_fetch_all($resultado2categ, MYSQLI_ASSOC);
                                        foreach ($categorias2 as $rowcate) { } ?>
                                <option value="<?php echo sed::decryption($rowcate['nombrecateg']); ?>" selected="">
                                    <?php echo sed::decryption($rowcate['nombrecateg']); ?>
                                </option>
                            <?php } ?>
                        <?php } ?>
                    <?php } else { ?>
                        <option value="Todos" selected="">Seleccione categoria del producto</option>
                    <?php } ?>
                    <?php
                    $sqlcateg = "SELECT * FROM categoria WHERE id_empresa='$id' group by nombrecateg ORDER BY idcategoria DESC";
                    $resultadocateg = mysqli_query($conexion, $sqlcateg);
                    $categorias = mysqli_fetch_all($resultadocateg, MYSQLI_ASSOC);
                    foreach ($categorias as $rowcat) {
                        $idcat = sed::decryption($rowcat['idcategoria']);
                        $nombrecatego = sed::decryption($rowcat['nombrecateg']);
                        echo '<option value="' . $nombrecatego . '">' . $nombrecatego . '</option>';
                    }
                    ?>
                    <option value="Todos">Todos</option>
                </select>
                <input type="submit" name="seleccionar" value="Seleccionar" style="width:106px; margin-left: 6px; margin-top: -1px; float:left;" class="btn btn-primary">
            </form>
        </div><br><br>
        <div class="contorno">
            <?php
            $sqlq = "SELECT*FROM productos where id_empresa='$id' and cantistock != 0  ORDER BY idproducto DESC";
            $resul_cant = mysqli_query($conexion, $sqlq);
            $cantidad = mysqli_num_rows($resul_cant);
            $torta = mysqli_fetch_all($resul_cant, MYSQLI_ASSOC);
            if (isset($_POST['seleccionar'])) {
                $nombrecategor = $_POST['nombrecategor'];
                $nombcate = sed::encryption($nombrecategor);
                ?>
                <?php if ($nombrecategor == "Todos") { ?>
                    <?php foreach ($torta as $row) {
                                $id = $row['idproducto'];
                                $ide_prod = $row['id_empresa'];
                                $idcategprod = $row['codigocate'];
                                $querycat = "SELECT*FROM categoria where codigocate='$idcategprod' ORDER BY idcategoria DESC";
                                $resultcat = mysqli_query($conexion, $querycat);
                                $catego = mysqli_fetch_all($resultcat, MYSQLI_ASSOC);
                                foreach ($catego as $row2) {
                                    $id_categ = $row2['idcategoria'];
                                }
                                $consulta_u = ("SELECT * FROM logueo_empresa  WHERE logueo_empresa.id_empresa='$ide_prod'");
                                $query1u = mysqli_query($mysqli, $consulta_u);
                                $empres = mysqli_fetch_all($query1u, MYSQLI_ASSOC);
                                foreach ($empres as $arraye) { } ?>
                        <div class="contorno2">
                            <div class="divimg">
                                <img src="data:image/jpg;base64,<?php echo base64_encode($row['imagproducto']); ?>" style="width: 100%; height:100px;" alt="imgproductos">
                                <!--<img src="img/logo.png" style="width: 100%; height:100px;" alt="imgproductos"-->
                            </div>
                            <div style="width: 102%;">
                                <div class="pe">
                                    <p style="color: blue;">
                                        <strong> <?php echo sed::decryption($row['nombreproducto']); ?></strong>
                                    </p>
                                </div>
                                <div style="margin-top:-12px; width: 100%;">
                                    <div class="contenedor3">
                                        <p class="pc"><strong><?php echo sed::decryption($row2['nombrecateg']); ?></strong>
                                        </p>
                                    </div>
                                    <div class="contenedor3">
                                        <p class="pc" style="color:orangered;"><strong>S/.<?php echo sed::decryption($row['costoproducto']);
                                                                                                        ?> </strong></p>
                                    </div>
                                </div>
                            </div>
                            <a href="verproducto.php?idproducto=<?php echo $id; ?>" style="color:green; ">
                                <div class="buttonp">
                                    Ver productos
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                <?php } else { //si selecciono la opcion
                        $sql2categ = "SELECT * FROM categoria where nombrecateg='$nombcate'";
                        $resultado2categ = mysqli_query($conexion, $sql2categ);
                        $categorias2 = mysqli_fetch_all($resultado2categ, MYSQLI_ASSOC);
                        foreach ($categorias2 as $rowcat) {
                            $idcat2 = $rowcat['codigocate'];
                        }
                        $sql1 = "SELECT * FROM productos where codigocate='$idcat2' and cantistock != 0 ORDER BY idproducto ASC";
                        $resultado = mysqli_query($conexion, $sql1);
                        $persona = mysqli_fetch_all($resultado, MYSQLI_ASSOC); ?>
                    <?php foreach ($persona as $ro) {
                                $id = $ro['idproducto'];
                                $ide_prod = $ro['id_empresa'];
                                $consulta_u = ("SELECT * FROM logueo_empresa  WHERE logueo_empresa.id_empresa='$ide_prod'");
                                $query1u = mysqli_query($mysqli, $consulta_u);
                                $empres = mysqli_fetch_all($query1u, MYSQLI_ASSOC);
                                foreach ($empres as $arraye) { } ?>
                        <div class="contorno2">
                            <div class="divimg">
                                <img src="data:image/jpg;base64,<?php echo base64_encode($ro['imagproducto']); ?>" style="width: 100%; height:100px;" alt="imgproductos">
                                <!--<img src="img/logo.png" style="width: 100%; height:100px;" alt="imgproductos"-->
                            </div>
                            <div style="width: 102%;">
                                <div class="pe">
                                    <p style="color: blue;">
                                        <strong> <?php echo sed::decryption($ro['nombreproducto']); ?></strong>
                                    </p>
                                </div>
                                <div style="margin-top:-12px; width: 100%;">
                                    <div class="contenedor3">
                                        <p class="pc"><strong><?php echo sed::decryption($rowcat['nombrecateg']); ?></strong>
                                        </p>
                                    </div>
                                    <div class="contenedor3">
                                        <p class="pc" style="color:orangered;"><strong>S/.<?php echo sed::decryption($ro['costoproducto']);
                                                                                                        ?> </strong></p>
                                    </div>
                                </div>
                            </div>
                            <a href="verproducto.php?idproducto=<?php echo $id; ?>" style="color:green; ">
                                <div class="buttonp">
                                    Ver productos
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } else { // no selecciono

                ?>
                <?php
                    foreach ($torta as $row) {
                        $id = $row['idproducto'];
                        $ide_prod = $row['id_empresa'];
                        $idcategprod = $row['codigocate'];
                        $querycat = "SELECT*FROM categoria where codigocate='$idcategprod' ORDER BY idcategoria DESC";
                        $resultcat = mysqli_query($conexion, $querycat);
                        $catego = mysqli_fetch_all($resultcat, MYSQLI_ASSOC);
                        foreach ($catego as $row2) {
                            $id_categ = $row2['idcategoria'];
                        }
                        $consulta_u = ("SELECT * FROM logueo_empresa  WHERE logueo_empresa.id_empresa='$ide_prod'");
                        $query1u = mysqli_query($mysqli, $consulta_u);
                        $empres = mysqli_fetch_all($query1u, MYSQLI_ASSOC);
                        foreach ($empres as $arraye) { } ?>
                    <div class="contorno2">
                        <div class="divimg">
                            <img src="data:image/jpg;base64,<?php echo base64_encode($row['imagproducto']); ?>" style="width: 100%; height:100px;" alt="imgproductos">
                            <!--<img src="img/logo.png" style="width: 100%; height:100px;" alt="imgproductos"-->
                        </div>
                        <div style="width: 102%;">
                            <div class="pe">
                                <p style="color: blue;">
                                    <strong> <?php echo sed::decryption($row['nombreproducto']); ?></strong>
                                </p>
                            </div>
                            <div style="margin-top:-12px; width: 100%;">
                                <div class="contenedor3">
                                    <p class="pc"><strong><?php echo sed::decryption($row2['nombrecateg']); ?></strong>
                                    </p>
                                </div>
                                <div class="contenedor3">
                                    <p class="pc" style="color:orangered;"><strong>S/.<?php echo sed::decryption($row['costoproducto']);
                                                                                                ?> </strong></p>
                                </div>
                            </div>
                        </div>
                        <a href="verproducto.php?idproducto=<?php echo $id; ?>&idempresa=<?php echo $arraye["id_empresa"]; ?>" style="color:green; ">
                            <div class="buttonp">
                                Ver productos
                            </div>
                        </a>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <style>
            div .contorno {
                width: 97%;
                margin-left: 15px;
            }

            div .contorno2 {
                display: inline-block;
                border: 2px solid blue;
                width: 24%;
                margin-left: 8px;
                background-color: greenyellow;
            }

            div .buttonp {
                border: 2px solid green;
                margin-left: 8px;
                color: green;
                width: 85%;
                height: 35px;
                text-align: center;
                margin-left: 13px;
                margin-top: -2px;
                background-color: white;
            }

            div .pe {
                font-size: 14px;
                margin-left: 3px;
            }

            div .contenedor3 {
                display: inline-block;
                margin-left: 5px;
                width: 46%;
                height: 32px;
            }

            /*--Estilos responsive--*/
            @media screen and (min-width:350px) {
                div .contorno {
                    width: 97%;
                    margin-left: 12px;
                }

                div .pe {
                    font-size: 11px;
                }

                div .contorno2 {
                    width: 47%;
                    margin-left: 2px;
                    margin-top: 4px;
                }

                div .contenedor3 {
                    display: inline-block;
                    margin-left: 3px;
                    width: 46%;
                    height: 32px;
                }

                div .pc {
                    font-size: 12px;
                }
            }

            @media screen and (min-width:390px) {
                div .pe {
                    font-size: 11px;
                }

                div .contorno2 {
                    width: 47%;
                    margin-left: 2px;
                    margin-top: 4px;
                }

                div .contenedor3 {
                    display: inline-block;
                    margin-left: 3px;
                    width: 46%;
                    height: 32px;
                }

                div .pc {
                    font-size: 12px;
                }
            }

            @media screen and (min-width:468px) {
                div .pe {
                    font-size: 14px;
                }

                div .contorno2 {
                    width: 32%;
                }
            }

            @media screen and (min-width:624px) {
                div .pe {
                    width: 100%;
                    font-size: 12px;
                }

                div .contorno2 {
                    width: 31%;
                }
            }

            @media screen and (min-width:730px) {
                div .pe {
                    font-size: 15px;
                }

                div .contorno2 {
                    width: 32%;
                    margin-left: 4px;
                }

                div .contenedor3 {
                    display: inline-block;
                    margin-left: 4px;
                    width: 46%;
                    height: 32px;
                }

                div .pc {
                    font-size: 15px;
                }
            }

            @media screen and (min-width:1020px) {
                div .pe {
                    font-size: 14px;
                }

                div .contorno2 {
                    width: 23%;
                    margin-left: 12px;
                }

                div .contenedor3 {
                    display: inline-block;
                    margin-left: 4px;
                    width: 46%;
                    height: 32px;
                }

                div .pc {
                    font-size: 14px;
                }
            }

            @media screen and (min-width:1270px) {
                div .pe {
                    font-size: 16px;
                }

                div .contorno2 {
                    width: 24%;
                    margin-left: 9px;
                }

                div .contenedor3 {
                    display: inline-block;
                    margin-left: 4px;
                    width: 46%;
                    height: 32px;
                    border: 2px solid green;
                }

                div .pc {
                    font-size: 15px;
                }
            }
        </style>
</body>

</html>