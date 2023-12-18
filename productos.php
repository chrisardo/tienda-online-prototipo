<br><br><br>

<div class="container">
    <form action="" method="post" class="formulario column column--50 bg-orange">
        <label for="" style="color:blue;font-size: 22px;" class="formulario__label">
            <strong>Categorias:</strong>
        </label>
        <div class="row">
            <div class="col-6">
                <select id="soporte" class="form-control" name="nombrecategor" required="required">
                    <?php if (isset($_POST['seleccionar'])) {
                        $nombrecategor = $_POST['nombrecategor'];
                        $nombcate = sed::encryption($nombrecategor);
                        if ($nombrecategor == "-") {
                            echo "No seleccionó la cateogoria"; ?>
                    <?php } else { ?>
                    <?php if ($nombrecategor == "Todos") { ?>
                    <option value="Todos" selected="">Todos</option>
                    <?php } else { //selecciono la categoria
                                $sql2categ = "SELECT * FROM categoria where nombrecateg='$nombcate'";
                                $resultado2categ = mysqli_query($conexion, $sql2categ);
                                $categorias2 = mysqli_fetch_all($resultado2categ, MYSQLI_ASSOC);
                                foreach ($categorias2 as $rowcate) {
                                } ?>
                    <option value="<?php echo sed::decryption($rowcate['nombrecateg']); ?>" selected="">
                        <?php echo sed::decryption($rowcate['nombrecateg']); ?>
                    </option>
                    <?php } ?>
                    <?php } ?>
                    <?php } else { ?>
                    <option value="Todos" selected="">Seleccione categoria del producto</option>
                    <?php } ?>
                    <?php
                    $sqlcateg = "SELECT * FROM categoria group by nombrecateg ORDER BY idcategoria DESC";
                    $resultadocateg = mysqli_query($conexion, $sqlcateg);
                    $categorias = mysqli_fetch_all($resultadocateg, MYSQLI_ASSOC);
                    foreach ($categorias as $rowcat) {
                        $idcat = sed::decryption($rowcat['idcategoria']);
                        $nombrecatego = sed::decryption($rowcat['nombrecateg']);
                        echo '<option value="' . $nombrecatego . '">' . $nombrecatego . '</option>';
                    }
                    ?>
                    <option value="Todos">Todos</option>
                </select>
            </div>
            <div class="col-6">
                <input type="submit" value="Seleccionar" name="seleccionar" class="btn btn-primary">
            </div>
        </div>
    </form>
    <br>
    <?php
    $sqlq = "SELECT*FROM productos where cantistock != 0  ORDER BY idproducto DESC";
    $resul_cant = mysqli_query($conexion, $sqlq);
    $cantidad = mysqli_num_rows($resul_cant);
    $torta = mysqli_fetch_all($resul_cant, MYSQLI_ASSOC);
    ?>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
        <?php
        if (isset($_POST['seleccionar'])) {
            $nombrecategor = $_POST['nombrecategor'];
            $nombcate = sed::encryption($nombrecategor);
        ?>
        <?php if ($nombrecategor == "Todos") { ?>
        <?php foreach ($torta as $row) {
                    $id = $row['idproducto'];
                    $ide_prod = $row['id_empresa'];
                    $idcategprod = $row['codigocate'];
                    $querycat = "SELECT*FROM categoria where codigocate='$idcategprod' ORDER BY idcategoria DESC";
                    $resultcat = mysqli_query($conexion, $querycat);
                    $catego = mysqli_fetch_all($resultcat, MYSQLI_ASSOC);
                    foreach ($catego as $row2) {
                        $id_categ = $row2['idcategoria'];
                    }
                    $consulta_u = ("SELECT * FROM logueo_empresa  WHERE logueo_empresa.id_empresa='$ide_prod'");
                    $query1u = mysqli_query($conexion, $consulta_u);
                    $empres = mysqli_fetch_all($query1u, MYSQLI_ASSOC);
                    foreach ($empres as $arraye) {
                    } ?>
        <div class="col mb-4">
            <div class="card h-100">
                <img src="data:image/jpg;base64,<?php echo base64_encode($row['imagproducto']); ?>" height="150"
                    class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title text-primary" style="font-size: 18px;">
                        <strong> <?php echo sed::decryption($row['nombreproducto']); ?></strong>
                    </h5>
                    <p class="card-text">
                        <strong>Empresa: <?php echo sed::decryption($arraye["nombreempresa"]); ?></strong>
                    </p>
                    <div class="row">
                        <div class="col-6">
                            <p class="card-text ">
                                <strong> <?php echo sed::decryption($row2['nombrecateg']); ?></strong>
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="card-text text-end text-primary">
                                <strong>S/.<?php echo sed::decryption($row['costoproducto']);
                                                        ?> </strong>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-primary">
                    <!--poner cada boton al costado-->
                    <div class="row">
                        <div class="col-6">
                            <a href="verproducto.php?idproducto=<?php echo $id; ?>" class="btn btn-outline-primary">
                                Ver...
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="index.php?idproducto=<?php echo $id; ?>&index=1&p=1"
                                class="btn btn-outline-primary">
                                <img src="img/carrito.png" style="width: 30px; height: 20px;" alt="imgproductos">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php } else { //si selecciono una de las categorias
                $sql2categ = "SELECT * FROM categoria where nombrecateg='$nombcate'";
                $resultado2categ = mysqli_query($conexion, $sql2categ);
                $categorias2 = mysqli_fetch_all($resultado2categ, MYSQLI_ASSOC);
                foreach ($categorias2 as $rowcat) {
                    $idcat2 = $rowcat['codigocate'];
                }
                $sql1 = "SELECT * FROM productos where codigocate='$idcat2' and cantistock != 0 ORDER BY idproducto ASC";
                $resultado = mysqli_query($conexion, $sql1);
                $persona = mysqli_fetch_all($resultado, MYSQLI_ASSOC); ?>
        <?php foreach ($persona as $ro) {
                    $id = $ro['idproducto'];
                    $ide_prod = $ro['id_empresa'];
                    $consulta_u = ("SELECT * FROM logueo_empresa  WHERE logueo_empresa.id_empresa='$ide_prod'");
                    $query1u = mysqli_query($conexion, $consulta_u);
                    $empres = mysqli_fetch_all($query1u, MYSQLI_ASSOC);
                    foreach ($empres as $arraye) {
                    } ?>
        <div class="col mb-4">
            <div class="card h-100">
                <img src="data:image/jpg;base64,<?php echo base64_encode($ro['imagproducto']); ?>" height="150"
                    class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title text-primary" style="font-size: 18px;">
                        <strong><?php echo sed::decryption($ro['nombreproducto']); ?></strong>
                    </h5>
                    <p class="card-text">
                        <strong>Empresas: <?php echo sed::decryption($arraye["nombreempresa"]); ?></strong>
                    </p>
                    <div class="row">
                        <div class="col-6"></div>
                        <p class="card-text ">
                            <strong> <?php echo sed::decryption($rowcat['nombrecateg']); ?></strong>
                        </p>
                    </div>
                    <div class="col-6"></div>
                    <p class="card-text text-end text-primary">
                        <strong>
                            S/.<?php echo sed::decryption($ro['costoproducto']); ?>
                        </strong>
                    </p>
                </div>
                <div class="card-footer border-primary">
                    <!--poner cada boton al costado-->
                    <div class="row">
                        <div class="col-6">
                            <a href="verproducto.php?idproducto=<?php echo $id; ?>" class="btn btn-outline-primary">
                                Ver...
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="index.php?idproducto=<?php echo $id; ?>&index=1&p=1"
                                class="btn btn-outline-primary">
                                <img src="img/carrito.png" style="width: 30px; height: 20px;" alt="imgproductos">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php } ?>
        <?php } else { // no selecciono la opcion
        ?>
        <?php
            foreach ($torta as $row) {
                $id = $row['idproducto'];
                $ide_prod = $row['id_empresa'];
                $idcategprod = $row['codigocate'];
                $querycat = "SELECT*FROM categoria where codigocate='$idcategprod' ORDER BY idcategoria DESC";
                $resultcat = mysqli_query($conexion, $querycat);
                $catego = mysqli_fetch_all($resultcat, MYSQLI_ASSOC);
                foreach ($catego as $row2) {
                    $id_categ = $row2['idcategoria'];
                }
                $consulta_u = ("SELECT * FROM logueo_empresa  WHERE logueo_empresa.id_empresa='$ide_prod'");
                $query1u = mysqli_query($conexion, $consulta_u);
                $empres = mysqli_fetch_all($query1u, MYSQLI_ASSOC);
                foreach ($empres as $arraye) {
                } ?>

        <div class="col mb-4">
            <div class="card h-100">
                <img src="data:image/jpg;base64,<?php echo base64_encode($row['imagproducto']); ?>" height="150"
                    class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title text-primary" style="font-size: 18px;">
                        <strong> <?php echo sed::decryption($row['nombreproducto']); ?></strong>
                    </h5>
                    <p class="card-text">
                        <strong>Empresa: <?php echo sed::decryption($arraye["nombreempresa"]); ?></strong>
                    </p>
                    <div class="row">
                        <div class="col-6">
                            <p class="card-text ">
                                <strong> <?php echo sed::decryption($row2['nombrecateg']); ?></strong>
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="card-text text-end text-primary">
                                <strong>S/.<?php echo sed::decryption($row['costoproducto']);
                                                    ?> </strong>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-primary">
                    <!--poner cada boton al costado-->
                    <div class="row">
                        <div class="col-6">
                            <a href="verproducto.php?idproducto=<?php echo $id; ?>" class="btn btn-outline-primary">
                                Ver...
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="index.php?idproducto=<?php echo $id; ?>&index=1&p=1"
                                class="btn btn-outline-primary">
                                <img src="img/carrito.png" style="width: 30px; height: 20px;" alt="imgproductos">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php } ?>
    </div>
</div>