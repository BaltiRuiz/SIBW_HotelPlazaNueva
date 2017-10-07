<?php
    class Habitacion{
        var $nombrehab;
        var $rutaimg;
        var $altext;
        var $descripcion;

        function Habitacion($nomh,$ruta,$altt,$desc){
            $this->nombrehab=$nomh;
            $this->rutaimg=$ruta;
            $this->altext=$altt;
            $this->descripcion=$desc;
        }
    }

    class ContenedorHabitacionesSQL{
        var $seleccion ;
        var $resultado ;
        var $numfilas ;

        function ContenedorHabitacionesSQL(){
            $this->seleccion = "SELECT * FROM habitaciones WHERE numhabitacion = 1" ;
            $this->resultado = mysql_query($this->seleccion) ;
            $this->numfilas = mysql_num_rows($this->resultado) ;
        }

        function printall(){
            if ($this->numfilas > 0){
                for($i=0 ; $i < $this->numfilas ; $i++){
                    $fila = mysql_fetch_assoc($this->resultado) ;
                    echo
                    '<h3 id='.$fila["altertext"].'>'.$fila["tipohabitacion"].'</h3>
                    <div class="contentarea">
                    <img src='.$fila["urlimagen"].' class="left" alt='.$fila["altertext"].' width=270px height=170px/>'.$fila["descripcion"].'</div><hr>' ;
                }
            }
        }
    }

    class ContenedorActividadesSQL{
        var $seleccion ;
        var $resultado ;
        var $numfilas ;

        function ContenedorActividadesSQL(){
            $this->seleccion = "SELECT * FROM actividades" ;
            $this->resultado = mysql_query($this->seleccion) ;
            $this->numfilas = mysql_num_rows ($this->resultado) ;
        }

        function Printall(){

            for($i=0;$i<$this->numfilas;$i++){
                $actividad = mysql_fetch_assoc($this->resultado) ;
                echo
                '<h3 id='.$actividad["altertext"].'>'.$actividad["nombreactividad"].'</h3>
                <div class="contentarea">
                <img src='.$actividad["urlimg"].' class="left" alt='.$actividad["altertext"].' width=270px height=170px/>'.$actividad["descripcion"].'</div><hr>' ;
            }
        }
    }

    class ContenedorPromocionesSQL{
        var $seleccion ;
        var $resultado ;
        var $numfilas ;

        function ContenedorPromocionesSQL(){
            $this->seleccion = "SELECT * FROM promociones" ;
            $this->resultado = mysql_query($this->seleccion) ;
            $this->numfilas = mysql_num_rows ($this->resultado) ;
        }

        function Printall(){

            for($i=0;$i<$this->numfilas;$i++)
            {
                $promocion = mysql_fetch_array ($this->resultado);

                echo
                '<h3 id='.$promocion["altertext"].'>'.$promocion["nombre"].'</h3>
                <div class="contentarea">
                <img src='.$promocion["urlimg"].' class="left" alt='.$promocion["altertext"].' width=270px height=170px/>'.$promocion["descripcion"].'</div><hr>';
            }
        }
    }

    $contenedor = new ContenedorHabitacionesSQL() ;
    $contenedorpromosql = new ContenedorPromocionesSQL() ;
    $contenedoractisql = new ContenedorActividadesSQL() ;
    $idreserva ;

    $precioofertasypromociones=0;
?>

<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

