<div id="content">
    <div id="secondarycontent">
        <h4>Nuestras promociones:</h4>
    <div id="slider">
    <br>
        <div id="slidescontainer">
            <div class="slide"><a href="index.php?seccion=Promociones&tipo=#visalhambra"><img src="./imagenes/slider/SliderAlhambra.jpg" width=250px height=250px></a></div>
            <div class="slide"><a href="index.php?seccion=Promociones&tipo=#vissierra"><img src="./imagenes/slider/SliderSierra.jpg" width=250px height=250px></a></div>
            <div class="slide"><a href="index.php?seccion=Promociones&tipo=#visgranadacf"><img src="./imagenes/slider/SliderGranadaCF.jpg" width=250px height=250px></a></div>
        </div>
    </div>

    <br>
    <h4>Menú de navegación:<br></h4><br>
    <?php 
        $seleccion = "SELECT * FROM menudinamico WHERE padre = 'Principal' ORDER BY orden ASC" ;
        $resultado = mysql_query($seleccion) ;
        $numfilas = mysql_num_rows($resultado) ;

        if ($numfilas > 0){
            for($i = 0 ; $i < $numfilas ; $i++){
                $fila = mysql_fetch_assoc($resultado) ;
                if ($seccion != $fila["idmenu"]){
                    echo '<li><a href='.$fila["linkhref"].' class="active">'.$fila["idmenu"].'</a>' ;

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
        }
    ?>

    <br>
    <?php if($seccion == "Inicio"){ ?>
        <h4>Enlaces de interés:</h4>
        <div class="contentarea">
            <?php
                $seleccionhotel = "SELECT * FROM hotel" ;
                $resultadohotel = mysql_query($seleccionhotel) ;
                $numfilashotel = mysql_num_rows($resultadohotel) ;

                if ($numfilashotel > 0){
                    $elhotel = mysql_fetch_assoc($resultadohotel) ;
                    echo '<p><a href="'.$elhotel["facebook"].'" target="_blank">NUESTRO FACEBOOK</a></p>
                    <p><a href="'.$elhotel["twitter"].'" target="_blank">NUESTRO TWITTER</a></p>' ;
                }
            ?>
            <p><a href="http://www.granada.org/v2010.nsf/xxtod/3" target="_blank">Ayuntamiento de Granada</a></p>
            <p><a href="http://www.ideal.es/" target="_blank">Ideal</a></p>
            <p><a href="http://www.transportesrober.com/" target="_blank">Transportes Rober</a></p>
            <p><a href="http://sierranevada.es/" target="_blank">Sierra Nevada, Estación de Esquí</a></p>
            <p><a href="http://www.alhambra.org/" target="_blank">Alhambra de Granada</a></p>
            <p><a href="http://www.granadacf.es/" target="_blank">Granada Club de Fútbol</a></p>
        </div>
    <?php } ?>

    </div>
</div>