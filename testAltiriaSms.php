<?php
// Copyright (c) 2020, Altiria TIC SL
// All rights reserved.
// El uso de este c�digo de ejemplo es solamente para mostrar el uso de la pasarela de env�o de SMS de Altiria
// Para un uso personalizado del c�digo, es necesario consultar la API de especificaciones t�cnicas, donde tambi�n podr�s encontrar
// m�s ejemplos de programaci�n en otros lenguajes y otros protocolos (http, REST, web services)
// https://www.altiria.com/api-envio-sms/

// XX, YY y ZZ se corresponden con los valores de identificacion del
// usuario en el sistema.
include('httpPHPAltiria.php');
include("abrirconexion.php");
include 'sed.php';
if (isset($_POST['btn_consultar'])) {
  if($_SERVER["REQUEST_METHOD"]=="POST"){
    $celular = $_POST['celular'];
    $altiriaSMS = new AltiriaSMS();
    //$altiriaSMS->setUrl("http://www.altiria.net/api/http");
    $altiriaSMS->setLogin('chrisardorolo02@gmail.com');
    $altiriaSMS->setPassword('9bgt58ey');//contraseña:9bgt58ey
    //Use this ONLY with Sender allowed by altiria sales team
    //$altiriaSMS->setSenderId('TestAltiria');
    //Concatenate messages. If message length is more than 160 characters. It will consume as many credits as the number of messages needed
    //$altiriaSMS->setConcat(true);
    //Use unicode encoding (only value allowed). Can send ����� but message length reduced to 70 characters
    //$altiriaSMS->setEncoding('unicode');
    $altiriaSMS->setDebug(true);
    $sDestination ='51916376338'; //$_POST['celular'];
    if ($celular <=51999999999 && $celular>=51900000000) {
      $resultados = mysqli_query($conexion, "SELECT * FROM login WHERE celular = '$celular'");
      while ($consulta = mysqli_fetch_array($resultados)) {
        $sMensaje= "Hola " . sed::decryption($consulta['user']) . " ". sed::decryption($consulta['apellido']) ." !! su contraseña es: " . sed::decryption($consulta['pass']) . " Saludos Killari Postres";
        $response = $altiriaSMS->sendSMS($sDestination, $sMensaje);
           echo '<div class="alert alert-primary" role="alert">
        Su contraseña fue enviado a su mensajería de celular.
        </div>';
        echo "<script>location.href='recupe.php'</script>";
      }
      if (!$response)
           echo '<div class="alert alert-danger" role="alert">
        El env�o ha terminado en error
		  </div>';
      else
        echo $response;
        echo "<script>location.href='recupe.php'</script>";
    } else {
        echo '<div class="alert alert-danger" role="alert">
      El numero de celular tiene que ser de 11.
      </div>';
      //echo "<script>location.href='recupe.php'</script>";
    }
  }
}
?>

