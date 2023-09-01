<center>
    <h2>Registrar rol de empleados</h2>
</center>
<div class="container container--flex" style="background-color:orange; width: 95%; margin-left: 10px;">
    <form action="" enctype="multipart/form-data" method="post" class="formulario column column--50 bg-orange">
        <div class="row g-3">
            <div class="col">
                <label for="" style="color:white;" class="formulario__label">Código del rol : </label>
                <input type="number" class="form-control" name="codigorol" required="required">
            </div>
            <div class="col">
                <label for="" style="color:white;" class="formulario__label">Rol: </label>
                <input type="text" class="form-control" maxlength="38" name="rol" required="required" />
            </div>
        </div>

        <center>
            <input type="submit" style="width:180px; margin-top: 4px;" class="btn btn-dark" name="registrarol" value="AGREGAR">
            <!--<a class="btn" href="admveregistorta.php" role="button" value="Ver torta">
                    <input type="button" style="width:150px" class="btn btn-primary" value="Ver torta">
                </a>-->
        </center>
    </form>
    <?php
    if (isset($_POST['registrarol'])) {
        $codigorol = $_POST['codigorol'];
        $rol = $_POST['rol'];
        $role = sed::encryption($rol);

        $sql2rol = "SELECT * FROM rol where codigorol='$codigorol' or rol='$role'";
        $resultado2rol = mysqli_query($conexion, $sql2rol);
        $cantid_rol = mysqli_num_rows($resultado2rol);
        $rol2 = mysqli_fetch_all($resultado2rol, MYSQLI_ASSOC);
        if (!empty($codigorol) && !empty($rol)) {
            if ($cantid_rol > 0) {
                echo '<div class="alert alert-danger" role="alert">No se puede registrar porque existe  Código: ' . $codigorol . ' o Rol: ' . $rol . '. </div>';
            } else {
                $query = "INSERT INTO rol (codigorol,rol) VALUES('$codigorol', '$role')";
                $resultado = $conexion->query($query);
                if ($resultado) {
                    echo '<div class="alert alert-primary" role="alert">Rol del empleado insertado con exito!. </div>';
                    echo "<script>location.href='adm.php?registrorol=1'</script>";
                } else {
                    echo '<div class="alert alert-danger" role="alert">Hubo problemas al insertar. </div>';
                    //echo "<script>location.href='admregistorta.php'</script>";
                }
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Te falta datos que completar. </div>';
            //echo "<script>location.href='admregistorta.php'</script>";
        }
    } else if (isset($_POST['vertorta'])) {
        require("veregistorta.php");
    }
    ?>
</div>