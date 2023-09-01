<?php
if (@!$_SESSION['idusu']) {
    echo "<script>location.href='logueo.php'</script>";
} elseif ($_SESSION['rolusu'] == "a1") {
    /*¡if ((time() - $_SESSION['last_login_timestamp']) > 240) { // 900 = 15 * 60  
        setcookie("cerrarsesion", 1, time() + 60000); //6o segundos es 1 minuto, 86400 segundos es por 24 horas
        echo "<script>location.href='desconectar.php'</script>";
    } else {
        $_SESSION['last_login_timestamp'] = time();
    }*/ } else {
    echo "<script>location.href='logueo.php'</script>";
}
?>
<form style="margin-left: 18px; display: inline-block;" class="form-inline my-2 my-lg-0 align-self-stretch" name="buscador" action="adm.php?empresas=1" method="POST">
    <input class="form-control mr-sm-2" style="width: 200px;" type="text" name="word" placeholder="Buscar" aria-label="Search" />
    <button class="btn btn-success my-2 my-sm-0" style="width: 67px;" name="buscarcliente" alue="Buscar" type="submit">
        Buscar
    </button>
</form>
<a href="listareporteproducto.php" class="btn btn-primary" style="display: inline-block; color:white; margin-left:4px;">
    <img src="img/pdf.png" style="width: 30px; height: 30px;"> ver como PDF
