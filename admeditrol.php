<?php
//validar
session_start();
if (@!$_SESSION['idusu']) {
    echo "<script>location.href='logueo.php'</script>";
} elseif ($_SESSION['rolusu'] == "a1" || $_SESSION['rolusu'] == "empresa") {
    /*if ((time() - $_SESSION['last_login_timestamp']) > 240) { // 900 = 15 * 60  
        setcookie("cerrarsesion", 1, time() + 60000); //6o segundos es 1 minuto, 86400 segundos es por 24 horas
        echo "<script>location.href='desconectar.php'</script>";
    } else {
        $_SESSION['last_login_timestamp'] = time();
    }*/ } else {
    echo "<script>location.href='logueo.php'</script>";
}
include 'sed.php';
require("connectdb.php");
require("conexion.php");
$idlog = $_SESSION['idusu'];
extract($_GET);
$sqlq = "SELECT*FROM rol where idrol='$id'";
$resultado = mysqli_query($conexion, $sqlq);
$rol = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
foreach ($rol as $row) { }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo sed::decryption($row['rol']); ?> | Editar rol</title>
    <link rel="icon" href='img/logo.png' sizes="32x32" type="img/jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css2/style.css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
        <div class="container-fluid">
            <a class="" href="adm.php?verrol=1">
                <img src="img/atras.png" style="width: 30px; height: 40px;">
            </a>
            <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 15px;" href="#">
                <img src="img/logo.png" style="width: 30px; height: 30px;" alt="logo restaurantapp">
                <strong>Perikos's</strong>
            </a>
        </div>
    </nav><br><br><br>
    <center>
        <h2>Editar rol</h2>
    </center>
    <div class="container container--flex" style="background-color:orange; width: 95%; margin-left: 10px;">
        <form action="" enctype="multipart/form-data" method="post" class="formulario column column--50 bg-orange">
            <div class="row g-3">
                <!--<div class="col">
                    <label for="" style="color:white;" class="formulario__label">Código del rol : </label>
                    <input type="hidden" class="form-control" name="codigorol" value="<?php //echo $row['codigorol']; ?>" required="required">
                </div>-->
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Rol: </label>
                    <input type="text" class="form-control" value="<?php echo sed::decryption($row['rol']); ?>" maxlength="38" name="rol" required="required" />
                </div>
            </div>

            <center>
                <input type="submit" style="width:180px; margin-top: 4px;" class="btn btn-dark" name="editarol" value="EDITAR">
                <!--<a class="btn" href="admveregistorta.php" role="button" value="Ver torta">
                    <input type="button" style="width:150px" class="btn btn-primary" value="Ver torta">
                </a>-->
            </center>
        </form>
        <?php
        if (isset($_POST['editarol'])) {
            //$codigorol = $_POST['codigorol'];
            $rol = $_POST['rol'];
            $role = sed::encryption($rol);

            $sql2rol = "SELECT * FROM rol where rol='$role'";
            $resultado2rol = mysqli_query($conexion, $sql2rol);
            $cantid_rol = mysqli_num_rows($resultado2rol);
            $rol2 = mysqli_fetch_all($resultado2rol, MYSQLI_ASSOC);
            if (!empty($rol)) {
                if ($cantid_rol > 0) {
                    echo '<div class="alert alert-danger" role="alert">No se puede registrar porque existe  Código: ' . $codigorol . ' o Rol: ' . $rol . '. </div>';
                } else {
                    $query = "UPDATE rol SET rol='$role' WHERE idrol='$id'";
                    $resultado = $conexion->query($query);
                    if ($resultado) {
                        echo '<div class="alert alert-primary" role="alert">Rol del empleado insertado con exito!. </div>';
                        echo "<script>location.href='admeditrol.php?id=$id'</script>";
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Hubo problemas al insertar. </div>';
                        //echo "<script>location.href='admregistorta.php'</script>";
                    }
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Ningun campo debe estar vacio. </div>';
                //echo "<script>location.href='admregistorta.php'</script>";
            }
        } else if (isset($_POST['vertorta'])) {
            require("veregistorta.php");
        }
        ?>
    </div>
</body>

</html>