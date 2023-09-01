<?php
//validar
session_start();
if (@!$_SESSION['idusu']) {
  echo "<script>location.href='logueo.php'</script>";
} elseif ($_SESSION['rolusu'] == "user") {
  /*if ((time() - $_SESSION['last_login_timestamp']) > 240) { // 900 = 15 * 60  
    setcookie("cerrarsesion", 1, time() + 60000); //6o segundos es 1 minuto, 86400 segundos es por 24 horas
    echo "<script>location.href='desconectar.php'</script>";
  } else {
    $_SESSION['last_login_timestamp'] = time();
  }*/
} else {
  echo "<script>location.href='logueo.php'</script>";
}
?>
<!doctype html>
<html class="no-js" lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Reservar | Killari Postres</title>
  <link rel="icon" href='img/logokillari.jpg' sizes="32x32" type="img/jpg">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
  <link rel="stylesheet" href="css2/style.css" />
</head>

<body>
  <?php
  require("connectdb.php");
  include("conexion.php");
  include 'sed.php';
  $idlog = @$_SESSION['id'];
  $consulta = ("SELECT * FROM login  WHERE login.id='$idlog'");
  $query1 = mysqli_query($mysqli, $consulta);
  $persona = mysqli_fetch_all($query1, MYSQLI_ASSOC);
  foreach ($persona as $array) {
    $imagperfi = base64_encode($array['imagenperfil']);
    $nom = sed::decryption($array["user"]);
    $apelli = sed::decryption($array["apellido"]);
  }
  ?>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-sm-start fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-99 mr-auto" style="font-size:13px;" href="#">
        <img src="img/logokillari.jpg" style="width: 32px; height: 32px;" alt="logo killaripostres">
        <strong>KillariPostres</strong>
      </a>
      <button class="navbar-toggler align-self-start" type="button">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse bg-primary p-3 p-lg-0 mt-5 mt-lg-0 d-flex flex-column flex-lg-row flex-xl-row justify-content-lg-end mobileMenu" id="navbarSupportedContent">
        <ul class="navbar-nav align-self-stretch">
          <li class="nav-item ">
            <a class="nav-link" href="index.php">
              <img src="img/inicio.png" style="width: 26px; height: 20px;"><strong> INICIO</strong></a>
          </li>
          <div class="dropdown-divider"></div>
          <li class="nav-item">
            <a class="nav-link" href="tipostortas.php">
              <img src="img/tipostortas.png" style="width: 24px; height: 20px;"><strong> TORTAS</strong></a>
          </li>
          <div class="dropdown-divider"></div>
          <li class="nav-item">
            <a class="nav-link active" href="registro.php">
              <img src="img/reserv.png" style="width: 24px; height: 20px;"><u><strong> RESERVAR</strong></u></a>
          </li>
          <div class="dropdown-divider"></div>
          <li class="nav-item">
            <a class="nav-link" href="vereservas.php">
              <img src="img/ordenes.png" style="width: 24px; height: 20px;"><strong> VER PEDIDOS</strong></a>
          </li>
          <div class="dropdown-divider"></div>
          <li class="nav-item">
            <a class="nav-link" href="favoritos.php">
              <img src="img/favorito.png" style="width: 24px; height: 22px;"><strong> Favoritos</strong></a>
          </li>
        </ul>
      </div>
      <a class="navbar-brand order-1 order-justify-content-end" href="buscador.php">
        <img src="img/buscar.png" style="width: 40px; height: 40px;" alt="login">
      </a>
      <?php
      if (@!$_SESSION['user']) { //si la session del usuario esta vacia
        //El @ oculta los mensajes de error que pueda salir
      } else if ($_SESSION['rol'] == "u2") { //sino si la session rol no esta vacia

        ?>
        <a style="margin-left: 4px;" href="" class="navbar-brand order-1 order-justify-content-end">
          <?php
            if ($imagperfi) {
              ?>
            <img src="data:image/jpg;base64, <?php echo $imagperfi; ?>" style="width: 36px; height: 40px; border-radius: 14px;" alt="login">
          <?php
            } else {
              ?>
            <img src="img/fotoperfil.png" style="width: 40px; height: 40px;" alt="login">
          <?php
            }
            ?>
        </a>
      <?php
      }
      ?>
      <div style="margin-left: 16px;" class="navbar-brand order-1 order-justify-content-end dropdown show" id="yui_3_17_2_1_1636218170770_38">
        <a href="#" tabindex="0" class=" dropdown-toggle" style="color: white;" id="action-menu-toggle-1" aria-label="Menú de usuario" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" aria-controls="action-menu-1-menu">
          <b class="caret"></b>
        </a>
        <div class="dropdown-menu dropdown-menu-right menu align-tr-br" id="action-menu-1-menu" data-rel="menu-content" aria-labelledby="action-menu-toggle-1" role="menu" data-align="tr-br">
          <a href="opciones.php" class="dropdown-item menu-action select" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
            <img src="img/opcione.png" style="width: 26px; height: 22px;"><strong> VER MÁS OPCIONES</strong>
          </a>
          <div class="dropdown-divider border-primary"></div>
          <a href="verperfil.php" class="dropdown-item menu-action select" role="menuitem" data-title="mymoodle,admin" aria-labelledby="actionmenuaction-1">
            <img src="img/perfil.png" style="width: 26px; height: 22px;"><strong> PERFIL</strong>
          </a>
          <div class="dropdown-divider border-primary"></div>
          <a href="desconectar.php" class="dropdown-item menu-action" role="menuitem" data-title="profile,moodle" aria-labelledby="actionmenuaction-2">
            <img src="img/exi.png" style="width: 26px; height: 22px;"><strong> SALIR</strong>
          </a>
        </div>
      </div>
    </div>
  </nav><br><br><br>
  <center>
    <h2 style="color:blue;"><strong>Reserva su pedido</strong></h2>
  </center>
  <div class="container container--flex" style="width: 95%; background-color:orange; border-radius:16px;">
    <?php
    $session_id = $_SESSION['id'];
    $sql = ("SELECT * FROM login  WHERE login.id='$session_id'");
    $query = mysqli_query($mysqli, $sql);
    $persona = mysqli_fetch_all($query, MYSQLI_ASSOC);
    foreach ($persona as $arreglo) {
      $nombr = sed::decryption($arreglo['user']);
      $apellido = sed::decryption($arreglo['apellido']);
    }
    ?>
    <form action="" method="post" class="formulario column column--50 bg-orange">
      <div class="row g-3">
        <div class="col">
          <label for="" style="color:white; font-size: 14px;" class="formulario__label"><strong> NOMBRE: </strong></label>
          <input type="text" class="form-control" name="nombre" required="required" value="<?php echo (ucwords($nombr)); ?>" readonly="readonly" aria-label="First name">
        </div>
        <div class="col">
          <label for="" style="color:white; font-size: 14px;" class="formulario__label"><strong> APELLIDO:</strong> </label>
          <input type="text" class="form-control" name="apellidos" value="<?php echo (ucwords($apellido)); ?>" readonly="readonly" required="required" aria-label="Last name" />
        </div>
      </div>
      <div class="row g-3">
        <div class="col">
          <label for="" style="color:white; font-size: 14px;" class="formulario__label"><strong> TIPO DE OCASIÓN: </strong></label>
          <select id="soporte" class="form-control" name="tipocasion" required="required">
            <option value="-" selected="">Seleccione el tipo de ocasión</option>
            <?php
            $sql3 = "SELECT * FROM tortas group by tipotorta ORDER BY tipotorta DESC";
            $resultado = mysqli_query($conexion, $sql3);
            $persona = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            foreach ($persona as $row) {
              $idtorta = sed::decryption($row['id_torta']);
              $tipotorta = sed::decryption($row['tipotorta']);
              echo '<option value="' . $tipotorta . '">' . $tipotorta . '</option>';
            }
            ?>
          </select>
        </div>
        <div class="col">
          <label for="" style="color:white; font-size: 14px;" class="formulario__label"><strong> DISTRITO : </strong></label>
          <select id="soporte" class="form-control" name="distrito" required="required">
            <option value="-" selected="">Seleccione el distrito donde se encuentra</option>
            <option value="Punchana">Punchana</option>
            <option value="Maynas">Maynas</option>
            <option value="Belén">Belén</option>
            <option value="San Juan">San Juan</option>
            <option value="OTROS">OTRO</option>
          </select>
        </div>
      </div>
      <div class="row g-3">
        <div class="col">
          <label for="" style="color:white; font-size: 16px;" class="formulario__label"><strong>HORA DE ENTREGA: </strong></label>
          <input type="time" class="form-control" id="horaentrega" name="horaentrega" autocomplete="off" required="required">
        </div>
        <div class="col">
          <label for="" style="color:white; font-size: 16px;" class="formulario__label"><strong>FECHA DE ENTREGA: </strong></label>
          <input type="date" class="form-control" id="fechaentrega" name="fechaentrega" autocomplete="off" required="required">
        </div>
      </div>
      <div class="row g-3">
        <div class="col">
          <label for="" style="color:white;font-size: 14px;" class="formulario__label"><strong>CELULAR: </strong></label>
          <input type="number" class="form-control" name="celular" required="required" placeholder="Ejemplo: 51912345678">
        </div>
        <div class="col">
          <label for="" style="color:white;" class="formulario__label" style="width:100%"><strong>LUGAR ENTREGA:</strong> </label>
          <input class="form-control" type="text" id="direccionEnvio" name="direccion" placeholder="Ej. Urb. Iquitos calle 430" autocomplete="off" require="required">
        </div>
      </div>
      <div class="row g-3">
        <div class="col">
          <label for="" style="color:white; font-size: 14px;" class="formulario__label"><strong>Especifique qué diseño de la torta a pedir: </strong></label>
          <textarea name="disenotorta" id="" cols="30" rows="3" class="form-control formulario__textarea" placeholder="Especifique aqui sobre como quiere que sea la torta" required="required"></textarea>
        </div>
      </div>
      <center>
        <input type="submit" style="width:64%; margin-top: 4px;" id="entrar" class="btn btn-primary" name="enviar" value="ENVIAR RESERVA ">
      </center>
    </form>
  </div>
  <script>
    $(document).ready(function() {
      $('#entrar').click(function() { //Se desabilita al darle click al boton
        if ($(this).val() != '') {
          $('#entrar').prop('disabled', false);
        } else {
          $('#entrar').prop('disabled', true);
        }
      });
    });
  </script>
  <?php
  if (isset($_POST['enviar'])) {
    $id_use = $_SESSION['id'];
    $tipocasion = $_POST['tipocasion'];
    $distrito = $_POST['distrito'];
    $disenotorta = $_POST['disenotorta'];
    $celular = $_POST['celular'];
    $fechaentrega = $_POST['fechaentrega'];
    $horaentrega = $_POST['horaentrega'];
    $direccion = $_POST['direccion'];
    $tipocasione = sed::encryption($tipocasion);
    $distritoe = sed::encryption($distrito);
    $disenotortae = sed::encryption($disenotorta);
    $fechaentregae = sed::encryption($fechaentrega);
    $direccione = sed::encryption($direccion);
    if (!empty($tipocasion) && !empty($distrito) && !empty($disenotorta) && !empty($fechaentrega) && !empty($direccion)) {
      if ($celular <= 51999999999 && $celular >= 51900000000) {
        $sql = "INSERT INTO reservas (tipocasion,distrito,disenotorta,celular,fechaentrega,horaentrega,direccion,id, estado) 
            VALUES ('$tipocasione','$distritoe','$disenotortae','$celular','$fechaentregae','$horaentrega','$direccione', '$id_use', '0')";
        $resultado = mysqli_query($conexion, $sql);
        if ($resultado == 1) {
          //echo "Datos ingresados";
          echo "<script>location.href='reservaenviada.php'</script>";
        }
      } else {
        echo '<div class="alert alert-danger" role="alert">"El numero de celular tiene que ser de 9 números. </div>';
        //echo "<script>location.href='registro.php'</script>";
      }
    } else {
      echo '<div class="alert alert-danger" role="alert">Hubo problemas al reservar. </div>';
      //header('Location:registro.php');
    }
  }
  include('footer.php');
  ?>
</body>

</html>