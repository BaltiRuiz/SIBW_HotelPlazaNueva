<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>HOTEL PLAZA NUEVA</title>
		<link rel="stylesheet" type="text/css" href="estilos/default.css" />
		<script src="scripts/slider.js"></script>
	</head>

	<body onload="rotar()">

		<div id="outer">
			<?php
				if(isset($_GET["seccion"]))
					$seccion=$_GET["seccion"] ;
		    	else
			    	$seccion="Inicio" ;

				if(isset($_GET["tipohab"]))
  			    	$tipo=$_GET["tipohab"] ;
  		    	else
  			    	$tipo="" ;

				session_start() ;
				require_once './conexion.php' ;
				
				require './verificar_login.php' ;
				require './factura.php' ;

				require './header.php' ;
				require './content.php' ;
				require './sidebar.php' ;
				require './footer.php';

				mysql_close($con) ;
			?>
		</div>
	</body>
</html>
