<?php
$host = "localhost";
$root = "root";
$password = "";
$db = "restaurantapp";


$tabla_db1 = "logueo";

@$mysqli = new MySQLi($host, $root, $password, $db);
if (@$mysqli->connect_error) {
	die("Fallo la conexión a MySQl");
} else {
	//echo "Conexión exitosa!";
}
?>