</a>
<div style="width: 92%; height: 2px; margin-top:4px; margin-left: 16px;"></div>
<?php
require 'class/bookempresa.php';
$word = sed::encryption(@$_POST['word']);
$objBook = new Bookempresa();
$words = explode(' ', $word);
$num = count($words);
$result = $objBook->buscar($word, $num);
include_once('class/database.php');
$rolusu = sed::encryption("a1");
$query = "SELECT*FROM logueo_empresa INNER JOIN rol
on logueo_empresa.codigorol = rol.codigorol 
where rol != '$rolusu' and estado != 0 ORDER BY logueo_empresa.id_empresa DESC";
$resul_cant = mysqli_query($mysqli, $query);
$cantiduser = mysqli_num_rows($resul_cant);
$reserva = mysqli_fetch_all($resul_cant, MYSQLI_ASSOC);
if ($cantiduser > 0) {
    ?>
    <?php if (isset($_POST['buscarcliente'])) { ?>
        <?php
                if (@$result) {
                    $rolcliente = sed::encryption("a1");
                    $Busca_u = 'SELECT * FROM logueo_empresa
                    INNER JOIN rol on logueo_empresa.codigorol = rol.codigorol 
                     WHERE estado=1 and nombreempresa LIKE "% ' . $word . '%" '
                        . 'OR nombreempresa LIKE "%' . $word . '%"'
                        . 'OR direccionempresa LIKE "%' . $word . '%"'
                        . 'OR username_empresa LIKE "%' . $word . '%"';
                    $que = mysqli_query($conexion, $Busca_u);
                    $contabusca = mysqli_num_rows($que);
                    ?>
            <div style="width: 96%; margin-left: 10px; border:2px solid blue;">
                <div style="width: 100%; border:2px solid blue;">
                    <img src="img/useregis.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">
                    <h1 style="display: inline-block; font-size: 16px;">Empresas encontrados: <?php echo $contabusca; ?></h1>
                </div>
                <?php
                            foreach ($result as $key => $row) {
                                $idlogi = $row['id_empresa'];
                                $imagperfi = base64_encode($row['imagempresa']);
                                $nombre = ucwords(sed::decryption($row['nombreempresa']));
                                $Celular = $row['celularempresa'];
                                $fecharegistro = $row['fecharegistro_empresa'];
                                $estado = $row['estado'];
                                $codciud = $row['codciudad'];
                                $sqlci = "SELECT * FROM ciudad where codciudad ='$codciud' group by ciudad ORDER BY idciudad DESC";
                                $resultadoci = mysqli_query($conexion, $sqlci);
                                $ciud = mysqli_fetch_all($resultadoci, MYSQLI_ASSOC);
                                foreach ($ciud as $rowciu) {
                                    $codciuda = $rowciu['codciudad'];
                                    $nombreciuda = sed::decryption($rowciu['ciudad']);
                                }
                                ?>
                    <div style="width: 96%; margin-left: 8px;">
                        <div style="display: inline-block; ">
                            <?php if ($imagperfi) { ?>
                                <img src="data:image/jpg;base64, <?php echo $imagperfi; ?>" style="width: 70px; height: 120px;border: 2px solid green; margin-top: -115px;" alt="login">
                            <?php } else { ?>
                                <img src="img/fotoperfil.png" style="width: 65px; height: 120px;border: 2px solid green; margin-top: -95px;" alt="login">
                            <?php } ?>
                        </div>
                        <div style="display: inline-block;">
                            <p style="color:blue; font-size:14px;"><strong><?php echo $nombre;  ?></strong></p>
                            <p style="margin-top: -10px; font-size:14px;"><strong>Ciudad: <?php if (!empty($rowciu['codciudad'])) {
                                                                                                                echo sed::decryption($rowciu['ciudad']);
                                                                                                            } else {
                                                                                                                echo "No agregó ciudad";
                                                                                                            } ?></strong></p>
                            <p style="margin-top: -10px; font-size:13px;"><strong> Estado:
                                    <?php if ($estado == 1) {
                                                        echo "Habilitado";
                                                    } else if ($estado == 2) {
                                                        echo "Baneado";
                                                    } ?></strong></p>
                            <p style="margin-top: -10px; color:blue; font-size:13px;">
                                <img src="img/reserv.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">
                                <strong><?php echo $fecharegistro; ?><strong>
                            </p>
                            <a class="btn btn-primary" href="admverusuarios.php?id=<?php echo $idlogi ?>&empresas=1" style="width:80px; display: inline-block; margin-top: -10px;" role="button">
                                <strong> Ver</strong>
                            </a>
                            <form action="" method="post" style="width:110px; display: inline-block; margin-top: -30px;">
                                <input type="hidden" name="idempresa" value="<?php echo $row['id_empresa']; ?>">
                                <?php if ($row['estado'] == 1) {
                                                    ?>
                                    <input type="submit" style="width:150px; margin-top: -10px;" class="btn btn-danger" name="banear_empresa" value="Banear">
                                <?php } else if ($row['estado'] == 2) {
                                                    ?>
                                    <input type="submit" style="width:150px; margin-top: -10px; color:white;" class="btn btn-warning" name="activar_empresa" value="Habilitar">
                                <?php } ?>
                            </form>
                            <?php
                                            if (isset($_POST['banear_empresa'])) {
                                                $idempresa = $_POST['idempresa'];
                                                $sqlbanear = "UPDATE logueo_empresa SET estado= '2' WHERE id_empresa='$idempresa'";
                                                $resbanear = mysqli_query($mysqli, $sqlbanear);
                                                if ($resbanear) {
                                                    echo '<div class="alert alert-primary" role="alert">Baneado exitosamente. </div>';
                                                    echo "<script>location.href='adm.php?empresas=1'</script>";
                                                } else {
                                                    echo "Error: " . $sqlbanear . "<br>" . mysqli_error($mysqli);
                                                    //echo "<script>location.href='registro.php'</script>";
                                                }
                                            } elseif (isset($_POST['activar_empresa'])) {
                                                $idempresa = $_POST['idempresa'];
                                                $sqlactivar = "UPDATE logueo_empresa SET estado= '1' WHERE id_empresa='$idempresa'";
                                                $resactivar = mysqli_query($mysqli, $sqlactivar);
                                                if ($resactivar) {
                                                    echo '<div class="alert alert-primary" role="alert">Habilitado exitosamente. </div>';
                                                    echo "<script>location.href='adm.php?empresas=1'</script>";
                                                } else {
                                                    echo "Error: " . $sqlactivar . "<br>" . mysqli_error($mysqli);
                                                    //echo "<script>location.href='registro.php'</script>";
                                                }
                                            }
                                            ?>
                        </div>
                    </div>
                    <div style="width: 90%; margin-left: 16px; background:blue; height: 3px; margin-top: 4px;"></div>
                <?php } ?>
            </div>
        <?php } elseif (@!$result) {
                    ?>
            <div class="container container-web-page ">
                <div class="row justify-content-md-center border-primary" style="background-color: orange;border-radius: 35px; width: 100%; margin-left: 0;">
                    <div class="col-12 col-md-6">
                        <figure class="full-box">
                            <center>
                                <img src="img/Buscar.png" alt="registration_killaripostres" class="img-fluid">
                            </center>
                        </figure>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 col-md-6">
                        <h3 style="color:white;" class="text-center text-uppercase poppins-regular font-weight-bold">
                            <strong>No se encontró</strong></h3>

                        <p class="text-justify">
                            <center>
                                <strong style="color:white;">
                                    No se encontró, busque nuevamente.</strong>

                            </center>
                        </p>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div style="width: 96%; margin-left: 10px; border:2px solid blue;">
            <div style="width: 100%; border:2px solid blue;">
                <img src="img/useregis.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">
                <h1 style="display: inline-block; font-size: 16px;">Empresas registrados: <?php echo $cantiduser; ?></h1>
            </div>
            <?php
                    foreach ($reserva as $row) {
                        $id = $row['id_empresa'];
                        $imagperfi = base64_encode($row['imagempresa']);
                        $nombre = ucwords(sed::decryption($row['nombreempresa']));
                        $Celular = $row['celularempresa'];
                        $fecharegistro = $row['fecharegistro_empresa'];
                        $estado = $row['estado'];
                        $codciud = $row['codciudad'];
                        $sqlci = "SELECT * FROM ciudad where codciudad ='$codciud' group by ciudad ORDER BY idciudad DESC";
                        $resultadoci = mysqli_query($conexion, $sqlci);
                        $ciud = mysqli_fetch_all($resultadoci, MYSQLI_ASSOC);
                        foreach ($ciud as $rowciu) {
                            $codciuda = $rowciu['codciudad'];
                            $nombreciuda = sed::decryption($rowciu['ciudad']);
                        }
                        ?>
                <div style="width: 96%; margin-left: 8px;">
                    <div style="display: inline-block; ">
                        <?php if ($imagperfi) { ?>
                            <img src="data:image/jpg;base64, <?php echo $imagperfi; ?>" style="width: 70px; height: 120px;border: 2px solid green; margin-top: -115px;" alt="login">
                        <?php } else { ?>
                            <img src="img/fotoperfil.png" style="width: 65px; height: 120px;border: 2px solid green; margin-top: -95px;" alt="login">
                        <?php } ?>
                    </div>
                    <div style="display: inline-block;">
                        <p style="color:blue; font-size:14px;"><strong><?php echo $nombre;  ?></strong></p>
                        <p style="margin-top: -10px; font-size:14px;"><strong>Ciudad: <?php if (!empty($rowciu['codciudad'])) {
                                                                                                        echo sed::decryption($rowciu['ciudad']);
                                                                                                    } else {
                                                                                                        echo "No agregó ciudad";
                                                                                                    } ?></strong></p>
                        <p style="margin-top: -10px; font-size:13px;"><strong> Estado:
                                <?php if ($estado == 1) {
                                                echo "Habilitado";
                                            } else if ($estado == 2) {
                                                echo "Baneado";
                                            } ?></strong></p>
                        <p style="margin-top: -10px; color:blue; font-size:13px;">
                            <img src="img/reserv.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">
                            <strong><?php echo $fecharegistro; ?><strong>
                        </p>
                        <a class="btn btn-primary" href="admverusuarios.php?id=<?php echo $row['id_empresa']; ?>&empresas=1" style="width:80px; display: inline-block; margin-top: -10px;" role="button">
                            <strong> Ver</strong>
                        </a>
                        <form action="" method="post" style="width:110px; display: inline-block; margin-top: -30px;">
                            <input type="hidden" name="idempresa" value="<?php echo $row['id_empresa']; ?>">
                            <?php if ($row['estado'] == 1) {
                                            ?>
                                <input type="submit" style="width:150px; margin-top: -10px;" class="btn btn-danger" name="banear_empresa" value="Banear">
                            <?php } else if ($row['estado'] == 2) {
                                            ?>
                                <input type="submit" style="width:150px; margin-top: -10px; color:white;" class="btn btn-warning" name="activar_empresa" value="Habilitar">
                            <?php } ?>
                        </form>
                        <?php
                                    if (isset($_POST['banear_empresa'])) {
                                        $idempresa = $_POST['idempresa'];
                                        $sqlbanear = "UPDATE logueo_empresa SET estado= '2' WHERE id_empresa='$idempresa'";
                                        $resbanear = mysqli_query($mysqli, $sqlbanear);
                                        if ($resbanear) {
                                            echo '<div class="alert alert-primary" role="alert">Baneado exitosamente. </div>';
                                            echo "<script>location.href='adm.php?empresas=1'</script>";
                                        } else {
                                            echo "Error: " . $sqlbanear . "<br>" . mysqli_error($mysqli);
                                            //echo "<script>location.href='registro.php'</script>";
                                        }
                                    } elseif (isset($_POST['activar_empresa'])) {
                                        $idempresa = $_POST['idempresa'];
                                        $sqlactivar = "UPDATE logueo_empresa SET estado= '1' WHERE id_empresa='$idempresa'";
                                        $resactivar = mysqli_query($mysqli, $sqlactivar);
                                        if ($resactivar) {
                                            echo '<div class="alert alert-primary" role="alert">Habilitado exitosamente. </div>';
                                            echo "<script>location.href='adm.php?empresas=1'</script>";
                                        } else {
                                            echo "Error: " . $sqlactivar . "<br>" . mysqli_error($mysqli);
                                            //echo "<script>location.href='registro.php'</script>";
                                        }
                                    }
                                    ?>
                    </div>
                </div>
                <div style="width: 90%; margin-left: 16px; background:blue; height: 3px; margin-top: 4px;"></div>
            <?php } ?>
        </div>
    <?php } ?>
<?php } else { ?>
    <div class="container container-web-page ">
        <div class="row justify-content-md-center border-primary" style="background-color: orange;border-radius: 35px; width: 100%; margin-left: 0;">
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
                    <strong>Empresas aceptadas</strong></h3>

                <p class="text-justify">
                    <center>
                        <strong style="color:white;">
                            Aquí se mostrarán las empresas que se aceptadas de las solicitudes.</strong>

                    </center>
                </p>
            </div>
        </div>
    </div>
<?php } ?>