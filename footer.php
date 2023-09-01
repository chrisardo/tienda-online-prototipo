<?php
if (@!$_SESSION['idusu']) { //si la session del usuario esta vacia
  ?>
  <footer style="background-color: blue;" class="main-footer">
    <div class="container container--flex">
      <div class="column column--33">
        <h4 class="column__title">RestaurantApp</h4>
        <p class="column__txt"><img rel="icon" src='img/home.png' style="width: 20px; height: 27px;" type="img/jpg" /><a href="index.php" style="color: white;"> Inicio </a></p>
        <!--<p class="column__txt"><img src="img/inf.png" style="width: 20px; height: 25px;"><a href="nosotros.php" style="color: white;">Nosotros</a></p>-->
        <p class="column__txt" style="margin-top: -8px; color:white;"><img src="img/servicio.png" style="width: 20px; height: 27px;"><a href="tipostortas.php" style="color: white;"> Menú</a></p>
        <p class="column__txt" style="margin-top: -9px; color:white;"><img rel="icon" src='img/login.png' style="width: 20px; height: 25px;" type="img/jpg" /><a style="color: white;" href="logueo.php">Login</a> </p>
      </div>
      <div class="column column--33">
        <h4 class="column__title">Contáctanos</h4>
        <p class="column__txt" style="margin-top: -8px;"><img rel="icon" src='img/celu.png' style="width: 20px; height: 27px;" type="img/jpg" /><a>966820221</a></p>
        <!--<p class="column__txt" ><img rel="icon" src='img/localiza.png' style="width: 12px; height: 27px;" type="img/jpg"/><a>Monitor Húascar#811</a></p>-->
        <!--<p class="column__txt" style="color:white;"><img rel="icon" src='img/politicaprivacidad.png' style="width: 12px; height: 25px;" type="img/jpg"/><a style="color: white;" href="politicaprivacidad.php">Politica privacidad</a> </p>-->
        <p class="column__txt" style="margin-top: -8px;"><img rel="icon" src='img/peru.png' style="width: 14px; height: 27px;" type="img/jpg" /><a>Iquitos-Perú</a> </p>
      </div>
      <div class="column column--33">
        <h4 class="column__title">Síguenos</h4>
        <p class="column__txt"><img rel="icon" src='img/facebook.png' style="width: 18px; height: 27px;" type="img/jpg" /><a target="_blank" style="color:white;" href="https://m.facebook.com/Killari-Postres-108584787716630/?tsid=0.49677764080709563&source=result">Facebook</a></p>
        <p class="column__txt" style="margin-top: -8px;"><img rel="icon" src='img/instagram.png' style="width: 20px; height: 27px;" type="img/jpg" /><a target="_blank" style="color:white;" href="https://www.instagram.com/killaripostres/">Instagram</a></p>
        <p class="column__txt" style="margin-top: -9px;"><img rel="icon" src='img/hellchapp.jpeg' style="width: 16px; height: 24px;" type="img/jpg" /><a target="_blank" style="color:white;" href="https://play.google.com/store/apps/details?id=hellchapp.ha">HellchApp</a></p>
      </div>
      <p class="copy" style="font-size: 13px;">Developed by: CoDevPro Technology &copy;2022</p>
    </div>
  </footer>
<?php
  //El @ oculta los mensajes de error que pueda salir
} else if ($_SESSION['rolusu'] == "user") { //sino si la session rol no esta vacia
}
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha256-OUFW7hFO0/r5aEGTQOz9F/aXQOt+TwqI1Z4fbVvww04=" crossorigin="anonymous"></script>

<script src="./js/script2.js"></script>