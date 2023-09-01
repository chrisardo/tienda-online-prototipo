<form style="margin-left: 18px;" class="form-inline my-2 my-lg-0 align-self-stretch" name="buscador" action="adm.php?verciudad=1" method="POST">
    <input class="form-control mr-sm-2" style="width: 200px;" type="text" name="word" placeholder="Buscar ciudad" aria-label="Search" />
    <button class="btn btn-success my-2 my-sm-0" style="width: 67px;" name="buscarciudad" value="Buscar" type="submit">
        Buscar
    </button>
</form>
<?php
require 'class/bookciudad.php';
$word = sed::encryption(@$_POST['word']);
$objBook = new Bookciudad();
$words = explode(' ', $word);
$num = count($words);
$result = $objBook->buscar($word, $num);
include_once('class/database.php');
$query = "SELECT*FROM ciudad ORDER BY codciudad DESC";

//$query = "SELECT*FROM logueo where rolusu != '$rolusu' ORDER BY logueo.idusu DESC";
$resul_cant = mysqli_query($mysqli, $query);
$cantidciudad = mysqli_num_rows($resul_cant);
$ciuda = mysqli_fetch_all($resul_cant, MYSQLI_ASSOC);
if ($cantidciudad > 0) {
    ?>
    <?php if (isset($_POST['buscarciudad'])) {
            //echo "se dio click"; 
            ?>
        <?php
                if (@$result) {
                    $Busca = 'SELECT * FROM ciudad 
                    WHERE codciudad LIKE "% ' . $word . '%" '
                        . 'OR codciudad LIKE "%' . $word . '%"'
                        . 'OR ciudad LIKE "%' . $word . '%"';
                    $que = mysqli_query($conexion, $Busca);
                    $contaciudad= mysqli_num_rows($que);
                    ?>
            <div style="width: 95%; margin-left: 15px; border:2px solid blue; ">
                <div style="width: 100%; border:2px solid blue;">
                    <img src="img/buscar.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">
                    <h1 style="display: inline-block;">Encontradas: <?php echo $contaciudad; ?></h1>
                </div>
                <?php
                            foreach ($result as $key => $row) {
                                ?>
                    <div style="width: 95%; margin-left: 3px;">
                        <div style="display: inline-block;">
                            <p style="color:blue; font-size: 22px;"><strong>Código ciudad: <?php echo $row['codciudad']; ?></strong></p>
                            <p style="margin-top: -15px;">Rol: <strong>
                                    <?php echo sed::decryption($row['ciudad']);?></strong>
                            </p>

                            <div style="margin-left: 4px; margin-top: -3px;">
                                <div style="display: inline-block; ">
                                    <a class="btn btn-primary" href="admeditciudad.php?id=<?php echo $row['idciudad'];
                                                                                                            ?>&ft=1" style="width:100px;" role="button" value="Ver torta">
                                        <strong> Editar</strong>
                                    </a>
                                </div>
                                <div style="display: inline-block;">
                                    <form action="" method="post" style="width:110px; ">
                                        <input type="hidden" name="idciudad" value="<?php echo $row['idciudad']; ?>">
                                        <input type="submit" style="width:150px; margin-top: 4px;" class="btn btn-danger" name="eliminarciudad" value="Eliminar">
                                    </form>
                                    <?php
                                                    if (isset($_POST['eliminarciudad'])) {
                                                        $idrol = $_POST['idrol'];
                                                        $sqlborrar = "DELETE FROM ciudad WHERE idciudad=$idrol";
                                                        $resborrar = mysqli_query($mysqli, $sqlborrar);
                                                        if ($resborrar) {
                                                            echo '<div class="alert alert-primary" role="alert">Eliminado exitosamente. </div>';
                                                            echo "<script>location.href='adm.php?verciudad=1'</script>";
                                                        } else {
                                                            echo "Error: " . $sqlborrar . "<br>" . mysqli_error($mysqli);
                                                            //echo "<script>location.href='registro.php'</script>";
                                                        }
                                                    }
                                                    ?>
                                </div>
                            </div>
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
                    </div>2
                </div>
            </div>
        <?php } ?>
    <?php } else {
            //echo "no se dio click"; 
            ?>
        <div style="width: 95%; margin-left: 12px; border:2px solid blue;">
            <div style="width: 100%; border:2px solid blue;">
                <h1 style="display: inline-block; font-size: 18px;">Ciudades registrados: <?php echo $cantidciudad; ?></h1>
            </div>

            <?php
                    foreach ($ciuda as $row) {
                        $idciudad = $row['idciudad'];
                        ?>
                <div style="width: 99%; margin-left: 4px;">
                    <!--<div style="display: inline-block; ">
                    </div>-->
                    <div style="display: inline-block;">
                        <p style="color:blue; font-size: 14px;">Código:<strong><?php echo  $row['codciudad']; ?></strong></p>
                        <p style="margin-top: -10px;">Ciudad:
                            <strong>
                                <?php echo sed::decryption($row['ciudad']); ?></strong>
                        </p>
                        <div style="margin-left: 4px; margin-top: -3px;">
                            <div style="display: inline-block; ">
                                <a class="btn btn-primary" href="admeditciudad.php?id=<?php echo $row['idciudad'];
                                                                                                    ?>&ft=1" style="width:100px;" role="button" value="Ver torta">
                                    <strong> Editar</strong>
                                </a>
                            </div>
                            <div style="display: inline-block;">
                                <form action="" method="post" style="width:110px; ">
                                    <input type="hidden" name="idrol" value="<?php echo $idciudad; ?>">
                                    <input type="submit" style="width:150px;" class="btn btn-danger" name="eliminarciudad" value="Eliminar">
                                </form>
                                <?php
                                            if (isset($_POST['eliminarciudad'])) {
                                                $idciudad = $_POST['idciudad'];
                                                $sqlborrar = "DELETE FROM ciudad WHERE idciudad=$idciudad";
                                                $resborrar = mysqli_query($mysqli, $sqlborrar);
                                                if ($resborrar) {
                                                    echo '<div class="alert alert-primary" role="alert">Eliminado exitosamente. </div>';
                                                    echo "<script>location.href='adm.php?verciudad=1'</script>";
                                                } else {
                                                    echo "Error: " . $sqlborrar . "<br>" . mysqli_error($mysqli);
                                                    //echo "<script>location.href='registro.php'</script>";
                                                }
                                            }
                                            ?>
                            </div>
                        </div>
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