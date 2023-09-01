<form class="form-inline my-2 my-lg-0 align-self-stretch" name="buscador" action="adm.php?verrepartidor=1" method="POST">
    <input class="form-control mr-sm-2" style="width: 200px;" type="text" name="word" placeholder="Buscar " aria-label="Search" />
    <button class="btn btn-success my-2 my-sm-0" style="width: 67px;" name="buscarepartidor" value="Buscar" type="submit">
        Buscar
    </button>
</form>
<div style="width: 92%; height: 2px; margin-top:4px; margin-left: 16px;"></div>
<?php
require 'class/bookrepartidor.php';
$word = sed::encryption(@$_POST['word']);
$objBook = new Bookrepartidor();
$words = explode(' ', $word);
$num = count($words);
$result = $objBook->buscar($word, $num);
include_once('class/database.php');
$query = "SELECT*FROM logueo_repartidor ORDER BY id_repartidor DESC";
$resul_cant = mysqli_query($mysqli, $query);
$cantiduser = mysqli_num_rows($resul_cant);
$repartidore = mysqli_fetch_all($resul_cant, MYSQLI_ASSOC);
if ($cantiduser > 0) {
    ?>
    <?php if (isset($_POST['buscarepartidor'])) { ?>
        <?php
                if (@$result) {
                    $Busca_u = 'SELECT * FROM logueo_repartidor WHERE nombre_repartidor LIKE "% ' . $word . '%" '
                        . 'OR nombre_repartidor LIKE "%' . $word . '%"'
                        . 'OR apellido_repartidor LIKE "%' . $word . '%"'
                        . 'OR direcci_repartidor LIKE "%' . $word . '%"';
                    $que = mysqli_query($conexion, $Busca_u);
                    $contabusca = mysqli_num_rows($que);
                    ?>
            <div style="width: 96%; margin-left: 10px; border:2px solid blue;">
                <div style="width: 100%; border:2px solid blue;">
                    <img src="img/useregis.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">
                    <h1 style="display: inline-block; font-size: 16px;">Resultado de búsqueda: <?php echo $contabusca; ?></h1>
                </div>
                <?php
                            foreach ($result as $key => $row) {
                                $idrepartidor = $row['id_repartidor']
                                ?>
                    <div style="width: 96%; margin-left: 8px;">
                        <div style="display: inline-block; ">
                            <?php if (base64_encode($row['imagperfil'])) { ?>
                                <img src="data:image/jpg;base64, <?php echo base64_encode($row['imagperfil']); ?>" style="width: 70px; height: 120px; margin-top: -95px;" alt="login">
                            <?php } else { ?>
                                <img src="img/fotoperfil.png" style="width: 65px; height: 120px; margin-top: -95px;" alt="login">
                            <?php } ?>
                        </div>
                        <div style="display: inline-block;">
                            <p style="color:blue; font-size:14px;"><strong><?php echo sed::decryption($row['nombre_repartidor']) . "" . sed::decryption($row['apellido_repartidor']);  ?></strong></p>
                            <p style="margin-top: -10px; font-size:14px;"><strong>Genero: <?php echo sed::decryption($row['genero_repartidor']); ?></strong></p>
                            <p style="margin-top: -10px; font-size:13px;"><strong> Estado:
                                    <?php if ($row['baneo'] == 0) {
                                                        echo "Activo";
                                                    } else if ($row['baneo'] == 1) {
                                                        echo "baneado";
                                                    } ?></strong></p>
                            <p style="margin-top: -10px; color:blue; font-size:13px;">
                                <img src="img/reserv.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">
                                <strong><?php echo $row['fecharegistro_repartidor']; ?><strong>
                            </p>
                            <a class="btn btn-primary" href="admeditrepartidor.php?id=<?php echo $row['id_repartidor']; ?>" style="width:80px; display: inline-block; margin-top: -10px;" role="button">
                                <strong> Ver</strong>
                            </a>
                            <form action="" method="post" style="width:110px; display: inline-block; margin-top: -30px;">
                                <input type="hidden" name="idrepartidor" value="<?php echo $row['id_repartidor']; ?>">
                                <?php if ($row['baneo'] == 0) {
                                                    ?>
                                    <input type="submit" style="width:150px; margin-top: -10px;" class="btn btn-danger" name="banear_repartidor" value="Banear">
                                <?php } else if ($row['baneo'] == 1) {
                                                    ?>
                                    <input type="submit" style="width:150px; margin-top: -10px; color:white;" class="btn btn-warning" name="activar_repartidor" value="Habilitar">
                                <?php } ?>
                            </form>
                            <?php
                                            if (isset($_POST['banear_repartidor'])) {
                                                $idrepartido = $_POST['idrepartidor'];
                                                $sqlbanear = "UPDATE logueo_repartidor SET baneo= '1' WHERE id_repartidor='$idrepartido'";
                                                $resbanear = mysqli_query($mysqli, $sqlbanear);
                                                if ($resbanear) {
                                                    echo '<div class="alert alert-primary" role="alert">Baneado exitosamente. </div>';
                                                    echo "<script>location.href='adm.php?verrepartidor=1'</script>";
                                                } else {
                                                    echo "Error: " . $sqlbanear . "<br>" . mysqli_error($mysqli);
                                                    //echo "<script>location.href='registro.php'</script>";
                                                }
                                            } elseif (isset($_POST['activar_repartidor'])) {
                                                $idrepartido = $_POST['idrepartidor'];
                                                $sqlactivar = "UPDATE logueo_repartidor SET baneo= '0' WHERE id_repartidor='$idrepartido'";
                                                $resactivar = mysqli_query($mysqli, $sqlactivar);
                                                if ($resactivar) {
                                                    echo '<div class="alert alert-primary" role="alert">Baneado exitosamente. </div>';
                                                    echo "<script>location.href='adm.php?verrepartidor=1'</script>";
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
                            <strong>No se encontró</strong></h3>

                        <p class="text-justify">
                            <center>
                                <strong style="color:white;">
                                    Intente buscar nuevamente.</strong>

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
                <h1 style="display: inline-block; font-size: 16px;">Repartidores registrados: <?php echo $cantiduser; ?></h1>
            </div>
            <?php
                    foreach ($repartidore as $row) {
                        $idrepartidor = $row['id_repartidor'];
                        ?>
                <div style="width: 96%; margin-left: 8px;">
                    <div style="display: inline-block; ">
                        <?php if (base64_encode($row['imagperfil'])) { ?>
                            <img src="data:image/jpg;base64, <?php echo base64_encode($row['imagperfil']); ?>" style="width: 70px; height: 120px; margin-top: -95px;" alt="login">
                        <?php } else { ?>
                            <img src="img/fotoperfil.png" style="width: 65px; height: 120px; margin-top: -95px;" alt="login">
                        <?php } ?>
                    </div>
                    <div style="display: inline-block;">
                        <p style="color:blue; font-size:14px;"><strong><?php echo sed::decryption($row['nombre_repartidor']) . "" . sed::decryption($row['apellido_repartidor']);  ?></strong></p>
                        <p style="margin-top: -10px; font-size:14px;"><strong>Genero: <?php echo sed::decryption($row['genero_repartidor']); ?></strong></p>
                        <p style="margin-top: -10px; font-size:13px;"><strong> Estado:
                                <?php if ($row['baneo'] == 0) {
                                                echo "Activo";
                                            } else if ($row['baneo'] == 1) {
                                                echo "baneado";
                                            } ?></strong></p>
                        <p style="margin-top: -10px; color:blue; font-size:13px;">
                            <img src="img/reserv.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">
                            <strong><?php echo $row['fecharegistro_repartidor']; ?><strong>
                        </p>
                        <a class="btn btn-primary" href="admeditrepartidor.php?id=<?php echo $row['id_repartidor']; ?>" style="width:80px; display: inline-block; margin-top: -10px;" role="button">
                            <strong> Ver</strong>
                        </a>
                        <form action="" method="post" style="width:110px; display: inline-block; margin-top: -30px;">
                            <input type="hidden" name="idrepartidor" value="<?php echo $row['id_repartidor']; ?>">
                            <?php if ($row['baneo'] == 0) {
                                            ?>
                                <input type="submit" style="width:150px; margin-top: -10px;" class="btn btn-danger" name="banear_repartidor" value="Banear">
                            <?php } else if ($row['baneo'] == 1) {
                                            ?>
                                <input type="submit" style="width:150px; margin-top: -10px; color:white;" class="btn btn-warning" name="activar_repartidor" value="Habilitar">
                            <?php } ?>
                        </form>
                        <?php
                                    if (isset($_POST['banear_repartidor'])) {
                                        $idrepartido = $_POST['idrepartidor'];
                                        $sqlbanear = "UPDATE logueo_repartidor SET baneo= '1' WHERE id_repartidor='$idrepartido'";
                                        $resbanear = mysqli_query($mysqli, $sqlbanear);
                                        if ($resbanear) {
                                            echo '<div class="alert alert-primary" role="alert">Baneado exitosamente. </div>';
                                            echo "<script>location.href='adm.php?verrepartidor=1'</script>";
                                        } else {
                                            echo "Error: " . $sqlbanear . "<br>" . mysqli_error($mysqli);
                                            //echo "<script>location.href='registro.php'</script>";
                                        }
                                    } elseif (isset($_POST['activar_repartidor'])) {
                                        $idrepartido = $_POST['idrepartidor'];
                                        $sqlactivar = "UPDATE logueo_repartidor SET baneo= '0' WHERE id_repartidor='$idrepartido'";
                                        $resactivar = mysqli_query($mysqli, $sqlactivar);
                                        if ($resactivar) {
                                            echo '<div class="alert alert-primary" role="alert">Habilitado exitosamente. </div>';
                                            echo "<script>location.href='adm.php?verrepartidor=1'</script>";
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
                    <strong>REPARTIDORES REGISTRADOS</strong></h3>

                <p class="text-justify">
                    <center>
                        <strong style="color:white;">
                            Aquí se mostrarán los repartidores que se registran.</strong>

                    </center>
                </p>
            </div>
        </div>
    </div>
<?php } ?>