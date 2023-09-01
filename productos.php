<br><br><br>
<div>
  <div style="width: 94%; margin-left: 18px;">
    <form action="" method="post" class="formulario column column--50 bg-orange">
      <label for="" style="color:blue;font-size: 22px;" class="formulario__label"><strong>Categorias:</strong> </label>
      <select id="soporte" class="form-control" style="float: left; width: 64%;" name="nombrecategor" required="required">
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
                  foreach ($categorias2 as $rowcate) { } ?>
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
      <input type="submit" name="seleccionar" value="Seleccionar" style="width:106px; margin-left: 6px; margin-top: -1px; float:left;" class="btn btn-primary">
    </form>
  </div><br><br>
  <div class="contorno">
    <?php
    $sqlq = "SELECT*FROM productos where cantistock != 0  ORDER BY idproducto DESC";
    $resul_cant = mysqli_query($conexion, $sqlq);
    $cantidad = mysqli_num_rows($resul_cant);
    $torta = mysqli_fetch_all($resul_cant, MYSQLI_ASSOC);
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
              $query1u = mysqli_query($mysqli, $consulta_u);
              $empres = mysqli_fetch_all($query1u, MYSQLI_ASSOC);
              foreach ($empres as $arraye) { } ?>
          <div class="contorno2">
            <div class="divimg">
              <img src="data:image/jpg;base64,<?php echo base64_encode($row['imagproducto']); ?>" style="width: 100%; height:100px;" alt="imgproductos">
              <!--<img src="img/logo.png" style="width: 100%; height:100px;" alt="imgproductos"-->
            </div>
            <div style="width: 102%;">
              <div class="pe">
                <p style="color: blue;">
                  <strong> <?php echo sed::decryption($row['nombreproducto']); ?></strong>
                </p>
              </div>
              <a href="verempresa.php?id=<?php echo $arraye["id_empresa"]; ?>" style="color:green; ">
                <div class="pe" style="margin-top:-12px;">
                  <p>
                    <strong>Empresas: <?php echo sed::decryption($arraye["nombreempresa"]); ?></strong>
                  </p>
                </div>
              </a>
              <div style="margin-top:-12px; width: 100%;">
                <div class="contenedor3">
                  <p class="pc"><strong><?php echo sed::decryption($row2['nombrecateg']); ?></strong>
                  </p>
                </div>
                <div class="contenedor3">
                  <p class="pc" style="color:orangered;"><strong>S/.<?php echo sed::decryption($row['costoproducto']);
                                                                          ?> </strong></p>
                </div>
              </div>
            </div>
            <div style="widh:100%;">
              <div class="btnp" style="display: inline-block;">
                <a href="verproducto.php?idproducto=<?php echo $id; ?>" style="color:green; ">
                  <div class="buttonprod btn btn-primary">
                    Ver
                  </div>
                </a>
              </div>
              <div style="display: inline-block;">
                <a href="index.php?idproducto=<?php echo $id; ?>&productos=1&p=1" style="color:blue; ">
                  <div style="border: 2px solid blue;" class="buttonprod btn btn-primary">
                    Añadir al carrito
                  </div>
                </a>
              </div>
            </div>
          </div>
        <?php } ?>
      <?php } else { //si selecciono la opcion
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
              $query1u = mysqli_query($mysqli, $consulta_u);
              $empres = mysqli_fetch_all($query1u, MYSQLI_ASSOC);
              foreach ($empres as $arraye) { } ?>
          <div class="contorno2">
            <div class="divimg">
              <img src="data:image/jpg;base64,<?php echo base64_encode($ro['imagproducto']); ?>" style="width: 100%; height:100px;" alt="imgproductos">
              <!--<img src="img/logo.png" style="width: 100%; height:100px;" alt="imgproductos"-->
            </div>
            <div style="width: 102%;">
              <div class="pe">
                <p style="color: blue;">
                  <strong> <?php echo sed::decryption($ro['nombreproducto']); ?></strong>
                </p>
              </div>
              <a href="verempresa.php?id=<?php echo $arraye["id_empresa"]; ?>" style="color:green; ">
                <div class="pe" style="margin-top:-12px;">
                  <p>
                    <strong>Empresas: <?php echo sed::decryption($arraye["nombreempresa"]); ?></strong>
                  </p>
                </div>
              </a>
              <div style="margin-top:-12px; width: 100%;">
                <div class="contenedor3">
                  <p class="pc"><strong><?php echo sed::decryption($rowcat['nombrecateg']); ?></strong>
                  </p>
                </div>
                <div class="contenedor3">
                  <p class="pc" style="color:orangered;"><strong>S/.<?php echo sed::decryption($ro['costoproducto']);
                                                                          ?> </strong></p>
                </div>
              </div>
            </div>
            <div style="widh:100%;">
              <div class="btnp" style="display: inline-block;">
                <a href="verproducto.php?idproducto=<?php echo $id; ?>" style="color:green; ">
                  <div class="buttonprod btn btn-primary">
                    Ver
                  </div>
                </a>
              </div>
              <div style="display: inline-block;">
                <a href="index.php?idproducto=<?php echo $id; ?>&productos=1&p=1" style="color:blue; ">
                  <div style="border: 2px solid blue;" class="buttonprod btn btn-primary">
                    Añadir al carrito
                  </div>
                </a>

              </div>
            </div>
          </div>
        <?php } ?>
      <?php } ?>
    <?php } else { // no selecciono

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
          $query1u = mysqli_query($mysqli, $consulta_u);
          $empres = mysqli_fetch_all($query1u, MYSQLI_ASSOC);
          foreach ($empres as $arraye) { } ?>
        <div class="contorno2">
          <div class="divimg">
            <img src="data:image/jpg;base64,<?php echo base64_encode($row['imagproducto']); ?>" style="width: 100%; height:100px;" alt="imgproductos">
            <!--<img src="img/logo.png" style="width: 100%; height:100px;" alt="imgproductos"-->
          </div>
          <div style="width: 102%;">
            <div class="pe">
              <p style="color: blue;">
                <strong> <?php echo sed::decryption($row['nombreproducto']); ?></strong>
              </p>
            </div>
            <a href="verempresa.php?id=<?php echo $arraye["id_empresa"]; ?>" style="color:green; ">
              <div class="pe" style="margin-top:-12px;">
                <p>
                  <strong>Empresas: <?php echo sed::decryption($arraye["nombreempresa"]); ?></strong>
                </p>
              </div>
            </a>
            <div style="margin-top:-12px; width: 100%;">
              <div class="contenedor3">
                <p class="pc"><strong><?php echo sed::decryption($row2['nombrecateg']); ?></strong>
                </p>
              </div>
              <div class="contenedor3">
                <p class="pc" style="color:orangered;"><strong>S/.<?php echo sed::decryption($row['costoproducto']);
                                                                      ?> </strong></p>
              </div>
            </div>
          </div>
          <div style="widh:100%;">
            <div class="btnp" style="display: inline-block;">
              <a href="verproducto.php?idproducto=<?php echo $id; ?>" style="color:green; ">
                <div class="buttonprod btn btn-primary">
                  Ver
                </div>
              </a>
            </div>
            <div style="display: inline-block;">
              <a href="index.php?idproducto=<?php echo $id; ?>&productos=1&p=1" style="color:blue; ">
                <div style="border: 2px solid blue;" class="buttonprod btn btn-primary">
                  Añadir al carrito
                </div>
              </a>

            </div>
          </div>
        </div>
      <?php } ?>
    <?php } ?>
  </div><br>
  <?php
  if (@$p == 1) {
    extract($_GET);
    $idus = $_SESSION['idusu'];
    $sql = "SELECT * FROM productos WHERE idproducto=$idproducto";
    //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
    $producsql = mysqli_query($mysqli, $sql);
    $producto = mysqli_fetch_all($producsql, MYSQLI_ASSOC);
    foreach ($producto as $row) {
      $idp = $row['idproducto'];
      $nombreprodu = sed::decryption($row['nombreproducto']);
      $costoprodu = sed::decryption($row['costoproducto']);
    }
    $checkprod = mysqli_query($mysqli, "SELECT * FROM carrito WHERE idproducto='$idproducto'");
    $check_produc = mysqli_num_rows($checkprod);
    $preciototal = ($costoprodu * 1);
    $query = "INSERT INTO carrito 
                                        (idproducto, idusu, cantidadpedir, precio, fechacarrito, horacarrito, estadocarrito, total) 
                                VALUES('$idp', '$idus', '1','$costoprodu' ,now(), now(), '1', '$preciototal')";
    $resultado = $conexion->query($query);
    if ($resultado) {
      //echo "se guardo";
      echo "<script>location.href='index.php?productos=1'</script>";
    } else {
      //echo "no se guardo";
      //echo "<script>location.href='index.php?productos=1'</script>";
    }
  }
  ?>
  <style>
    /*cuadro productos*/
    div .contorno {
      width: 97%;
      margin-left: 15px;
    }

    div .contorno2 {
      display: inline-block;
      border: 2px solid blue;
      width: 24%;
      margin-left: 8px;
      background-color: greenyellow;
    }

    div .buttonprod {
      border: 2px solid green;
      height: 36px;
      text-align: center;
      margin-left: 3px;
      background-color: white;
    }

    div .pe {
      font-size: 14px;
      margin-left: 3px;
    }

    div .contenedor3 {
      display: inline-block;
      margin-left: 5px;
      width: 46%;
      height: 32px;
    }

    /*--Estilos responsive--*/
    @media screen and (min-width:350px) {
      div .contorno {
        width: 97%;
        margin-left: 12px;
      }

      div .pe {
        font-size: 11px;
      }

      div .contorno2 {
        width: 47%;
        margin-left: 2px;
        margin-top: 4px;
      }

      div .contenedor3 {
        display: inline-block;
        margin-left: 3px;
        width: 46%;
        height: 32px;
      }

      div .pc {
        font-size: 12px;
      }

      div .buttonprod {
        width: 100%;
        margin-left: 5px;
        font-size: 11px;
      }
    }

    @media screen and (min-width:390px) {
      div .pe {
        font-size: 11px;
      }

      div .contorno2 {
        width: 47%;
        margin-left: 2px;
        margin-top: 4px;
      }

      div .contenedor3 {
        display: inline-block;
        margin-left: 3px;
        width: 46%;
        height: 32px;
      }

      div .pc {
        font-size: 12px;
      }

      div .buttonprod {
        width: 97%;
        margin-left: 6px;
        font-size: 12px;
      }
    }

    @media screen and (min-width:414px) {
      div .buttonprod {
        width: 96%;
        margin-left: 6px;
        font-size: 13px;
      }
    }

    @media screen and (min-width:478px) {
      div .pe {
        font-size: 14px;
      }

      div .contorno2 {
        width: 32%;
      }

      div .buttonprod {
        width: 100%;
        margin-left: 6px;
        font-size: 11px;
      }
    }

    @media screen and (min-width:576px) {
      div .pe {
        font-size: 14px;
      }

      div .contorno2 {
        width: 32%;
      }

      div .buttonprod {
        width: 100%;
        margin-left: 6px;
        font-size: 13px;
      }
    }

    @media screen and (min-width:624px) {
      div .pe {
        width: 100%;
        font-size: 12px;
      }

      div .contorno2 {
        width: 31%;
        margin-left: 6px;
      }

      div .buttonprod {
        width: 100%;
        margin-left: 7px;
        font-size: 14px;
      }
    }

    @media screen and (min-width:730px) {
      div .pe {
        font-size: 15px;
      }

      div .contorno2 {
        width: 32%;
        margin-left: 6px;
      }

      div .contenedor3 {
        display: inline-block;
        margin-left: 4px;
        width: 46%;
        height: 32px;
      }

      div .pc {
        font-size: 15px;
      }

      div .buttonprod {
        width: 100%;
        margin-left: 8px;
        font-size: 17px;
      }
    }

    @media screen and (min-width:1020px) {
      div .pe {
        font-size: 14px;
      }

      div .contorno2 {
        width: 23%;
        margin-left: 12px;
      }

      div .contenedor3 {
        display: inline-block;
        margin-left: 4px;
        width: 46%;
        height: 32px;
      }

      div .pc {
        font-size: 14px;
      }

      div .buttonprod {
        width: 100%;
        margin-left: 12px;
        font-size: 18px;
      }
    }

    @media screen and (min-width:1270px) {
      div .pe {
        font-size: 16px;
      }

      div .contorno2 {
        width: 24%;
        margin-left: 9px;
      }

      div .contenedor3 {
        display: inline-block;
        margin-left: 4px;
        width: 46%;
        height: 32px;
      }

      div .pc {
        font-size: 15px;
      }

      div .buttonprod {
        width: 100%;
        margin-left: 14px;
        font-size: 20px;
      }
    }
  </style>