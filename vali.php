<?php

require("connectdb.php"); //requerir la conexion a la base de datos
require("sed.php");
//Se pone las variables con lo que queremos recoger los datos del formulario anterior
$username = $_POST['mail']; //mail es el nombre del cuadro de texto del input
$pas = $_POST['pass']; //recoge el password que ingresamos
$email1=sed::encryption($username);
$pa=sed::encryption($pas);
//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
//para el administrador
$sql2 = mysqli_query($mysqli, "SELECT * FROM login WHERE email='$email1' and pasadmin='$pa'"); //guardar la toda consulta seleccionada de la tabla login donde la columna email sera asignado por el mail del formulario
if ($u = mysqli_fetch_assoc($sql2)) { //verificamo si $f2 que es una variable cualquiera que obtenga los datos de la consulta $sql2
    //my_fetch_assoc();->Devuelve una matriz asociativa que corresponde a la fila recuperada y mueve el apuntador de datos interno hacia adelante.
    if ($pas == sed::decryption($u['pasadmin'])) { //si $f2 encuentra que el username es igual al pasadmin o la $pass quiere decir que es el administrador que se esta autentificando en el login
        $_SESSION['id'] = $u['id'];
        $_SESSION['user'] = sed::decryption($u['user']); //es el nombre de quien se esta autentificandose con el query
        $_SESSION['apellido'] = sed::decryption($u['apellido']);
        $_SESSION['email'] = sed::decryption($u['email']);
        $_SESSION['rol'] = sed::decryption($u['rol']);

        //si se cumple todo eso mostrara un alert diciendo bienvenido administrador
        //echo '<script>alert("BIENVENIDO ADMINISTRADOR")</script> ';
       echo "<script>location.href='adm.php'</script>"; //y lo referenciara a la pagina del administrador
    }else {
          echo '<div class="alert alert-danger" role="alert">
        Contraseña del administrador incorrecto
      </div>';
        echo "<script>location.href='log.php'</script>";
    }
}
//para los usuarios normales
$sql = mysqli_query($mysqli, "SELECT * FROM login WHERE email='$email1'");
if ($f = mysqli_fetch_assoc($sql)) {
    if ($pas == sed::decryption($f['pass'])) {
        $_SESSION['id'] = $f['id'];
        $_SESSION['user'] = sed::decryption($f['user']);
        $_SESSION['apellido'] = sed::decryption($f['apellido']);
        $_SESSION['email'] = sed::decryption($f['email']);
        $_SESSION['rol'] = sed::decryption($f['rol']);
         //echo '<script>alert("Bienvenido usuario")</script> ';
         echo "<script>location.href='inicio.php'</script>";
        // echo $_SESSION['nombreu'] . " usuario: ". $f['user'];
         //echo "Error al insertar: " . $sql . "<br>" . mysqli_error($mysqli);
    } else {       
       echo '<div class="alert alert-danger" role="alert">
        Contraseña del usuario incorrecto
      </div>';
        echo "<script>location.href='log.php'</script>";
    }
} else {
     echo '<div class="alert alert-danger" role="alert">
   ESTE USUARIO NO EXISTE, PORFAVOR REGISTRESE PARA PODER INGRESAR
 </div>';
    echo "<script>location.href='log.php'</script>";
}
?>