<?php
	$con = mysql_connect("localhost", "root", "") or exit("No se pudo conectar con el servidor") ;
	$abreBD = mysql_select_db("hotel", $con) ;
	mysql_query("SET NAMES 'utf8'") ;

	// if (!isset($_SESSION["con"]))
		// $_SESSION["con"] = $con ;

	if (!$abreBD) {
 		die('No se pudo abrir la base de datos.Error:' . mysql_error()) ;
	}
?>
