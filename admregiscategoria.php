    <center>
        <h2>Registrar categoria del producto</h2>
    </center>
    <div class="container container--flex" style="background-color:orange; width: 95%; margin-left: 10px;">
        <form action="" enctype="multipart/form-data" method="post" class="formulario column column--50 bg-orange">
            <div class="row g-3">
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Imagen : </label>
                    <input type="file" class="form-control" name="imagen" required="required">
                </div>
            </div>
            <div class="row g-3">
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Código categoria: </label>
                    <input type="text" class="form-control" maxlength="28" name="codigocate" required="required" />
                </div>
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Nombre categoria: </label>
                    <input type="text" class="form-control" maxlength="28" name="nombrecate" required="required" />
                </div>
            </div>
            <div class="row g-2">
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Descripcion: </label>
                    <input type="text" class="form-control" maxlength="31" id="descripcioncate" name="descripcioncate" required="required">
                </div>
            </div>

            <center>
                <input type="submit" style="width:180px; margin-top: 4px;" class="btn btn-dark" name="registrarcategoria" value="AGREGAR CATEGORIA">
                <!--<a class="btn" href="admveregistorta.php" role="button" value="Ver torta">
                    <input type="button" style="width:150px" class="btn btn-primary" value="Ver torta">
                </a>-->
            </center>
        </form>
        <?php
        if (isset($_POST['registrarcategoria'])) {
            $Imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
            $tamano_imagen = $_FILES['imagen']['size'];
            $tipoimagen = $_FILES['imagen']['type'];
            $codigo = $_POST['codigocate'];
            $nombre = $_POST['nombrecate'];
            $descripcion = $_POST['descripcioncate'];
            $nombree = sed::encryption($nombre);
            $descripcione = sed::encryption($descripcion);
            $codigoe = sed::encryption($codigo);
            if (!empty($codigo) && !empty($nombre)) {
                if ($Imagen) {
                    if ($tamano_imagen <= 3000000) {
                        if ($tipoimagen == "image/jpeg" || $tipoimagen == "image/jpg" || $tipoimagen == "image/png" || $tipoimagen == "image/gif") {
                            $sql2categ = "SELECT * FROM categoria where nombrecateg='$nombree' or codigocate='$codigoe'";
                            $resultado2categ = mysqli_query($conexion, $sql2categ);
                            $cantid_catego = mysqli_num_rows($resultado2categ);
                            $categorias2 = mysqli_fetch_all($resultado2categ, MYSQLI_ASSOC);
                            if ($cantid_catego > 0) {
                                echo '<div class="alert alert-danger" role="alert">Categoria: ' . $nombre . ' ya se ha registrado. </div>';
                            } else {
                                $query = "INSERT INTO categoria (codigocate,id_empresa,imagen, nombrecateg, descripcioncateg, fecharegistro_categ)
                                VALUES('$codigoe', '$idlog', '$Imagen', '$nombree', '$descripcione', now())";
                                $resultado = $conexion->query($query);
                                if ($resultado) {
                                    echo '<div class="alert alert-primary" role="alert">Categoria insertada con exito!. </div>';
                                    //echo "<script>location.href='adm.php?regiscategoria=1'</script>";
                                } else {
                                    echo '<div class="alert alert-danger" role="alert">Hubo problemas al insertar. </div>';
                                    //echo "<script>location.href='admregistorta.php'</script>";
                                }
                            }
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Tipo de la imagen debe ser jpeg, jpg, png  o gif. </div>';
                            //echo "<script>location.href='admregistorta.php'</script>";
                        }
                    } else {
                        echo '<div class="alert alert-danger" role="alert">El tamaño de la imagen debe ser menor de 2 millones de bytes. </div>';
                        //echo "<script>location.href='admregistorta.php'</script>";
                    }
                } else {
                    echo '<div class="alert alert-danger" role="alert">Pon una imagen de la categoria.</div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Completa todo el formulario. </div>';
            }
        } else if (isset($_POST['vertorta'])) {
            require("veregistorta.php");
        }
        ?>
    </div>