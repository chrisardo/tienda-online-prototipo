<?php
// Parametros a configurar para la conexion de la base de datos 
$host = "localhost";    //localhost sql104.epizy.com sera el valor de nuestra BD 
$basededatos = "id17944777_killaripostres"; //epiz_30181140_killaripostres sera el valor de nuestra BD 
$usuariodb = "id17944777_killaripostresi"; //epiz_30181140 sera el valor de nuestra BD 
$clavedb = "]kKv\B4E<8hmRQ>#";    //0NibqO2Fl4IBT9 sera el valor de nuestra BD 
//Lista de Tablas
$tabla_db1 = "login"; 	   // tabla de usuarios


//error_reporting(0); //No me muestra errores

$conexion = new mysqli($host, $usuariodb, $clavedb, $basededatos);


if ($conexion->connect_error) {
	die("Fallo la conexión a MySQL: (" . $conexion->connect_error);
	exit();
}
?>