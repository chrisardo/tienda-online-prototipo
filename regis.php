<?php
require("conexion.php");
//session_start();
$nombreuser = $_POST['nombre'];
$apellidouser = $_POST['apellido'];
$mail = $_POST['emai'];
$nombreusuario = $_POST['username'];
$celular = $_POST['celular'];
$fechnacimiento = $_POST['fechanaci'];
//$fechaBD = date("d-m-Y", strtotime($fechnacimiento));
$generouse = $_POST['genero'];
@$politicause = $_POST['politica'];
$passuser = $_POST['pass'];
$rpassuser = $_POST['rpass'];

$captcha = $_POST['g-recaptcha-response'];
$secret = '6Lf4uRsiAAAAAI23tv2gvu5ymarAs8rFVrWQiE9J';

function calculaedad($fechanacimiento)
{
    list($ano, $mes, $dia) = explode("-", $fechanacimiento);
    $ano_diferencia  = date("Y") - $ano;
    $mes_diferencia = date("m") - $mes;
    $dia_diferencia   = date("d") - $dia;
    if ($dia_diferencia < 0 || $mes_diferencia < 0)
        $ano_diferencia--;
    return $ano_diferencia;
}
$edadusuario = calculaedad($fechnacimiento);
// Modo de uso
//echo calculaedad($fechnacimiento); // Imprimirá: 30
//echo $edadusuario; // Imprimirá: 30

require("connectdb.php"); //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
if (!empty($nombreuser) && !empty($apellidouser) && !empty($nombreusuario) && !empty($mail) && $celular > 0 && !empty($passuser) && !empty($rpassuser)) {
    $nombree = sed::encryption($nombreuser);
    $apellidoe = sed::encryption($apellidouser);
    $fechnacime = sed::encryption($fechnacimiento);
    $maile = sed::encryption($mail);
    $nombreusuarioe = sed::encryption($nombreusuario);
    $generousue = sed::encryption($generouse);
    //$gue = sed::encryption($ug);
    $clavee = sed::encryption($passuser);
    $rpasse = sed::encryption($rpassuser);
    $role = sed::encryption("a1");
    $celularp = "51" . $celular;
    if ($celularp <= 51999999999 && $celularp >= 51900000000) {
        if ($edadusuario >= 17) {
            if (!empty($politicause)) {
                $checkemail = mysqli_query($mysqli, "SELECT * FROM logueo WHERE emailusu='$maile'");
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
                                //echo  sed::decryption($generousue);
                                /*$qrol = "INSERT INTO rol(rol, terminos, baneo) VALUES('$role','$politicause','0')";
                                $resultado_rol = $mysqli->query($qrol);
                                if ($resultado_rol) {
                                    $querol = "SELECT*FROM rol";
                                    $rolconsul = mysqli_query($mysqli, $querol);
                                    $rolus = mysqli_fetch_all($rolconsul, MYSQLI_ASSOC);
                                    foreach ($rolus as $ro) {
                                        $idrol = $ro['idrol'];
                                    }
                                    //echo "<script>location.href='logueo.php'</script>";
                                } else {
                                    echo '<div class="alert alert-danger" role="alert"> Hubo problemas al insertar rol. </div>';
                                    echo "Error: " . $query . "<br>" . mysqli_error($mysqli);
                                    //echo "<script>location.href='registro.php'</script>";
                                }*/
                                $qlogueo = "INSERT INTO logueo (nombreusu, apellidousu, contrausu,emailusu, usernameusu, celularusu, contraadmin, codigorol, fechanaci, generousu,fecharegistro, baneo) 
                                VALUES('$nombree', '$apellidoe', '$clavee','$maile','$nombreusuarioe','$celularp', '', '1','$fechnacimiento','$generousue', now(), '1')";
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
                echo '<div class="alert alert-danger" role="alert">
                Tienes que aceptar los términos y condiciones.
                </div>';
            }
        } else if ($edadusuario < 17) {
            echo '<div class="alert alert-danger" role="alert">
            Usuarios menores de 17 años no pueden registrarse.
            </div>';
            //echo "<script>location.href='registro.php'</script>";
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">
        El numero de celular tiene que ser de 11.
        </div>';
        //echo "<script>location.href='registro.php'</script>";
    }
} else {
    echo '<div class="alert alert-danger" role="alert">
    Te faltan datos por completar.
    </div>';
    //echo "<script>location.href='registro.php'</script>";
}
