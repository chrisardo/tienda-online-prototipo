<?php
session_start();
if (@$_SESSION['idusu']) {
	session_destroy(); //destruir las variables de session
	echo "<script>location.href='logueo.php'</script>";
} else {
	echo "<script>location.href='logueo.php'</script>";
}
?>
