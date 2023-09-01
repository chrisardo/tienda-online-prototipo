<?php
session_start();
require("connectdb.php");
include("conexion.php");
include 'sed.php';
//validar
if (@!$_SESSION['idusu']) {
    echo "<script>location.href='logueo.php'</script>";
} elseif ($_SESSION['rolusu'] == "a1" || $_SESSION['rolusu'] == "empresa") {
    /*if ((time() - $_SESSION['last_login_timestamp']) > 1240) { // 900 = 15 * 60  
        setcookie("cerrarsesion", 1, time() + 86400); //6o segundos es 1 minuto, 86400 segundos es por 24 horas
        echo "<script>location.href='desconectar.php'</script>";
    } else {
        $_SESSION['last_login_timestamp'] = time();
    }*/ } else {
    echo "<script>location.href='logueo.php'</script>";
}
extract($_GET);
$sql1 = "SELECT * FROM productos WHERE idproducto=$id";
$resultado = mysqli_query($conexion, $sql1);
$persona = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
/*foreach ($persona as $rows) {
    $idproducto = $rows['idproducto'];
    $img_producto = base64_encode($rows['imagproducto']);
    $nombre_producto = sed::decryption($rows['nombreproducto']);
    $idcate_producto = sed::decryption($rows['idcategoria']);
    $precio_producto = sed::decryption($rows['costoproducto']);
}*/
foreach ($persona as $ro) {
    $id = $ro['idproducto'];
    $codprodu = sed::decryption($ro['codigoproducto']);
    $idu_prod= $ro['idusu'];
    $image = base64_encode($ro['imagproducto']);
    $nombreproduc = sed::decryption($ro['nombreproducto']);
    $tipotorta = sed::decryption($ro['idcategoria']);
    $precioproduc = sed::decryption($ro['costoproducto']);
    $detalleproduc = sed::decryption($ro['detalleproducto']);
    $idcategprod = $ro['idcategoria'];
    $querycat = "SELECT*FROM categoria where idcategoria='$idcategprod' ORDER BY idcategoria DESC";
    $resultcat = mysqli_query($conexion, $querycat);
    $catego = mysqli_fetch_all($resultcat, MYSQLI_ASSOC);
    foreach ($catego as $row2) {
        $id_categ = $row2['idcategoria'];
        $imag_categ = base64_encode($row2['imagen']);
        $nombre_categ = sed::decryption($row2['nombrecateg']);
        $descripcion_categ = sed::decryption($row2['descripcioncateg']);
    }
    $consulta_u = ("SELECT * FROM logueo  WHERE logueo.idusu='$idu_prod'");
    $query1u = mysqli_query($mysqli, $consulta_u);
    $personau = mysqli_fetch_all($query1u, MYSQLI_ASSOC);
    foreach ($personau as $arrayu) {
        $imgperfi = base64_encode($arrayu['imagperfil']);
        $nombre_empresa = sed::decryption($arrayu["nombreusu"]);
        $apellidop = sed::decryption($arrayu["apellidousu"]);
    }
}

ob_start(); //captura el contenido html para convertir en pdf
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title><?php echo $nombreproduc; ?>| Periko's</title>
    <link rel="icon" href='data:image/jpg;base64,<?php echo $image; ?>' sizes="32x32" type="img/jpg">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css2/style.css" />

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css2/invitado.css">
    <link rel="stylesheet" href="css/estilosgaleria.css">
    <link rel="stylesheet" href="css/contact.css">
</head>

<body>
    <center>
        <li>
            <div class="invi border-primary " style=" border:2px solid blue; width: 50%;" category="iquitos">
                <?php
                if ($image) {
                    ?>
                    <img src="data:image/jpg;base64,<?php echo $image; ?>" style="width: 100%; height: 160px;" alt="imagen invitado">
                <?php
                } else {
                    ?>
                    <img src="img/fotoperfil.png" style="width: 100%; height: 160px;" alt="imagen invitado">
                <?php
                }
                ?>
            </div>
        </li>
    </center>
    <div style="margin-left: 16px; margin-top: 3px;">
        <h1 style="color:blue;"><strong>Información básica</strong></h1>
        <p><strong>Código del producto: <?php echo $codprodu; ?> </strong></p>
        <p><strong>Nombre del producto: <?php echo $nombreproduc; ?> </strong></p>
        <p><strong>Empresa: <?php echo $nombre_empresa; 
                            ?> </strong></p>
        <p><strong>Categoria del producto: <?php if (!empty($nombre_categ)) {
                                                echo $nombre_categ;
                                            } else {
                                                echo "Se eliminó la categoria";
                                            } ?> </strong></p>
        <p><strong>Precio del producto: S/.<?php
                                        if (!empty($precioproduc)) {
                                            echo $precioproduc;
                                        } else {
                                            echo "Indefinido el precio";
                                        } ?> </strong></p>
        <p><strong>Detalle del producto: <?php echo $detalleproduc; ?></strong>
        </p>
    </div>
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
$options->setDefaultFont('Courier');
$options->set(array('isRemotEnabled' => true));
$dompdf->setOptions($options);

//$dompdf->loadHtml("Hola pdf");
$dompdf->loadHtml($html);
//$dompdf->setPaper('letter');
$dompdf->setPaper('A4', 'landscape'); // formato y orientacion del pdf
$dompdf->render(); //poner todo visible
$dompdf->stream("archivo.pdf", array("Attachment" => false));
?>