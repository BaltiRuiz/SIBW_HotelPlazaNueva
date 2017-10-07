<?php

$con = mysql_connect("localhost", "root", "") or exit("No se pudo conectar con el servidor") ;
$abreBD = mysql_select_db("hotel", $con) ;
mysql_query("SET NAMES 'utf8'") ;

if (!$abreBD) {
    die('No se pudo abrir la base de datos.Error:' . mysql_error()) ;
}

if(isset ($_GET['nombre'])){
    $texto = $_GET['nombre'] ;
    $resultadoconsulta = null ;
    if (strpos($texto, 'vis') !== false){
        $resultadoconsulta = mysql_query("SELECT * FROM actividades where altertext = '".$texto."'") ;
    }
    if (strpos($texto, 'serv') !== false)
        $resultadoconsulta = mysql_query("SELECT * FROM servicios where altertext = '".$texto."'") ;

    $consultaconcreta = mysql_fetch_assoc($resultadoconsulta) ;
    $precio = $consultaconcreta["precio"] ;
    $preciofinal = 0 ;
    $query = mysql_query("SELECT * FROM listaactividades WHERE texto='$texto'") ;

    if (mysql_num_rows($query) == 0){
        mysql_query("INSERT INTO listaactividades (texto,precio) VALUES ('$texto','$precio')") ;
    }
    else{
        mysql_query("DELETE FROM listaactividades WHERE texto='$texto'") ;
    }

    $queryfinal = mysql_query("SELECT * FROM listaactividades ") ;
    $numcols = mysql_num_rows($queryfinal) ;

    for($i = 0 ; $i < $queryfinal ; $i++){
        $quer = mysql_fetch_assoc($queryfinal) ;
        $preciofinal += $quer['precio'] ;
    }

    echo '-------------------------------------------------------------------------------------------------------------------------------------------------------------------<br><br>
        El coste extra por las actividades y servicios seleccionados es: <b>'.$preciofinal.'</b> euros
        <br><br>-------------------------------------------------------------------------------------------------------------------------------------------------------------------' ;
}

mysql_close($con) ;

?>
