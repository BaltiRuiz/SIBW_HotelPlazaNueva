<?php $variablelogin = null ; ?>

<?php
function verificar_login($correo, $password, &$result)
{
    $sql = "SELECT * FROM usuarios WHERE correo = '$correo' and password = '$password'" ;
    $rec = mysql_query($sql) ;
    $count = 0 ;

    while($row = mysql_fetch_object($rec))
    {
        $count++ ;
        $result = $row ;
    }

    if($count == 1)
    {
        return 1 ;
    }

    else
    {
        return 0 ;
    }
}

if(!isset($_SESSION['userid'])){

    if(isset($_POST['login'])){

        if(verificar_login($_POST['correo'], $_POST['password'], $result) == 1){
            $_SESSION['userid'] = $result->correo ;
            header("location:index.php") ;
        }

        else{
            echo '<script type="text/javascript">alert("¡¡Usuario o correo erróneos!!");</script>' ;
        }
    }
?>

<?php
} 

else {
    $variablelogin = 'Logueado como '.$_SESSION['userid'].' <input type=button onClick=location.href="logout.php" value="Log Out">' ;
    $resultadotipousuario = mysql_query("SELECT * FROM usuarios where correo = '".$_SESSION['userid']."'") ;
    $numfilas = mysql_num_rows($resultadotipousuario) ;

    if ($numfilas > 0){
        $usuarioconcreto = mysql_fetch_assoc($resultadotipousuario) ;
        if ($usuarioconcreto["tipousuario"] == "administrador"){
            $variablelogin .= ' <input type=button onClick=location.href="index.php?seccion=ConsultarReservas" value="Consultar Reservas">' ;
        }
    }
}
?>
