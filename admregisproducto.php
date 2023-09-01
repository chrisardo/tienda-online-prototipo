    <center>
        <h2>Registrar producto</h2>
    </center>
    <div class="container container--flex" style="background-color:orange; width: 95%; margin-left: 10px;">
        <form action="" enctype="multipart/form-data" method="post" class="formulario column column--50 bg-orange">
            <div class="row g-3">
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Imagen producto: </label>
                    <input type="file" class="form-control" name="imagen" required="required">
                </div>
            </div>
            <div class="row g-3">
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Código del producto: </label>
                    <input type="text" class="form-control" maxlength="38" name="codigoproduc" required="required" />
                </div>
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Nombre producto: </label>
                    <input type="text" class="form-control" maxlength="38" name="nombre" required="required" />
                </div>
            </div>
            <div class="row g-2">
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Categoria producto: </label>
                    <select id="soporte" class="form-control" name="nombrecategor" required="required">
                        <option value="-" selected="">Seleccione la categoria</option>
                        <?php
                        if ($_SESSION['rolusu'] == "a1") {
                            $sqlcateg = "SELECT * FROM categoria where group by nombrecateg ORDER BY idcategoria DESC";
                        } elseif ($_SESSION['rolusu'] == "empresa") {
                            $sqlcateg = "SELECT*FROM categoria
                            inner join logueo_empresa on categoria.id_empresa=logueo_empresa.id_empresa
                            INNER JOIN rol on logueo_empresa.codigorol = rol.codigorol 
                             WHERE logueo_empresa.id_empresa='$idlog' ORDER BY idcategoria DESC";
                        }
                        $resultadocateg = mysqli_query($conexion, $sqlcateg);
                        $categorias = mysqli_fetch_all($resultadocateg, MYSQLI_ASSOC);
                        foreach ($categorias as $rowcat) {
                            $idcat = sed::decryption($rowcat['idcategoria']);
                            $nombrecatego = sed::decryption($rowcat['nombrecateg']);
                            echo '<option value="' . sed::decryption($rowcat['codigocate']) . '">' . $nombrecatego . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Costo producto: </label>
                    <input type="text" class="form-control" name="costotorta" placeholder="Ej: 65" required="required" />
                </div>
            </div>
            <div class="row g-2">
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Detalles producto: </label>
                    <textarea type="text" class="form-control" maxlength="331" id="detalletorta" name="detalletorta" placeholder="Especifique los detalles de la torta..."></textarea>
                </div>
                <div class="col">
                    <label for="" style="color:white;" class="formulario__label">Cantidd stock: </label>
                    <input type="number" class="form-control" name="cantidstock" placeholder="Ej: 65" required="required" />
                </div>
            </div>
            <center>
                <input type="submit" style="width:180px; margin-top: 4px;" class="btn btn-dark" name="registrarproducto" value="AGREGAR PRODUCTO">
                <!--<a class="btn" href="admveregistorta.php" role="button" value="Ver torta">
                    <input type="button" style="width:150px" class="btn btn-primary" value="Ver torta">
                </a>-->
            </center>
        </form>
        <?php
        if (isset($_POST['registrarproducto'])) {
            $Imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
            $tamano_imagen = $_FILES['imagen']['size'];
            $tipoimagen = $_FILES['imagen']['type'];
            $codproducto = $_POST['codigoproduc'];
            $nombreproduct = $_POST['nombre'];
            $nombrecategor = $_POST['nombrecategor'];
            $costoproduc = $_POST['costotorta'];
            $detalletorta = $_POST['detalletorta'];
            $cantistock = $_POST['cantidstock'];
            $codigoe = sed::encryption($codproducto);
            $nombree = sed::encryption($nombreproduct);
            $codigocate = sed::encryption($nombrecategor);
            $costoprode = sed::encryption($costoproduc);
            $detalletortae = sed::encryption($detalletorta);
            $cantistocke = sed::encryption($cantistock);
            if (!empty($nombreproduct) && !empty($codproducto)  && !empty($costoproduc) && $cantistock > 0) {
                if ($Imagen) {
                    if ($tamano_imagen <= 3000000) {
                        if ($tipoimagen == "image/jpeg" || $tipoimagen == "image/jpg" || $tipoimagen == "image/png" || $tipoimagen == "image/gif") {
                            $sql2produc = "SELECT * FROM productos 
                        inner join logueo_empresa on productos.id_empresa=logueo_empresa.id_empresa
                        INNER JOIN rol on logueo_empresa.codigorol = rol.codigorol 
                        where productos.codigoproducto='$codigoe' and productos.nombreproducto='$nombree' and logueo_empresa.id_empresa='$idlog'";
                            $resultado2produc = mysqli_query($conexion, $sql2produc);
                            $produc2 = mysqli_fetch_all($resultado2produc, MYSQLI_ASSOC);
                            $cantid_producto = mysqli_num_rows($resultado2produc);
                            if ($cantid_producto > 0) {
                                echo '<div class="alert alert-danger" role="alert">' . $codproducto . " " . $nombreproduct . ' ya se ha registrado. </div>';
                            } else {
                                $queryp = "INSERT INTO productos (codigoproducto, id_empresa, imagproducto, nombreproducto, costoproducto, detalleproducto, cantistock, codigocate, fecharegistro_produc)
                        VALUES('$codigoe', '$idlog', '$Imagen', '$nombree', '$costoprode', '$detalletortae', '$cantistocke', '$codigocate', now())";
                                $resultado = $conexion->query($queryp);
                                if ($resultado) {
                                    echo '<div class="alert alert-primary" role="alert">Producto registrado exitosamente!. </div>';
                                    //echo "<script>location.href='adm.php?regisproducto=1'</script>";
                                } else {
                                    echo '<div class="alert alert-danger" role="alert">Hubo problemas al insertar. </div>';
                                    echo "Error: " . $queryp . "<br>" . mysqli_error($conexion);
                                    //echo "<script>location.href='admregisproducto.php'</script>";
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
                    echo '<div class="alert alert-danger" role="alert">Pon una imagen del producto.</div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Completa todos datos del registro. </div>';
            }
        } elseif (isset($_POST['vertorta'])) {
            require("veregistorta.php");
        }
        ?>
    </div>