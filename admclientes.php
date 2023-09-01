<?php
session_start();
if (@!$_SESSION['idusu']) {
    echo "<script>location.href='logueo.php'</script>";
} elseif ($_SESSION['rolusu'] == "a1") {
    /*if ((time() - $_SESSION['last_login_timestamp']) > 240) { // 900 = 15 * 60  
        setcookie("cerrarsesion", 1, time() + 60000); //6o segundos es 1 minuto, 86400 segundos es por 24 horas
        echo "<script>location.href='desconectar.php'</script>";
    } else {
        $_SESSION['last_login_timestamp'] = time();
    }*/ } else {
    echo "<script>location.href='logueo.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Clientes | RestaurantApp</title>
    <link rel="icon" href='img/logo.png' sizes="32x32" type="img/jpg" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css2/style.css" />
</head>

<body>
    <?php
    require("connectdb.php");
    include("conexion.php");
    include 'sed.php';
    extract($_GET);
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
        <div class="container-fluid">
            <a class="" href="adm.php">
                <img src="img/atras.png" style="width: 30px; height: 40px;">
            </a>
            <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 15px;" href="#">
                <img src="img/logo.png" style="width: 30px; height: 30px;" alt="logo restaurantapp">
                <strong>Perikos</strong>
            </a>
        </div>
    </nav>
    <br><br><br>
    <form style="margin-left: 18px; display: inline-block;" class="form-inline my-2 my-lg-0 align-self-stretch" name="buscador" action="admclientes.php" method="POST">
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
    require 'class/bookusuario.php';
    $word = sed::encryption(@$_POST['word']);
    $objBook = new Bookusuario();
    $words = explode(' ', $word);
    $num = count($words);
    $result = $objBook->buscar($word, $num);
    include_once('class/database.php');
    $rolusu = sed::encryption("a1");
    $query = "SELECT*FROM logueo INNER JOIN rol
on logueo.codigorol = rol.codigorol 
where rol != '$rolusu' ORDER BY logueo.idusu DESC";
    $resul_cant = mysqli_query($mysqli, $query);
    $cantiduser = mysqli_num_rows($resul_cant);
    $reserva = mysqli_fetch_all($resul_cant, MYSQLI_ASSOC);
    if ($cantiduser > 0) {
        ?>
        <?php if (isset($_POST['buscarcliente'])) { ?>
            <?php
                    if (@$result) {
                        $rolcliente = sed::encryption("a1");
                        $Busca_u = 'SELECT * FROM logueo
                    INNER JOIN rol on logueo.codigorol = rol.codigorol 
        WHERE rol !="' . $rolcliente . '" AND nombreusu LIKE "% ' . $word . '%" '
                            . 'OR idusu LIKE "%' . $word . '%"'
                            . 'OR nombreusu LIKE "%' . $word . '%"'
                            . 'OR apellidousu LIKE "%' . $word . '%"'
                            . 'OR generousu LIKE "%' . $word . '%"';
                        $que = mysqli_query($conexion, $Busca_u);
                        $contabusca = mysqli_num_rows($que);
                        ?>
                <div style="width: 96%; margin-left: 10px; border:2px solid blue;">
                    <div style="width: 100%; border:2px solid blue;">
                        <img src="img/useregis.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">
                        <h1 style="display: inline-block; font-size: 16px;">Clientes encontrados: <?php echo $contabusca; ?></h1>
                    </div>
                    <?php
                                foreach ($result as $key => $row) {
                                    $idlogi = $row['idusu'];
                                    $imagperfi = base64_encode($row['imagperfil']);
                                    $nombre = ucwords(sed::decryption($row['nombreusu']));
                                    $apellidos = ucwords(sed::decryption($row['apellidousu']));
                                    $genero = sed::decryption($row['generousu']);
                                    $email = $row['emailusu'];
                                    $fecharegistro = $row['fecharegistro'];
                                    $estado = $row['baneo'];
                                    ?>
                        <div style="width: 96%; margin-left: 8px;">
                            <div style="display: inline-block; ">
                                <?php if ($imagperfi) { ?>
                                    <img src="data:image/jpg;base64, <?php echo $imagperfi; ?>" style="width: 70px; height: 120px; margin-top: -95px;" alt="login">
                                <?php } else { ?>
                                    <img src="img/fotoperfil.png" style="width: 65px; height: 120px; margin-top: -95px;" alt="login">
                                <?php } ?>
                            </div>
                            <div style="display: inline-block;">
                                <p style="color:blue; font-size:14px;"><strong><?php echo $nombre . "" . $apellidos;  ?></strong></p>
                                <p style="margin-top: -10px; font-size:14px;"><strong>Genero: <?php echo $genero; ?></strong></p>
                                <p style="margin-top: -10px; font-size:13px;"><strong> Estado:
                                        <?php if ($estado == 0) {
                                                            echo "Cliente Activo";
                                                        } else if ($estado == 1) {
                                                            echo "Cliente baneado";
                                                        } ?></strong></p>
                                <p style="margin-top: -10px; color:blue; font-size:13px;">
                                    <img src="img/reserv.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">
                                    <strong><?php echo $fecharegistro; ?><strong>
                                </p>
                                <a class="btn btn-primary" href="admverusuarios.php?id=<?php echo $idlogi ?>" style="width:80px; display: inline-block; margin-top: -10px;" role="button">
                                    <strong> Ver</strong>
                                </a>
                                <form action="" method="post" style="width:110px; display: inline-block; margin-top: -30px;">
                                    <input type="hidden" name="idcliente" value="<?php echo $row['idusu']; ?>">
                                    <?php if ($row['baneo'] == 1) {
                                                        ?>
                                        <input type="submit" style="width:150px; margin-top: -10px;" class="btn btn-danger" name="banear_cliente" value="Banear">
                                    <?php } else if ($row['baneo'] == 2) {
                                                        ?>
                                        <input type="submit" style="width:150px; margin-top: -10px; color:white;" class="btn btn-warning" name="activar_cliente" value="Habilitar">
                                    <?php } ?>
                                </form>
                                <?php
                                                if (isset($_POST['banear_cliente'])) {
                                                    $idcliente = $_POST['idcliente'];
                                                    $sqlbanear = "UPDATE logueo SET baneo= '2' WHERE idusu='$idcliente'";
                                                    $resbanear = mysqli_query($mysqli, $sqlbanear);
                                                    if ($resbanear) {
                                                        echo '<div class="alert alert-primary" role="alert">Baneado exitosamente. </div>';
                                                        echo "<script>location.href='admclientes.php'</script>";
                                                    } else {
                                                        echo "Error: " . $sqlbanear . "<br>" . mysqli_error($mysqli);
                                                        //echo "<script>location.href='registro.php'</script>";
                                                    }
                                                } elseif (isset($_POST['activar_cliente'])) {
                                                    $idcliente = $_POST['idcliente'];
                                                    $sqlactivar = "UPDATE logueo SET baneo= '1' WHERE idusu='$idcliente'";
                                                    $resactivar = mysqli_query($mysqli, $sqlactivar);
                                                    if ($resactivar) {
                                                        echo '<div class="alert alert-primary" role="alert">Habilitado exitosamente. </div>';
                                                        echo "<script>location.href='admclientes.php'</script>";
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
                    <h1 style="display: inline-block; font-size: 16px;">Clientes registrados: <?php echo $cantiduser; ?></h1>
                </div>
                <?php
                        foreach ($reserva as $row) {
                            $idlogi = $row['idusu'];
                            $imagperfi = base64_encode($row['imagperfil']);
                            $nombre = ucwords(sed::decryption($row['nombreusu']));
                            $apellidos = ucwords(sed::decryption($row['apellidousu']));
                            $genero = sed::decryption($row['generousu']);
                            $email = $row['emailusu'];
                            $fecharegistro = $row['fecharegistro'];
                            $estado = $row['baneo'];

                            ?>
                    <div style="width: 96%; margin-left: 8px;">
                        <div style="display: inline-block; ">
                            <?php if ($imagperfi) { ?>
                                <img src="data:image/jpg;base64, <?php echo $imagperfi; ?>" style="width: 70px; height: 120px; margin-top: -95px;" alt="login">
                            <?php } else { ?>
                                <img src="img/fotoperfil.png" style="width: 65px; height: 120px; margin-top: -95px;" alt="login">
                            <?php } ?>
                        </div>
                        <div style="display: inline-block;">
                            <p style="color:blue; font-size:14px;"><strong><?php echo $nombre . "" . $apellidos;  ?></strong></p>
                            <p style="margin-top: -10px; font-size:14px;"><strong>Genero: <?php echo $genero; ?></strong></p>
                            <p style="margin-top: -10px; font-size:13px;"><strong> Estado:
                                    <?php if ($estado == 1) {
                                                    echo "Cliente Activo";
                                                } else if ($estado == 2) {
                                                    echo "Cliente baneado";
                                                } ?></strong></p>
                            <p style="margin-top: -10px; color:blue; font-size:13px;">
                                <img src="img/reserv.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">
                                <strong><?php echo $fecharegistro; ?><strong>
                            </p>
                            <a class="btn btn-primary" href="admverusuarios.php?id=<?php echo $idlogi ?>" style="width:80px; display: inline-block; margin-top: -10px;" role="button">
                                <strong> Ver</strong>
                            </a>
                            <form action="" method="post" style="width:110px; display: inline-block; margin-top: -30px;">
                                <input type="hidden" name="idcliente" value="<?php echo $row['idusu']; ?>">
                                <?php if ($row['baneo'] == 1) {
                                                ?>
                                    <input type="submit" style="width:150px; margin-top: -10px;" class="btn btn-danger" name="banear_cliente" value="Banear">
                                <?php } else if ($row['baneo'] == 2) {
                                                ?>
                                    <input type="submit" style="width:150px; margin-top: -10px; color:white;" class="btn btn-warning" name="activar_cliente" value="Habilitar">
                                <?php } ?>
                            </form>
                            <?php
                                        if (isset($_POST['banear_cliente'])) {
                                            $idcliente = $_POST['idcliente'];
                                            $sqlbanear = "UPDATE logueo SET baneo= '2' WHERE idusu='$idcliente'";
                                            $resbanear = mysqli_query($mysqli, $sqlbanear);
                                            if ($resbanear) {
                                                //echo '<div class="alert alert-primary" role="alert">Baneado exitosamente. </div>';
                                                echo "<script>location.href='admclientes.php'</script>";
                                            } else {
                                                echo "Error: " . $sqlbanear . "<br>" . mysqli_error($mysqli);
                                                //echo "<script>location.href='registro.php'</script>";
                                            }
                                        }elseif (isset($_POST['activar_cliente'])) {
                                            $idcliente = $_POST['idcliente'];
                                            $sqlactivar = "UPDATE logueo SET baneo= '1' WHERE idusu='$idcliente'";
                                            $resactivar = mysqli_query($mysqli, $sqlactivar);
                                            if ($resactivar) {
                                                //echo '<div class="alert alert-primary" role="alert">Habilitado exitosamente. </div>';
                                                echo "<script>location.href='admclientes.php'</script>";
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
                        <strong>USUARIOS REGISTRADOS</strong></h3>

                    <p class="text-justify">
                        <center>
                            <strong style="color:white;">
                                Aquí se mostrarán los usuarios que se registran.</strong>

                        </center>
                    </p>
                </div>
            </div>
        </div>
    <?php } ?>
</body>

</html>