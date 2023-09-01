<?php
//validar
session_start();
if (@!$_SESSION['idusu']) {
    echo "<script>location.href='logueo.php'</script>";
} elseif ($_SESSION['rolusu'] == "a1") {
    /*if ((time() - $_SESSION['last_login_timestamp']) > 1240) { // 900 = 15 * 60  
        setcookie("cerrarsesion", 1, time() + 86400); //6o segundos es 1 minuto, 86400 segundos es por 24 horas
        echo "<script>location.href='desconectar.php'</script>";
    } else {
        $_SESSION['last_login_timestamp'] = time();
    }*/ } else {
    echo "<script>location.href='logueo.php'</script>";
}
ob_start(); //captura el contenido html para convertir en pdf
?>
<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte lista productos | RestaurantApp</title>
    <link rel="icon" href='http://<?php echo $_SERVER['HTTP_HOST'];?>/RestaurantApp/img/logo.png' sizes="32x32" type="img/jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css2/style.css" />
</head>

<body>
    <?php
    require("connectdb.php");
    include("conexion.php");
    include 'sed.php';
    //extract($_GET);
    $idlog = @$_SESSION['idusu'];
    $consulta = ("SELECT * FROM logueo  WHERE logueo.idusu='$idlog'");
    $query1 = mysqli_query($mysqli, $consulta);
    $persona = mysqli_fetch_all($query1, MYSQLI_ASSOC);
    foreach ($persona as $array) {
        $imagperfi = base64_encode($array['imagperfil']);
        $nom = sed::decryption($array["nombreusu"]);
        $apelli = sed::decryption($array["apellidousu"]);
    }
    ?>
    <center>
        <h1 style="color:blue;"><strong>Reporte de la lista de sus productos</strong></h1>
    </center>
    <?php
    if (@!$_SESSION['idusu']) { //si la session del usuario esta vacia
        ?>
        <?php
            //El @ oculta los mensajes de error que pueda salir
        } else if ($_SESSION['rolusu'] == "a1") { //sino si la session rol no esta vacia
            $id_us = $_SESSION['idusu'];
            //$query = "SELECT*FROM productos ORDER BY idproducto DESC";

            $sqlq = "SELECT p.idproducto idproducto, p.imagproducto imagproducto, p.nombreproducto nombreproducto, p.costoproducto costoproducto, p.detalleproducto, 
            p.cantistock, p.idcategoria
           FROM productos p   ORDER BY idproducto DESC";
            $resul_cant = mysqli_query($conexion, $sqlq);
            $cantidad = mysqli_num_rows($resul_cant);
            $torta = mysqli_fetch_all($resul_cant, MYSQLI_ASSOC);

            if ($cantidad > 0) {
                ?>
            <div style="width: 95%; margin-left: 12px; border:2px solid blue;">
                <div style="width: 100%; border:2px solid blue;">
                    <!--<img src="http://<?php //echo $_SERVER['HTTP_HOST'];?>/RestaurantApp/img/servicio.png" style="width: 30px; height: 30px; margin-left: 6px; margin-top: -10px;">-->
                    <h1 style="display: inline-block; font-size: 18px; margin-left:2px;">Productos registradas: <?php echo $cantidad; ?></h1>
                </div>

                <?php
                        foreach ($torta as $row) {
                            $id_torta = $row['idproducto'];
                            $imag_torta = base64_encode($row['imagproducto']);
                            $nombre_tort = sed::decryption($row['nombreproducto']);
                            $tipo_torta = sed::decryption($row['idcategoria']);
                            $costotorta = sed::decryption($row['costoproducto']);
                            $idcategprod = $row['idcategoria'];
                            $querycat = "SELECT*FROM categoria where idcategoria='$idcategprod' ORDER BY idcategoria DESC";
                            $resultcat = mysqli_query($conexion, $querycat);
                            $catego = mysqli_fetch_all($resultcat, MYSQLI_ASSOC);
                            foreach ($catego as $row2) {
                                $id_categ = $row2['idcategoria'];
                                $imag_categ = base64_encode($row2['imagen']);
                                $nombre_categ = sed::decryption($row2['nombrecateg']);
                                $descripcion_categ = sed::decryption($row2['descripcioncateg']);
                            }
                            ?>
                    <div style="width: 99%; margin-left: 4px;">
                        <div style="display: inline-block; ">
                            <img src="data:image/jpg;base64,<?php echo $imag_torta; ?>" style="width: 100px; height: 105px; margin-top: 30px;">
                        </div>
                        <div style="display: inline-block;">
                            <p style="color:blue;"><strong><?php echo $nombre_tort; ?></strong></p>
                            <p style="color:orange;  margin-top:-16px;"><strong>Empresa: <?php //echo $nombre_tort; 
                                                                                                                        ?></strong></p>
                            <p style="margin-top: -10px; "><strong><?php
                                                                                if (!empty($nombre_categ)) {
                                                                                    echo $nombre_categ;
                                                                                } else {
                                                                                    echo "Se eliminó la categoria";
                                                                                }
                                                                                ?></strong></p>
                            <p style="margin-top: -10px;">
                                <?php echo "S/." . $costotorta; ?>
                            </p>
                        </div>
                    </div>
                    <div style="width: 92%; margin-left: 10px; background: blue; height: 3px; margin-top: 2px;"></div>
        <?php
                }
            }
        }
        ?>
</body>

</html>
<?php
$html = ob_get_clean(); //muestra l el html capturado para convertir en pdf
//$html = '<img src="data:image/svg+xml;base64,' . base64_encode($svg) . '" ...>';
//echo $html;
require_once 'libreria/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$options = $dompdf->getOptions();
//$options->setDefaultFont('Courier');
$options->set(array('isRemotEnabled' => true));
$dompdf->setOptions($options);

//$dompdf->loadHtml("Hola pdf");
$dompdf->loadHtml($html);
//$dompdf->setPaper('letter');
$dompdf->setPaper('A4', 'landscape'); // formato y orientacion del pdf
$dompdf->render(); //poner todo visible
$dompdf->stream("archivo.pdf", array("Attachment" => false));
?>