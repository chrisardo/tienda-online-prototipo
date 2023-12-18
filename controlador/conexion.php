<?php
$conexion = mysqli_connect(
    $host = 'localhost',
    $user = 'root', //root
    $pass = '',//0NibqO2Fl4IBT9
    $dbname = 'tiendaonline' // dbname: restaurantapp
);
if ($conexion->connect_error) {
	die("Fallo la conexión a MySQL");
	exit();
}
?>