<?php if($seccion == "Registro"){ ?>

    <div id="content">
        <div id="normalcontent">
            <h3>Formulario de registro</h3>
            <br>
            <h4>Rellene los siguientes campos para registrarse en nuestro sistema:</h4>
        </div>

        <div id="primarycontainer">
            <div id="primarycontent">
                <form action=# method="post">
                    <fieldset>
                        <legend>Indique los siguientes datos:</legend>
                        Nombre: <input type="text" name="nombre"  size="32" required><br><br>
                        Apellidos: <input type="text" name="apellidos" size="64" required><br><br>
                        Teléfono: <input type="text" name="telefono" pattern="^([0|\+[0-9]{1,5})?([1-9][0-9]{9})$" size="32" required><br><br>
                        Email: <input type="email" name="email" size="32" required><br><br>
                        DNI: <input type="text" name="DNI" size="9" required><br><br>
                        Número de tarjeta de crédito (Opcional): <input type="text" name="tcredito" size="32" ><br><br>
                        Password: <input type="password" name="password" size="32" required ><br><br>
                        <input type="submit" value="Enviar">
                    </fieldset>
                </form>

                <?php
                if(isset($_POST["nombre"]) && isset($_POST["apellidos"]) && isset($_POST["telefono"]) && isset($_POST["email"]) && isset($_POST["DNI"]) && isset($_POST["password"])){
                    $ntarjeta ;
                    $nom = $_POST["nombre"] ;
                    $apellidos = $_POST["apellidos"] ;
                    $telefono = $_POST["telefono"] ;
                    $email = $_POST["email"] ;
                    $DNI = $_POST["DNI"] ;
                    $password = $_POST["password"] ;

                    if(isset($_POST["tcredito"])){
                        $ntarjeta = $_POST["tcredito"] ;
                    }

                    $correorepetido = mysql_query("SELECT * FROM usuarios WHERE correo = '".$email."'") ;
                    $numfilasrepetido = mysql_num_rows($correorepetido) ;

                    if ($numfilasrepetido == 1){
                        echo '<script type="text/javascript">alert("¡¡El correo introducido ya existe en el sistema!!");</script>' ;
                       
                    }
                    else{
                        mysql_query("INSERT INTO usuarios (nombre, apellidos, dni, correo, numtarjeta, password, telefono) 
                        VALUES ('$nom', '$apellidos', '$DNI', '$email', '$ntarjeta', '$password', '$telefono')") ;
                        echo '<script type="text/javascript">alert("¡¡Se ha registrado correctamente!!");</script>' ;
                    }
                }
                ?>
            </div>
        </div>
    </div>
<?php } ?>

<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

<?php if($seccion == "ConsultarHab"){

    mysql_query("DELETE FROM listaactividades") ;

    if($_GET['fentrada'] == "" && $_GET['fsalida'] == ""){
        $personas = $_GET["personas"] ;
        $selecciontipos = mysql_query("SELECT DISTINCT tipohabitacion FROM habitaciones") ;

        $numtipos = mysql_num_rows($selecciontipos) ;
        echo '<div id="content">
            <div id="normalcontent">
                <h3>Mostrando todas las habitaciones para '.$personas.' persona(s)</h3>
                <br>
            </div>' ;

        if ($numtipos > 0){
            echo '<div id="primarycontainer">
                    <div id="primarycontent">' ;

            for ($i = 0 ; $i < $numtipos ; $i++){
                    $nombretipo = mysql_fetch_array($selecciontipos) ;
                    $consul = mysql_query("SELECT * from habitaciones where tipohabitacion='".$nombretipo['tipohabitacion']."'") ;
                    $habconcreta = mysql_fetch_assoc($consul) ;
                    $habconcretacapacidad = $habconcreta['capacidad'] ;

                    if(isset($personas)){
                        if(($habconcretacapacidad == $personas) || $personas >= 4 ){
                        echo '<hr><h3 id='.$habconcreta["altertext"].'>'.$habconcreta["tipohabitacion"].'</h3>
                            <div class="contentarea">
                            <img src='.$habconcreta["urlimagen"].' class="left" alt='.$habconcreta["altertext"].' width=270px height=170px/>
                            <p>Tipo de habitación: <b>'.$habconcreta["tipohabitacion"].'</b>.</p>
                            <p>Capacidad: <b>'.$habconcreta["capacidad"].' personas</b>.</p>
                            <p>Precio por habitación: <b>'.$habconcreta["preciobase"].' euros</b>.</p>
                            <br><br><br></div>' ;
                        }
                    }
                }
            }

        echo '</div></div></div>' ;
    }

    else
    {
        if(isset($_GET["fentrada"]) && isset($_GET["fsalida"]) ){
            $entrada = date('Y-m-d', strtotime($_GET['fentrada'])) ;
            $salida = date('Y-m-d', strtotime($_GET['fsalida'])) ;

            if( isset($_GET["personas"]))
                $personas = $_GET["personas"] ;

            if ($salida <= $entrada){
                echo '<script type="text/javascript">alert("¡¡La fecha de salida ha de ser posterior a la fecha de entrada!!");</script>' ;
            }

            else{
                echo '<div id="content">
                    <div id="normalcontent">
                        <h3>Habitaciones disponibles</h3>
                        <br>
                        <h4>Entre las fechas '.$entrada.' y '.$salida.'</h4>
                    </div>' ;

                if (isset($_SESSION["idreserva"])){

                    $idreserva = $_SESSION["idreserva"] ;
                    $tipohabitacion = $_GET["tipohabitacion"] ;
                    $numhabitacioninsertar = $_GET["habinsertar"] ;
                    $resultadohabitacion = mysql_query("SELECT * FROM habitaciones where tipohabitacion = '$tipohabitacion'") ;
                    $habitacionconcreta = mysql_fetch_assoc($resultadohabitacion) ;
                    $meselegido = date('m', strtotime($_GET['fentrada'])) ;
                    $resultadocalendario = mysql_query("SELECT * FROM calendario where nmes = '$meselegido'") ;
                    $calendarioconcreto = mysql_fetch_assoc($resultadocalendario) ;
                    $preciofinal = $habitacionconcreta["preciobase"] + $calendarioconcreto["incremento"] ;

                    $facturaaux = new Factura() ;
                    $facturaaux->incrementarPrecioFactura($preciofinal) ;

                    $resultadoactividades = mysql_query("SELECT * FROM actividades") ;
                    $numactividades = mysql_num_rows($resultadoactividades) ;
                    $resultadoservicios = mysql_query("SELECT * FROM servicios") ;
                    $numservicios = mysql_num_rows($resultadoservicios) ;
                    $actividadeselegidas = [] ;
                    $servicioselegidos = [] ;

                    if ($numactividades > 0){
                        for ($i = 0 ; $i < $numactividades ; $i++){
                            if (isset($_GET['actividadelegir'.$i.''])){
                                array_push($actividadeselegidas, $_GET['actividadelegir'.$i.'']) ;
                            }
                        }
                    }

                    if ($numservicios > 0){
                        for ($j = 0 ; $j < $numservicios ; $j++){
                            if (isset($_GET['servicioelegir'.$j.''])){
                                array_push($servicioselegidos, $_GET['servicioelegir'.$j.'']) ;
                            }
                        }
                    }

                    // echo 'SE HAN PEDIDO '.sizeof($actividadeselegidas).' ACTIVIDADES Y '.sizeof($servicioselegidos).' SERVICIOS<br>' ;

                    if (sizeof($actividadeselegidas) > 0 && sizeof($servicioselegidos) > 0){
                        // echo 'CASO 1<br>' ;
                        for ($i = 0 ; $i < sizeof($actividadeselegidas) ; $i++){
                            for ($j = 0 ; $j < sizeof($servicioselegidos) ; $j++){
                                mysql_query("INSERT INTO reservahabitacion (localizador, tipohabitacion, numhabitacion, nombreactividad, nombreservicio) VALUES ('$idreserva',
                                    '$tipohabitacion', '$numhabitacioninsertar', '$actividadeselegidas[$i]', '$servicioselegidos[$j]')") ;
                                $resultadoprecioactividad = mysql_query("SELECT * FROM actividades WHERE altertext = '$actividadeselegidas[$i]'") ;
                                $precioactividadconcreta = mysql_fetch_assoc($resultadoprecioactividad) ;
                                $facturaaux->incrementarPrecioFactura($precioactividadconcreta["precio"]) ;
                                $resultadoprecioservicio = mysql_query("SELECT * FROM servicios WHERE altertext = '$servicioselegidos[$i]'") ;
                                $precioservicioconcreto = mysql_fetch_assoc($resultadoprecioservicio) ;
                                $facturaaux->incrementarPrecioFactura($precioservicioconcreto["precio"]) ;
                            }

                            $resultadopromocion = mysql_query("SELECT * FROM promociones WHERE codigopromocion IN (SELECT codigopromocion FROM requisitopromocion
                                WHERE tipohabitacion = '".$tipohabitacion."' AND nombreactividad = '".$actividadeselegidas[$i]."')") ;
                            $numresultadopromocion = mysql_num_rows($resultadopromocion) ;

                            if ($numresultadopromocion > 0){
                                $promocionconcreta = mysql_fetch_assoc($resultadopromocion) ;
                                echo 'LA RESERVA QUE HA HECHO TIENE UNA PROMOCION: '.$promocionconcreta["codigopromocion"].'<br>' ;
                                mysql_query("UPDATE factura SET codigopromocion = '".$promocionconcreta["codigopromocion"]."' WHERE idfactura = '$idreserva'") ;
                            }
                        }
                    }
                    else if (sizeof($actividadeselegidas) > 0){
                        // echo 'CASO 2<br>' ;
                        for ($i = 0 ; $i < sizeof($actividadeselegidas) ; $i++){
                            mysql_query("INSERT INTO reservahabitacion (localizador, tipohabitacion, numhabitacion, nombreactividad) VALUES ('$idreserva', '$tipohabitacion',
                            '$numhabitacioninsertar', '$actividadeselegidas[$i]')") ;
                            $resultadoprecioactividad = mysql_query("SELECT * FROM actividades WHERE altertext = '$actividadeselegidas[$i]'") ;
                            $precioactividadconcreta = mysql_fetch_assoc($resultadoprecioactividad) ;
                            $facturaaux->incrementarPrecioFactura($precioactividadconcreta["precio"]) ;

                            $resultadopromocion = mysql_query("SELECT * FROM promociones WHERE codigopromocion IN (SELECT codigopromocion FROM requisitopromocion
                                WHERE tipohabitacion = '".$tipohabitacion."' AND nombreactividad = '".$actividadeselegidas[$i]."')") ;
                            $numresultadopromocion = mysql_num_rows($resultadopromocion) ;

                            if ($numresultadopromocion > 0){
                                $promocionconcreta = mysql_fetch_assoc($resultadopromocion) ;
                                echo 'LA RESERVA QUE HA HECHO TIENE UNA PROMOCION: '.$promocionconcreta["codigopromocion"].'<br>' ;
                                mysql_query("UPDATE factura SET codigopromocion = '".$promocionconcreta["codigopromocion"]."' WHERE idfactura = '$idreserva'") ;
                            }
                        }
                    }
                    else if (sizeof($servicioselegidos) > 0){
                        // echo 'CASO 3<br>' ;
                        for ($i = 0 ; $i < sizeof($servicioselegidos) ; $i++){
                            mysql_query("INSERT INTO reservahabitacion (localizador, tipohabitacion, numhabitacion, nombreservicio) VALUES ('$idreserva', '$tipohabitacion',
                            '$numhabitacioninsertar', '$servicioselegidos[$i]')") ;
                            $resultadoprecioservicio = mysql_query("SELECT * FROM servicios WHERE altertext = '$servicioselegidos[$i]'") ;
                            $precioservicioconcreto = mysql_fetch_assoc($resultadoprecioservicio) ;
                            $facturaaux->incrementarPrecioFactura($precioservicioconcreto["precio"]) ;
                        }
                    }
                    else if (sizeof($actividadeselegidas) == 0 && sizeof($servicioselegidos) == 0){
                        // echo 'CASO 4<br>' ;
                        mysql_query("INSERT INTO reservahabitacion (localizador, tipohabitacion, numhabitacion) VALUES ('$idreserva', '$tipohabitacion', '$numhabitacioninsertar')") ;
                    }

                    $resultadofactura = mysql_query("SELECT * FROM factura where idfactura = '$idreserva'") ;
                    $facturaconcreta = mysql_fetch_assoc($resultadofactura) ;
                    $nuevoprecio = $facturaconcreta["preciototal"] + $facturaaux->preciofinal ;
                    mysql_query("UPDATE factura SET preciototal = '$nuevoprecio' WHERE idfactura = '$idreserva'") ;
                }

                $selecciontipos = "SELECT DISTINCT tipohabitacion FROM habitaciones" ;
                $resultadotipos = mysql_query($selecciontipos) ;
                $numtipos = mysql_num_rows($resultadotipos) ;

                if ($numtipos > 0){
                    echo '<div id="primarycontainer">
                            <div id="primarycontent">' ;

                    for ($i = 0 ; $i < $numtipos ; $i++){
                        $tipoconcreto = mysql_fetch_array($resultadotipos) ;
                        $seleccionhabitaciones = "SELECT * from habitaciones WHERE tipohabitacion = '".$tipoconcreto["tipohabitacion"]."' AND (tipohabitacion, numhabitacion)
                                                NOT IN (SELECT tipohabitacion, numhabitacion FROM reservahabitacion WHERE localizador IN (SELECT localizador FROM reservas WHERE
                                                (fechaentrada >= '".$entrada."' OR fechasalida >= '".$entrada."') AND (fechaentrada <= '".$salida."' OR fechasalida <= '".$salida."')))" ;
                        $resultadohabitaciones = mysql_query($seleccionhabitaciones) ;
                        $numhabitaciones = mysql_num_rows($resultadohabitaciones) ;

                        if ($numhabitaciones > 0){
                            $habconcreta = mysql_fetch_assoc($resultadohabitaciones) ;
                            $meselegido = date('m', strtotime($_GET['fentrada'])) ;
                            $resultadocalendario = mysql_query("SELECT * FROM calendario where nmes = '$meselegido'") ;
                            $calendarioconcreto = mysql_fetch_assoc($resultadocalendario) ;
                            $preciofinal = $habconcreta["preciobase"] + $calendarioconcreto["incremento"] ;
                            $habconcretacapacidad = $habconcreta['capacidad'] ;
                            if(isset($personas)){
                                if(($habconcretacapacidad == $personas) || $personas >= 4 ){
                                echo '<hr><h3 id='.$habconcreta["altertext"].'>'.$habconcreta["tipohabitacion"].'</h3>
                                        <div class="contentarea">
                                        <img src='.$habconcreta["urlimagen"].' class="left" alt='.$habconcreta["altertext"].' width=270px height=170px/>
                                        <p>Tipo de habitación: <b>'.$habconcreta["tipohabitacion"].'</b>.</p>
                                        <p>Capacidad: <b>'.$habconcreta["capacidad"].' personas</b>.</p>
                                        <p>Precio por habitación: <b>'.$habconcreta["preciobase"].' euros</b>.</p>
                                        <p>Quedan libres <b>'.$numhabitaciones.'</b> habitaciones de este tipo.</p>
                                        <p>Incremento de precio por fecha elegida: <b>'.$calendarioconcreto["incremento"].' euros</b></p>
                                        <p>Precio total por habitación (Incluyendo IVA + aumento por fecha): <b>'.$preciofinal.' euros</b><br><br>
                                        <input type=button onClick=location.href="index.php?seccion=Reserva&tipohabitacion='.$habconcreta["tipohabitacion"].'&fechaentrada='.$entrada.'&fechasalida='.$salida.'"
                                            value="RESERVAR ESTE TIPO DE HABITACIÓN"><br></div>' ;
                                }
                            }
                            else{
                                echo '<hr><h3 id='.$habconcreta["altertext"].'>'.$habconcreta["tipohabitacion"].'</h3>
                                    <div class="contentarea">
                                    <img src='.$habconcreta["urlimagen"].' class="left" alt='.$habconcreta["altertext"].' width=270px height=170px/>
                                    <p>Tipo de habitación: <b>'.$habconcreta["tipohabitacion"].'</b>.</p>
                                    <p>Capacidad: <b>'.$habconcreta["capacidad"].' personas</b>.</p>
                                    <p>Precio por habitación: <b>'.$habconcreta["preciobase"].' euros</b>.</p>
                                    <p>Quedan libres <b>'.$numhabitaciones.'</b> habitaciones de este tipo.</p>
                                    <p>Incremento de precio por fecha elegida: <b>'.$calendarioconcreto["incremento"].' euros</b></p>
                                    <p>Precio total por habitación (Incluyendo IVA + aumento por fecha): <b>'.$preciofinal.' euros</b><br><br>
                                    <input type=button onClick=location.href="index.php?seccion=Reserva&tipohabitacion='.$habconcreta["tipohabitacion"].'&fechaentrada='.$entrada.'&fechasalida='.$salida.'"
                                        value="RESERVAR ESTE TIPO DE HABITACIÓN"><br></div>' ;
                            }
                        }
                    }

                    if (isset($_SESSION["idreserva"])){
                        echo '<hr>---------------------------------------------------------------------------------<p>INFORMACIÓN SOBRE SU RESERVA
                            ACTUAL:</p>---------------------------------------------------------------------------------------------------------------------------------------------------------' ;

                        $resultadoreservahabitacion = mysql_query("SELECT DISTINCT tipohabitacion, numhabitacion FROM reservahabitacion where localizador = '".$_SESSION["idreserva"]."'") ;
                        $numreservahabitacion = mysql_num_rows($resultadoreservahabitacion) ;

                        for ($i = 0 ; $i < $numreservahabitacion ; $i++){
                            $reservahabitacionconcreta = mysql_fetch_assoc($resultadoreservahabitacion) ;
                            $resultadoactividades = mysql_query("SELECT * FROM actividades WHERE altertext IN (SELECT nombreactividad FROM reservahabitacion
                                where localizador = '".$_SESSION["idreserva"]."' and tipohabitacion = '".$reservahabitacionconcreta["tipohabitacion"]."'
                                and numhabitacion = '".$reservahabitacionconcreta["numhabitacion"]."')") ;
                            $resultadoservicios = mysql_query("SELECT * FROM servicios WHERE altertext IN (SELECT nombreservicio FROM reservahabitacion
                                where localizador = '".$_SESSION["idreserva"]."' and tipohabitacion = '".$reservahabitacionconcreta["tipohabitacion"]."'
                                and numhabitacion = '".$reservahabitacionconcreta["numhabitacion"]."')") ;
                            $numactividades = mysql_num_rows($resultadoactividades) ;
                            $numservicios = mysql_num_rows($resultadoservicios) ;
                            echo '<p>Tipo de habitación: <b>'.$reservahabitacionconcreta["tipohabitacion"].'</b></p>
                                <p>Número de habitación: <b>'.$reservahabitacionconcreta["numhabitacion"].'</b></p>
                                <p>Actividades solicitadas: <b>' ;
                            for ($j = 0 ; $j < $numactividades ; $j++){
                                $actividadconcreta = mysql_fetch_assoc($resultadoactividades) ;
                                echo ' [ '.$actividadconcreta["nombreactividad"].' ] ' ;
                            }
                            echo '</b></p><p>Servicios solicitados: <b>' ;
                            for ($j = 0 ; $j < $numservicios ; $j++){
                                $servicioconcreto = mysql_fetch_assoc($resultadoservicios) ;
                                echo ' [ '.$servicioconcreto["nombreservicio"].' ] ' ;
                            }
                            echo '</b></p>---------------------------------------------------------------------------------------------------------------------------------------------------------' ;
                        }

                        $resultadofactura = mysql_query("SELECT * FROM factura WHERE idfactura = '".$_SESSION["idreserva"]."'") ;
                        $facturaconcreta = mysql_fetch_assoc($resultadofactura) ;
                        echo '<p><b>COSTE TOTAL DE LA RESERVA: '.$facturaconcreta["preciototal"].' EUROS</b></p>---------------------------------------------------------------------------------' ;
                    }

                    echo '<hr><br><input type=button onClick=location.href="index.php?seccion=Inicio" value="CANCELAR RESERVA">
                        <input type=button onClick=location.href="index.php?seccion=Inicio&reserva=confirmar" value="CONFIRMAR RESERVA">' ;

                    echo '</div></div></div>' ;
                }
            }
        }
    }
} ?>

<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

<?php if($seccion == "Reserva"){ ?>

    <div id="content">
        <div id="normalcontent">
            <h3>Panel de reservas</h3>
            <br>
            <h4>Seleccione las actividades y/o servicios extra a reservar junto a la habitación</h4>
        </div>

        <div id="primarycontainer">
            <div id="primarycontent">
                <?php
                    if(!isset($_SESSION['userid'])){
                        echo '<script type="text/javascript">alert("¡¡Ha de loguearse para poder reservar!!");</script>' ;
                    }

                    else{
                        if (isset($_GET['tipohabitacion']) && isset($_GET['fechaentrada']) && isset($_GET['fechasalida'])){
                            $correousuario = $_SESSION['userid'] ;
                            $tipohabitacion = $_GET['tipohabitacion'] ;
                            $fechaentrada = date('Y-m-d', strtotime($_GET['fechaentrada'])) ;
                            $fechasalida = date('Y-m-d', strtotime($_GET['fechasalida'])) ;
                            $numhabitacioninsertar = null ;

                            if (!isset($_SESSION["idreserva"])){
                                $_SESSION["idreserva"] = uniqid() ;
                                $idreserva = $_SESSION["idreserva"] ;

                                mysql_query("INSERT INTO reservas (correousuario, localizador, fechaentrada, fechasalida) VALUES ('$correousuario', '$idreserva', '$fechaentrada', '$fechasalida')") ;
                                mysql_query("INSERT INTO factura (idfactura) VALUES ('$idreserva')") ;
                            }

                            $resultadonumhabitacion = mysql_query("SELECT * from habitaciones WHERE tipohabitacion = '".$tipohabitacion."' AND (tipohabitacion, numhabitacion)
                                NOT IN (SELECT tipohabitacion, numhabitacion FROM reservahabitacion WHERE localizador IN (SELECT localizador FROM reservas WHERE
                                (fechaentrada >= '".$fechaentrada."' OR fechasalida >= '".$fechaentrada."') AND (fechaentrada <= '".$fechasalida."' OR fechasalida <= '".$fechasalida."')))") ;
                                $numnumhabitacion = mysql_num_rows($resultadonumhabitacion) ;

                            $numhabitacionconcreta = mysql_fetch_assoc($resultadonumhabitacion) ;
                            $numhabitacioninsertar = $numhabitacionconcreta['numhabitacion'] ;

                            $resultadoactividades = mysql_query("SELECT * FROM actividades") ;
                            $numactividades = mysql_num_rows($resultadoactividades) ;

                            if ($numactividades > 0){
                                echo '<form action="index.php?" method="get">
                                    <input type="hidden" name="seccion" value="ConsultarHab">
                                    <input type="hidden" name="fentrada" value='.$fechaentrada.'><input type="hidden" name="fsalida" value='.$fechasalida.'>
                                    <input type="hidden" name="tipohabitacion" value='.$tipohabitacion.'>
                                    <input type="hidden" name="habinsertar" value='.$numhabitacioninsertar.'>' ;

                                for ($i = 0 ; $i < $numactividades ; $i++){
                                    $actividadconcreta = mysql_fetch_assoc($resultadoactividades) ;
                                        echo '<hr><h3 id='.$actividadconcreta["altertext"].'>'.$actividadconcreta["nombreactividad"].'</h3>
                                        <div class="contentarea">
                                        <img src='.$actividadconcreta["urlimg"].' class="left" alt='.$actividadconcreta["altertext"].' width=270px height=170px/>
                                        <p>Nombre de la actividad: '.$actividadconcreta["nombreactividad"].'.</p>
                                        <p>Precio por persona: '.$actividadconcreta["precio"].' euros.</p>
                                        <p>ACTIVIDAD DISPONIBLE ACTUALMENTE.</p><br><br><br><br>

                                        <input type="checkbox" class="checkboxes" name="actividadelegir'.$i.'" value='.$actividadconcreta["altertext"].'>SELECCIONAR ESTA ACTIVIDAD</option></div>' ;
                                }
                            }

                            $resultadoservicios = mysql_query("SELECT * FROM servicios") ;
                            $numservicios = mysql_num_rows($resultadoservicios) ;

                            if ($numservicios > 0){
                                for ($i = 0 ; $i < $numservicios ; $i++){
                                    $servicioconcreto = mysql_fetch_assoc($resultadoservicios) ;
                                        echo '<hr><h3 id='.$servicioconcreto["altertext"].'>'.$servicioconcreto["nombreservicio"].'</h3>
                                        <div class="contentarea">
                                        <img src='.$servicioconcreto["urlimagen"].' class="left" alt='.$servicioconcreto["altertext"].' width=270px height=170px/>
                                        <p>Nombre del servicio: '.$servicioconcreto["nombreservicio"].'.</p>
                                        <p>Precio por habitación: '.$servicioconcreto["precio"].' euros.</p>
                                        <p>Descripción: '.$servicioconcreto["descripcion"].'.</p><br><br>

                                        <input type="checkbox" class="checkboxes" name="servicioelegir'.$i.'" value='.$servicioconcreto["altertext"].'>SELECCIONAR ESTA ACTIVIDAD</option></div>' ;
                                }
                                echo '<hr>' ;
                                echo '<input type="submit" value="CONTINUAR LA RESERVA"></form>' ;
                                echo  '<div id="demo"><h2></h2></div>' ;

                            }
                        }
                    }
                ?>

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
                <script>

                $(".checkboxes").change(function(event){
                    // var precio = event.target.value ;
                    var name = event.target.value ;
                    var xhttp ;
                    xhttp = new XMLHttpRequest() ;

                    xhttp.onreadystatechange = function() {

                        if (xhttp.readyState == 4 && xhttp.status == 200) {
                            document.getElementById("demo").innerHTML = xhttp.responseText ;
                        }
                    };

                    var url = "precioofertas.php?nombre="+name ;
                    xhttp.open("GET", url, true) ;
                    xhttp.send() ;
                });

                </script>
            </div>
        </div>
    </div>
<?php } ?>

<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

<?php if( ($seccion != "ConsultarHab" && $seccion != "Reserva")){

        if (isset($_SESSION["idreserva"]) && !isset($_GET["reserva"])){
            mysql_query("DELETE FROM reservas WHERE localizador = '".$_SESSION["idreserva"]."'") ;
            mysql_query("DELETE FROM reservahabitacion WHERE localizador = '".$_SESSION["idreserva"]."'") ;
            mysql_query("DELETE FROM factura WHERE idfactura = '".$_SESSION["idreserva"]."'") ;
            unset($_SESSION["idreserva"]) ;
        }
} ?>

<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

<?php if($seccion == "ConsultarReservas"){ ?>

        <div id="content">
        <div id="normalcontent">
            <h3>Reservas actuales del Hotel</h3>
        </div>

        <div id="primarycontainer">
            <div id="primarycontent">
                <hr>
                <?php
                $resultadoreservas = mysql_query("SELECT * FROM reservas ORDER BY fechaentrada ASC") ;
                $numreservas = mysql_num_rows($resultadoreservas) ;

                for($i = 0 ; $i < $numreservas ; $i++){
                    $reservaconcreta = mysql_fetch_assoc($resultadoreservas) ;
                    echo
                    '<h4>Código de reserva: '.$reservaconcreta["localizador"].' ['.$reservaconcreta["fechaentrada"].' - '.$reservaconcreta["fechasalida"].']
                        (Realizada por '.$reservaconcreta["correousuario"].')</h4>
                        <div class="contentarea">' ;

                    $resultadoreservahabitacion = mysql_query("SELECT DISTINCT tipohabitacion, numhabitacion FROM reservahabitacion where localizador = '".$reservaconcreta["localizador"]."'") ;
                    $numreservahabitacion = mysql_num_rows($resultadoreservahabitacion) ;

                    for ($j = 0 ; $j < $numreservahabitacion ; $j++){
                        $reservahabitacionconcreta = mysql_fetch_assoc($resultadoreservahabitacion) ;
                        $resultadoactividades = mysql_query("SELECT * FROM actividades WHERE altertext IN (SELECT nombreactividad FROM reservahabitacion
                            where localizador = '".$reservaconcreta["localizador"]."' and tipohabitacion = '".$reservahabitacionconcreta["tipohabitacion"]."'
                            and numhabitacion = '".$reservahabitacionconcreta["numhabitacion"]."')") ;
                        $resultadoservicios = mysql_query("SELECT * FROM servicios WHERE altertext IN (SELECT nombreservicio FROM reservahabitacion
                            where localizador = '".$reservaconcreta["localizador"]."' and tipohabitacion = '".$reservahabitacionconcreta["tipohabitacion"]."'
                            and numhabitacion = '".$reservahabitacionconcreta["numhabitacion"]."')") ;
                        $numactividades = mysql_num_rows($resultadoactividades) ;
                        $numservicios = mysql_num_rows($resultadoservicios) ;
                        echo '<p>Tipo de habitación: <b>'.$reservahabitacionconcreta["tipohabitacion"].'</b></p>
                            <p>Número de habitación: <b>'.$reservahabitacionconcreta["numhabitacion"].'</b></p>
                            <p>Actividades solicitadas: <b>' ;
                        for ($h = 0 ; $h < $numactividades ; $h++){
                            $actividadconcreta = mysql_fetch_assoc($resultadoactividades) ;
                            echo ' [ '.$actividadconcreta["nombreactividad"].' ] ' ;
                        }
                        echo '</b></p><p>Servicios solicitados: <b>' ;
                        for ($h = 0 ; $h < $numservicios ; $h++){
                            $servicioconcreto = mysql_fetch_assoc($resultadoservicios) ;
                            echo ' [ '.$servicioconcreto["nombreservicio"].' ] ' ;
                        }
                        echo '</b></p>---------------------------------------------------------------------------------------------------------------------------------------------------------' ;
                    }

                    echo '</div><hr>' ;
                } ?>
            </div>
        </div>
    </div>
<?php } ?>

<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

<?php if($seccion == "Inicio"){

    if (isset($_SESSION["idreserva"]) && isset($_GET["reserva"])){

        echo '<script type="text/javascript">alert("¡¡Reserva completada y enviada correctamente!!");</script>' ;

        $facturafinal = new Factura() ;
        $resultadofactura = mysql_query("SELECT * FROM factura WHERE idfactura = '".$_SESSION["idreserva"]."'") ;
        $facturaconcreta = mysql_fetch_assoc($resultadofactura) ;
        $facturafinal->incrementarPrecioFactura($facturaconcreta["preciototal"]) ;
        $resultadodescuento = mysql_query("SELECT * FROM promociones WHERE codigopromocion = '".$facturaconcreta["codigopromocion"]."'") ;
        $numfilasdescuento = mysql_num_rows($resultadodescuento) ;
        if ($numfilasdescuento > 0){
            $descuentoconcreto = mysql_fetch_assoc($resultadodescuento) ;
            $facturafinal->aplicarDescuentoFactura($descuentoconcreto["descuento"]) ;
        }
        $facturafinal->enviarfactura($_SESSION["idreserva"]) ;

        unset($_SESSION["idreserva"]) ;
    }

    $seleccionhotel = "SELECT * from hotel" ;
    $resultadohotel = mysql_query($seleccionhotel) ;
    $numfilashotel = mysql_num_rows($resultadohotel) ;

    if ($numfilashotel > 0){
        $elhotel = mysql_fetch_assoc($resultadohotel) ;
        echo $elhotel["descripcion"] ;
    }
}   ?>

<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

<?php if($seccion == "Habitaciones"){ ?>

    <div id="content">
        <div id="normalcontent">
            <h3>Las Habitaciones de nuestro Hotel</h3>
        </div>

        <div id="primarycontainer">
            <div id="primarycontent">
				<hr>
				<p>Nuestras habitaciones con vistas a <b>Plaza Nueva</b> y a la <b>Torre de la Vela</b>, que pertenece al recinto de la Alhambra, le permitirán disfrutar de una perspectiva distinta de la
                ciudad. Disfrute de esta experiencia por un pequeño suplemento.</p>
                <p>Asimismo el hotel dispone de habitaciones interiores, recomendables para personas que desean descansar con la máxima tranquilidad.</p>
                <p>Las habitaciones también disponen de un cuarto de baño completo, aire acondicionado, TV, teléfono directo y una caja de seguridad gratuita para su mayor tranquilidad.</p>
				<hr>
                <?php $contenedor->printall() ; ?>
            </div>
        </div>
    </div>
<?php } ?>

<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

<?php if($seccion == "Promociones"){ ?>

    <div id="content">
        <div id="normalcontent">
            <h3>Nuestras Promociones y Ofertas</h3>
        </div>

        <div id="primarycontainer">
            <div id="primarycontent">
                <hr>
                <?php
                    $contenedorpromosql->Printall() ;
                    $contenedoractisql->Printall() ;
                ?>
            </div>
        </div>
    </div>
<?php } ?>

<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

<?php if($seccion == "Contacto"){ ?>

    <div id="content">
        <div id="normalcontent">
            <h3>Cómo llegar a nuestro Hotel</h3>
        </div>

        <div id="primarycontainer">
            <div id="primarycontent">
            <hr>
            <?php
                $seleccionhotel = "SELECT * FROM hotel" ;
                $resultadohotel = mysql_query($seleccionhotel) ;
                $numfilashotel = mysql_num_rows($resultadohotel) ;

                if ($numfilashotel > 0){
                    $elhotel = mysql_fetch_assoc($resultadohotel) ;
                    echo ''.$elhotel["infocontacto"].'
                    <hr>
                    <h3>Información de Contacto</h3>
                    <div class="contentarea">
                    <iframe id="mapa" src="'.$elhotel["googlemaps"].'" width="600" height="450" frameborder="0" allowfullscreen></iframe>
                    <p>Dirección: '.$elhotel["direccion"].'</p>
                    <p>Localidad: '.$elhotel["localidad"].'</p>
                    <p>Provincia: '.$elhotel["provincia"].'</p>
                    <p>País: '.$elhotel["pais"].'</p>
                    <p>Teléfono: '.$elhotel["telefono"].'</p>
                    <p>Fax: '.$elhotel["fax"].'</p>
                    <p>Email: '.$elhotel["email"].'</p>
                    <p><a href="'.$elhotel["facebook"].'" target="_blank">Síguenos en Facebook</a></p>
                    <p><a href="'.$elhotel["twitter"].'" target="_blank">Síguenos en Twitter</a></p>
                    </div>' ;
                }
            ?>

            <hr>
            <h5>CONTACTE CON NOSOTROS:</h5>
            <?php
                if( isset($_POST["femail"]) && isset($_POST["ftelefono"]) && isset($_POST["fmensaje"]) ){
                    $fnombre=$_POST["fnombre"] ;
                    $femail=$_POST["femail"] ;
                    $fmensaje=$_POST["fmensaje"] ;

                    require './lib/PHPMailerAutoload.php' ;
                    $mail = new PHPMailer ;
                    $mail->isSMTP() ;
                    $mail->Host = 'smtp.gmail.com' ;
                    $mail->SMTPAuth = true ;
                    $mail->Username = 'contactohotelplazanueva@gmail.com' ;
                    $mail->Password = 'hotelplazanueva123' ;
                    $mail->SMTPSecure = 'tls' ;
                    $mail->Port = 587 ;
                    $mail->From = $femail ;
                    $mail->FromName = $fnombre ;
                    $mail->addAddress('contactohotelplazanueva@gmail.com') ;
                    $mail->addAddress($femail) ;
                    $mail->Subject = 'Contacto' ;
                    $mail->Body = $fmensaje ;

                    if(!$mail->Send()){
                        echo '<script type="text/javascript">alert("Se ha producido un error a la hora de enviar el correo electrónico.");</script>' ;
                    }
                    else{
						echo '<script type="text/javascript">alert("¡¡Muchas gracias por contactar con nosotros!!\nRecibirá su respuesta en un plazo máximo de 24 horas.\nPuede además revisar el mensaje mandado en su correo electrónico.");</script>' ;
                    }
                }
            ?>

            <form action=# method="post">
                <fieldset>
                <legend>Indique los siguientes datos:</legend>
                Nombre: <input type="text" name="fnombre"  size="30" required>
                Apellidos: <input type="text" name="fapellidos" size="30" required><br><br>
                Teléfono: <input type="text" name="ftelefono" pattern="^([0|\+[0-9]{1,5})?([1-9][0-9]{9})$" size="20" required>
                Email: <input type="email" name="femail" size="20" required><br><br>
                Mensaje: <br><textarea type="text" name="fmensaje"   cols="130" rows="10" required></textarea><br><br>
                <input type="submit" value="Enviar">
                </fieldset>
            </form>

            </div>
        </div>
    </div>
<?php } ?>
