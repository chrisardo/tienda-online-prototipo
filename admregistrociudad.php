<center>
    <h2>Registrar ciudad</h2>
</center>
<div class="container container--flex" style="background-color:orange; width: 95%; margin-left: 10px;">
    <form action="" enctype="multipart/form-data" method="post" class="formulario column column--50 bg-orange">
        <div class="row g-3">
            <div class="col">
                <label for="" style="color:white;" class="formulario__label">Código ciudad : </label>
                <input type="number" class="form-control" name="codigociudad" required="required">
            </div>
            <div class="col">
                <label for="" style="color:white;" class="formulario__label">Ciudad: </label>
                <input type="text" class="form-control" maxlength="38" name="ciudad" required="required" />
            </div>
        </div>

        <center>
            <input type="submit" style="width:180px; margin-top: 4px;" class="btn btn-dark" name="registrociudad" value="AGREGAR">
            <!--<a class="btn" href="admveregistorta.php" role="button" value="Ver torta">
                    <input type="button" style="width:150px" class="btn btn-primary" value="Ver torta">
                </a>-->
        </center>
    </form>
    <?php
    if (isset($_POST['registrociudad'])) {
        $codigociudad = $_POST['codigociudad'];
        $ciudad = $_POST['ciudad'];
        $ciudade = sed::encryption($ciudad);
        if (!empty($codigociudad) && !empty($ciudad)) {
            $sql2ciudad = "SELECT * FROM ciudad where codciudad='$codigociudad' or ciudad='$ciudade'";
            $resultado2ciudad = mysqli_query($conexion, $sql2ciudad);
            $cantid_ciudad = mysqli_num_rows($resultado2ciudad);
            if ($cantid_ciudad > 0) {
                echo '<div class="alert alert-danger" role="alert">No se puede registrar porque existe  Código: ' . $codigociudad . ' o Ciudad: ' . $ciudad . '. </div>';
            } else {
                $query = "INSERT INTO ciudad (codciudad,ciudad) VALUES('$codigociudad', '$ciudade')";
                $resultado = $conexion->query($query);
                if ($resultado) {
                    echo '<div class="alert alert-primary" role="alert">Ciudad insertado con exito!. </div>';
                    echo "<script>location.href='adm.php?regisciudad=1'</script>";
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