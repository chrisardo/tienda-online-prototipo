<?php
session_start();
if (@$_SESSION['rolusu'] == "user") {
  /*if ((time() - $_SESSION['last_login_timestamp']) > 240) { // 900 = 15 * 60  
    setcookie("cerrarsesion", 1, time() + 60000); //6o segundos es 1 minuto, 86400 segundos es por 24 horas
    echo "<script>location.href='desconectar.php'</script>";
  } else {
    $_SESSION['last_login_timestamp'] = time();
  }*/
}
?>
<!doctype html>
<html class="no-js" lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Resultado de la búsqueda | RestaurantApp</title>
  <link rel="icon" href='img/logo.png' sizes="32x32" type="img/jpg">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
  <link rel="stylesheet" href="css2/style.css" />
  <!--compartir-->
  <!--<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=61a8fa9ed0a9e10012e4df83&product=sticky-share-buttons' async='async'></script>-->
</head>

<body>
  <?php
  include("conexion.php");
  include 'sed.php';
  ?>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
    <div class="container-fluid">
      <div class="navbar-brand ">
        <a href="index.php"><img src="img/atras.png" style="width: 30px; height: 36px;"></a>
        <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size: 13px;">
          <img src="img/logo.png" style="width: 28px; height: 36px;">
        </a>
      </div>
      <a class="navbar-brand order-1 order-justify-content-end" style="margin:-9px;">
        <form class="form-inline my-2 my-lg-0 align-self-stretch" name="buscador" action="buscador.php" method="POST">
          <input class="form-control mr-sm-2" style="width: 170px;" type="text" name="word" placeholder="Buscar tipo de torta" aria-label="Search" />
          <button class="btn btn-success my-2 my-sm-0" style="width: 67px;" name="buscarprod" value="Buscar" type="submit">
            Buscar
          </button>
        </form>
      </a>
    </div>
  </nav><br><br><br> <br>
  <?php
  require 'class/bookproducto.php';
  $word = sed::encryption(@$_POST['word']);
  $objBook = new Bookproducto();
  $words = explode(' ', $word);
  $num = count($words);
  $result = $objBook->buscar($word, $num);
  include_once('class/database.php');
  ?>
  <?php if (isset($_POST['buscarprod'])) {
    //echo "se dio click"; 
    ?>
    <?php
      if (@$result) {
        $Busca = 'SELECT * FROM productos inner join categoria on categoria.codigocate=productos.codigocate 
    WHERE nombreproducto LIKE "% ' . $word . '%" '
          . 'OR nombreproducto LIKE "%' . $word . '%"'
          . 'OR detalleproducto LIKE "%' . $word . '%"'
          . 'OR nombrecateg LIKE "%' . $word . '%"';
        $que = mysqli_query($conexion, $Busca);
        $conta = mysqli_num_rows($que);
        ?>
      <div style="width: 95%; margin-left: 15px; border:2px solid blue;">
        <div style="width: 100%; border:2px solid blue;">
          <img src="img/buscar.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">
          <h1 style="display: inline-block;">Encontradas: <?php echo $conta; ?></h1>
        </div>
        <?php
            foreach ($result as $key => $row) {
              $idu_prod = $row['id_empresa'];
              $consult_u = ("SELECT * FROM logueo_empresa  WHERE id_empresa='$idu_prod'");
              $query1u = mysqli_query($conexion, $consult_u);
              $empresau = mysqli_fetch_all($query1u, MYSQLI_ASSOC);
              foreach ($empresau as $arrayu) { }
              ?>
          <div style="width: 95%; margin-left: 3px;">
            <div style="display: inline-block; ">
              <img src="data:image/jpg;base64, <?php echo base64_encode($row['imagproducto']); ?>" style="width: 90px; height: 115px; margin-top: -50px;">
            </div>
            <div style="display: inline-block;">
              <p style="color:blue; font-size: 13px;"><strong><?php echo sed::decryption($row['nombreproducto']); ?></strong></p>
              <p style="color:orange; font-size: 14px; margin-top:-16px;">
                <strong>Empresa: <?php echo sed::decryption($arrayu["nombreempresa"]); ?>
                </strong>
              </p>
              <div style="margin-top: -15px; ">
                <div style="display: inline-block;">
                  <p>
                    <strong><?php echo sed::decryption($row['nombrecateg']); ?>
                  </p>
                </div>

                <div style="display: inline-block;">
                  <p style="margin-left: 25px; color:orangered; font-size: 22px; margin-top: -40px;">
                    <strong> S/.<?php
                                      if (!empty(sed::decryption(@$row['costoproducto']))) {
                                        echo sed::decryption(@$row['costoproducto']);
                                      } else {
                                        echo "Precio no definido";
                                      } ?></strong>
                  </p>
                </div>
              </div>
              <p style="margin-top: -10px;">
                <a class="btn btn-primary" href="verproducto.php?idproducto=<?php echo $row['idproducto']; ?>" style="width:150px; display: inline-block;" role="button" value="Ver torta">
                  <strong>Ver</strong>
                </a>
            </div>
          </div>
          <div style="width: 90%; margin-left: 6px; background: blue; height: 3px; margin-top: 3px;"></div>
        <?php } ?>
      </div><br>
    <?php
      } else { ?>
      <div class="container container-web-page ">
        <div class="row justify-content-md-center border-primary" style="background-color: orange;border-radius: 35px; width: 100%; margin-left: 0;">
          <div class="col-12 col-md-6">
            <figure class="full-box">
              <center>
                <img src="img/buscar.png" alt="registration_killaripostres" class="img-fluid">
              </center>
            </figure>
          </div>
          <div class="w-100"></div>
          <div class="col-12 col-md-6">
            <h3 style="color:white;" class="text-center text-uppercase poppins-regular font-weight-bold">
              <strong>No se encontró. </strong></h3>

            <p class="text-justify">
              <center>
                <strong style="color:white;">
                  intente buscar nuevamente correctamente.
                </strong>

              </center>
            </p>
          </div>
        </div>
      </div><br>
    <?php } ?>
  <?php } else { ?>
    <div class="container container-web-page ">
      <div class="row justify-content-md-center border-primary" style="background-color: orange;border-radius: 35px; width: 100%; margin-left: 0;">
        <div class="col-12 col-md-6">
          <figure class="full-box">
            <center>
              <img src="img/buscar.png" style="height: 340px;" alt="KillariPostres" class="img-fluid">
            </center>
          </figure>
        </div>
        <div class="w-100"></div>
        <div class="col-12 col-md-6">
          <!--<h3 style="color:white;" class="text-center text-uppercase poppins-regular font-weight-bold">
            <strong> Aquí se mostrarán las tortas que busques
              bm53Y1paZG5LNHlENUd5WElzWDYxZz09
              RTR2VHZrVkNHTjU0eERsejYwMmdiQT09
            </strong></h3>-->

          <p class="text-justify">
            <center>
              <strong style="color:white; font-size: 18px;">
                Busca el producto.</strong>

            </center>
          </p>
        </div>
      </div>
    </div><br>
  <?php } ?>
</body>

</html>