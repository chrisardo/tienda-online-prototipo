<?php
//session_start();
$Imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
$tamano_imagen = $_FILES['imagen']['size'];
$tipoimagen = $_FILES['imagen']['type'];
$nombreuser = $_POST['nombre'];
$nombreusuario = $_POST['username'];
$mail = $_POST['emai'];
$direccion_empre = $_POST['direccion'];
$celular = $_POST['celular'];
@$politicause = $_POST['politica'];
$ciudaduse = $_POST['ciudad'];
$passuser = $_POST['pass'];
$rpassuser = $_POST['rpass'];

$captcha = $_POST['g-recaptcha-response'];
$secret = '6Lf4uRsiAAAAAI23tv2gvu5ymarAs8rFVrWQiE9J';

require("connectdb.php"); //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
if (!empty($nombreuser) && !empty($direccion_empre) && !empty($nombreusuario) && !empty($mail) && $celular > 0 && !empty($passuser) && !empty($rpassuser)) {
    $nombree = sed::encryption($nombreuser);
    $nombreusuarioe = sed::encryption($nombreusuario);
    $maile = sed::encryption($mail);
    $direccione = sed::encryption($direccion_empre);
    $clavee = sed::encryption($passuser);
    $rpasse = sed::encryption($rpassuser);
    $role = sed::encryption("a1");
    $celularp = "51" . $celular;
    if ($Imagen) {
        if ($tamano_imagen <= 3000000) {
            if ($tipoimagen == "image/jpeg" || $tipoimagen == "image/jpg" || $tipoimagen == "image/png" || $tipoimagen == "image/gif") {

                if ($celularp <= 51999999999 && $celularp >= 51900000000) {
                    if (!empty($politicause)) {
                        $checkemail = mysqli_query($mysqli, "SELECT * FROM logueo_empresa WHERE correoempresa='$maile'");
                        $check_mail = mysqli_num_rows($checkemail);
                        if ($passuser == $rpassuser) {
                            if ($check_mail > 0) {
                                echo '<div class="alert alert-danger" role="alert">
                            Atencion, ya existe el email y/o username designado para un usuario, verifique sus datos.
                          </div>';
                                //echo "<script>location.href='registro.php'</script>";
                            } else {
                                if (!$captcha) {
                                    echo '<div class="alert alert-danger" role="alert">
                        Por favor verifica el captcha
                      </div>';
                                } else {
                                    @$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
                                    $arr = json_decode(@$response, TRUE);
                                    if ($arr['success']) {
                                        $qlogueo = "INSERT INTO logueo_empresa 
                            (imagempresa, nombreempresa, celularempresa, username_empresa, contrase_empresa, correoempresa, direccionempresa, codigorol, fecharegistro_empresa, terminos, estado, codciudad) 
                            VALUES('$Imagen', '$nombree', '$celular', '$nombreusuarioe','$clavee','$maile','$direccione', '3', now(),'$politicause','0', '$ciudaduse')";
                                        $resultlogueo = $mysqli->query($qlogueo);
                                        if ($resultlogueo) {
                                            echo '<div class="alert alert-primary" role="alert">Registro exitoso, ahora puedes loguearte. </div>';
                                            //echo "<script>location.href='logueo.php'</script>";
                                        } else {
                                            echo '<div class="alert alert-danger" role="alert"> Hubo problemas al insertar los datos del logueo </div>';
                                            echo "Error: " . $query . "<br>" . mysqli_error($mysqli);
                                            //echo "<script>location.href='registro.php'</script>";
                                        }
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert">
                            Error al comprobar Captcha.
                          </div>';
                                    }
                                }
                            }
                        } else {
                            echo '<div class="alert alert-danger" role="alert">
                        Las contraseñas no coinciden
                        </div>';
                            //echo "<script>location.href='registro.php'</script>";
                        }
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Tienes que aceptar los términos y condiciones.</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger" role="alert">El numero de celular tiene que ser de 9.</div>';
                    //echo "<script>location.href='registro.php'</script>";
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
        echo '<div class="alert alert-danger" role="alert">Pon una imagen de tu empresa.</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">Te faltan datos por completar.</div>';
    //echo "<script>location.href='registro.php'</script>";
}
