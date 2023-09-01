<form style="margin-left: 18px;" class="form-inline my-2 my-lg-0 align-self-stretch" name="buscador" action="adm.php?vercategoria=1" method="POST">
    <input class="form-control mr-sm-2" style="width: 200px;" type="text" name="word" placeholder="Buscar categoria" aria-label="Search" />
    <button class="btn btn-success my-2 my-sm-0" style="width: 67px;" name="buscarcateg" value="Buscar" type="submit">
        Buscar
    </button>
</form>
<?php
require 'class/bookscateg.php';
$word = sed::encryption(@$_POST['word']);
$objBook = new Bookscateg();
$words = explode(' ', $word);
$num = count($words);
$result = $objBook->buscar($word, $num);
include_once('class/database.php');
//echo $id_us;
if ($_SESSION['rolusu'] == "a1") {
    $query = "SELECT*FROM categoria ORDER BY idcategoria DESC";
} elseif ($_SESSION['rolusu'] == "empresa") {
    $query = "SELECT*FROM categoria WHERE id_empresa='$idlog' ORDER BY idcategoria DESC";
}

//$query = "SELECT*FROM logueo where rolusu != '$rolusu' ORDER BY logueo.idusu DESC";
$resul_cant = mysqli_query($mysqli, $query);
$cantidcate = mysqli_num_rows($resul_cant);
$categori = mysqli_fetch_all($resul_cant, MYSQLI_ASSOC);
if ($cantidcate > 0) {
    ?>
    <?php if (isset($_POST['buscarcateg'])) {
            //echo "se dio click"; 
            ?>
        <?php
                if (@$result) {
                    if ($_SESSION['rolusu'] == "a1") {
                        $Busca = 'SELECT * FROM categoria 
                    WHERE nombrecateg LIKE "% ' . $word . '%" '
                            . 'OR nombrecateg LIKE "%' . $word . '%"'
                            . 'OR descripcioncateg LIKE "%' . $word . '%"';
                    } elseif ($_SESSION['rolusu'] == "empresa") {
                        $Busca = 'SELECT * FROM categoria 
                        inner join logueo_empresa on categoria.id_empresa=logueo_empresa.id_empresa
                        INNER JOIN rol on logueo_empresa.codigorol = rol.codigorol 
                        WHERE logueo_empresa.id_empresa="' . $idlog . '" AND categoria.id_empresa="' . $idlog . '" AND nombrecateg LIKE "% ' . $word . '%" '
                            . 'OR nombrecateg LIKE "%' . $word . '%"'
                            . 'OR descripcioncateg LIKE "%' . $word . '%"';
                        //$query = "SELECT*FROM categoria WHERE idusu='$id_us' ORDER BY idcategoria DESC";
                    }
                    $que = mysqli_query($conexion, $Busca);
                    $contacat = mysqli_num_rows($que);
                    ?>
            <div style="width: 95%; margin-left: 15px; border:2px solid blue; ">
                <div style="width: 100%; border:2px solid blue;">
                    <img src="img/buscar.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">
                    <h1 style="display: inline-block;">Encontradas: <?php echo $contacat; ?></h1>
                </div>
                <?php
                            foreach ($result as $key => $row) {
                                ?>
                    <div style="width: 95%; margin-left: 3px;">
                        <div style="display: inline-block; ">
                            <img src="data:image/jpg;base64, <?php echo base64_encode($row['imagen']); ?>" style="width: 90px; height: 105px; <?php if ($_SESSION['rolusu'] == "a1") { ?> margin-top: -60px; <?php } elseif ($_SESSION['rolusu'] == "empresa") { ?>margin-top: -60px; <?php } ?>">
                        </div>
                        <div style="display: inline-block;">
                            <p style="color:blue; font-size: 22px;"><strong><?php echo sed::decryption($row['nombrecateg']); ?></strong></p>
                            <p style="margin-top: -15px;">Fecha registro: <strong><?php echo $row['fecharegistro_categ']; ?></strong></p>
                            <!--<a class="btn btn-primary" href="verproducto.php?idproducto=<?php echo $row['idcategoria']; ?>" style="width:150px; display: inline-block;" role="button" value="Ver torta">
                            <strong>Ver</strong>
                        </a>-->
                            <a class="btn btn-primary" href="admeditcateg.php?id=<?php echo $row['idcategoria']; ?>&ft=1" style="width:110px; display: inline-block; margin-top:-14px;" role="button" value="Ver torta">
                                <strong> Editar</strong>
                            </a>
                            <form action="" method="post" style="width:110px; display: inline-block; margin-top: -14px;">
                                <input type="hidden" name="idcateg" value="<?php echo $row['idcategoria']; ?>">
                                <input type="submit" style="width:150px; margin-top: -14px;" class="btn btn-danger" name="eliminarcateg" value="Eliminar">
                            </form>
                            <?php
                                            if (isset($_POST['eliminarcateg'])) {
                                                $idtorta = $_POST['idcateg'];
                                                $sqlborrar = "DELETE FROM categoria WHERE idcategoria=$idtorta";
                                                $resborrar = mysqli_query($mysqli, $sqlborrar);
                                                if ($resborrar) {
                                                    echo '<div class="alert alert-primary" role="alert">Eliminado exitosamente. </div>';
                                                    echo "<script>location.href='adm.php?vercategoria=1'</script>";
                                                } else {
                                                    echo "Error: " . $sqlborrar . "<br>" . mysqli_error($mysqli);
                                                    //echo "<script>location.href='registro.php'</script>";
                                                }
                                            }
                                            ?>
                        </div>
                    </div>
                    <div style="width: 90%; margin-left: 6px; background: blue; height: 3px; margin-top: 3px;"></div>
                <?php } ?>
            </div><br>

        <?php } else if (@!$result) {
                    //echo "no se encontró el resultado"; 
                    ?>
            <div class="container container-web-page ">
                <div class="row justify-content-md-center border-primary" style="background-color: orange;border-radius: 35px; width: 100%; margin-left: 0;">
                    <div class="col-12 col-md-6">
                        <figure class="full-box">
                            <center>
                                <img src="img/buscar.png" alt="registration_killaripostres" class="img-fluid">
                            </center>
                        </figure>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 col-md-6">
                        <h3 style="color:white;" class="text-center text-uppercase poppins-regular font-weight-bold">
                            <strong>No se encontró. </strong></h3>

                        <p class="text-justify">
                            <center>
                                <strong style="color:white;">
                                    intente buscar nuevamente correctamente.
                                </strong>

                            </center>
                        </p>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } else {
            //echo "no se dio click"; 
            ?>
        <div style="width: 95%; margin-left: 12px; border:2px solid blue;">
            <div style="width: 100%; border:2px solid blue;">
                <h1 style="display: inline-block; font-size: 18px;">Categorias registradas: <?php echo $cantidcate; ?></h1>
            </div>

            <?php
                    foreach ($categori as $row) {
                        $id_categ = $row['idcategoria'];
                        $imag_categ = base64_encode($row['imagen']);
                        $nombre_categ = sed::decryption($row['nombrecateg']);
                        $descripcion_categ = sed::decryption($row['descripcioncateg']);
                        ?>
                <div style="width: 99%; margin-left: 4px;">
                    <div style="display: inline-block; ">
                        <img src="data:image/jpg;base64,<?php echo $imag_categ; ?>" style="width: 96px; height: 115px; <?php if ($_SESSION['rolusu'] == "a1") { ?> margin-top: -60px; <?php } elseif ($_SESSION['rolusu'] == "empresa") { ?>margin-top: -105px; <?php } ?>">
                    </div>
                    <div style="display: inline-block;">
                        <p style="">Código: <strong><?php echo sed::decryption($row['codigocate']); ?></strong></p>
                        <p style="margin-top: -10px; color:blue; font-size: 14px;"><strong><?php echo $nombre_categ; ?></strong></p>
                        <p style="margin-top: -10px;">Fecha registro: <strong><?php echo $row['fecharegistro_categ']; ?></strong></p>
                        <a class="btn btn-primary" href="admeditcateg.php?id=<?php echo $id_categ; ?>&ft=1" style="width:110px; display: inline-block;" role="button" value="Ver torta">
                            <strong> Editar</strong>
                        </a>
                        <form action="" method="post" style="width:110px; display: inline-block; margin-top: -3px;">
                            <input type="hidden" name="idcateg" value="<?php echo $id_categ; ?>">
                            <input type="submit" style="width:150px; margin-top: 4px;" class="btn btn-danger" name="eliminarcateg" value="Eliminar">
                        </form>
                        <?php
                                    if (isset($_POST['eliminarcateg'])) {
                                        $idtorta = $_POST['idcateg'];
                                        $sqlborrar = "DELETE FROM categoria WHERE idcategoria=$idtorta";
                                        $resborrar = mysqli_query($mysqli, $sqlborrar);
                                        if ($resborrar) {
                                            echo '<div class="alert alert-primary" role="alert">Eliminado exitosamente. </div>';
                                            echo "<script>location.href='adm.php?vercategoria=1'</script>";
                                        } else {
                                            echo "Error: " . $sqlborrar . "<br>" . mysqli_error($mysqli);
                                            //echo "<script>location.href='registro.php'</script>";
                                        }
                                    }
                                    ?>
                        <!--<a class="btn btn-danger" href="admregistorta.php?id_torta=<?php //echo $id_torta; 
                                                                                                    ?>&eliminar=1" style="width:110px; display: inline-block;" role="button" value="Ver torta">
                                <strong> Eliminar</strong>
                            </a>-->
                    </div>
                </div>
                <div style="width: 90%; margin-left: 16px; background: blue; height: 3px; margin-top: 4px;"></div>
            <?php } ?>
        <?php } ?>
    <?php
    } else {
        ?>
        <div class="container container-web-page ">
            <div class="row justify-content-md-center border-primary" style="background-color: orange;border-radius: 35px; width: 100%; margin-left: 0;">
                <div class="col-12 col-md-6">
                    <figure class="full-box">
                        <center>
                            <img src="img/favorito.png" alt="registration_killaripostres" class="img-fluid">
                        </center>
                    </figure>
                </div>
                <div class="w-100"></div>
                <div class="col-12 col-md-6">
                    <h3 style="color:white;" class="text-center text-uppercase poppins-regular font-weight-bold">
                        <strong>Categorias</strong></h3>

                    <p class="text-justify">
                        <center>
                            <strong style="color:white;">
                                Aquí se mostrarán las categorias que registres en el formulario.</strong>

                        </center>
                    </p>
                </div>
            </div>
        </div>
    <?php
    }
    ?>