<div id="header">
    <div id="headercontent">
<?php
    $seleccionhotel = "SELECT * FROM hotel" ;
    $resultadohotel = mysql_query($seleccionhotel) ;
    $numfilashotel = mysql_num_rows($resultadohotel) ;

    if ($numfilashotel > 0){
        $elhotel = mysql_fetch_assoc($resultadohotel) ;
        echo '<h1>'.$elhotel["nombre"].'</h1>' ;
    }
?>
        <h2>Hospedando desde 1732</h2>
    </div>
</div>

<ul id="menu">
<?php
$seleccion = "SELECT * FROM menudinamico WHERE padre = 'Principal' ORDER BY orden ASC" ;
$resultado = mysql_query($seleccion) ;
$numfilas = mysql_num_rows($resultado) ;

if ($numfilas > 0){
    for($i = 0 ; $i < $numfilas ; $i++){
        $fila = mysql_fetch_assoc($resultado) ;
        echo
        '<li><a href='.$fila["linkhref"].'>'.$fila["idmenu"].'</a>' ;
        $seleccionfila = "SELECT * FROM menudinamico WHERE padre = '".$fila["idmenu"]."' ORDER BY orden ASC" ;
        $resultadofila = mysql_query($seleccionfila) ;
        $numfilasfila = mysql_num_rows($resultadofila) ;

        if ($numfilasfila > 0){
            echo '<ul>' ;
            for($j = 0 ; $j < $numfilasfila ; $j++){
                $filafila = mysql_fetch_assoc($resultadofila) ;
                echo
                '<li><a href='.$filafila["linkhref"].'>'.$filafila["idmenu"].'</a></li>' ;
            }
            echo '</ul>' ;
        }
        echo '</li>' ;
    }
}
?>
<li class="login">
    <?php
        if (is_null($variablelogin)){ 
            $variablelogin = '<form action="" method="post">
            <label>Correo: </label><input name="correo" type="text" >
            <label>Password: </label><input name="password" type="password">
            <input name="login" type="submit" value="Log In">
            <input type=button onClick=location.href="index.php?seccion=Registro" value="Register">
            </form>' ;
        }
        echo $variablelogin ;
    ?>
</li>
<li class="dates">
    <form action ="index.php" method="get"> Seleccione fecha de entrada y fecha de salida:
        <input type="hidden" name="seccion" value="ConsultarHab"> 
        <input type="date" name="fentrada" required> <input type="date" name="fsalida" required>
        <input type="submit" value='Consultar Disponibilidad'>
    </form>
</li>

</ul>

<div id="menubottom"></div>