<?php
	$seleccionhotel = "SELECT * FROM hotel" ;
	$resultadohotel = mysql_query($seleccionhotel) ;
	$numfilashotel = mysql_num_rows($resultadohotel) ;

	if ($numfilashotel > 0){
		$elhotel = mysql_fetch_assoc($resultadohotel) ;
		echo '<div id="footer"><div class="left">&copy; 2016 '.$elhotel["nombre"].' </div></div>' ;
	}
?>