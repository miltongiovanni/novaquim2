<?php
//$err=error_reporting(16);
session_start();
define("BASE_C", "1271000");//1026000 Base retencion compra 2024
define("BASE_C2", "188000");//152000 Base retencion servicios 2024
define("FECHA_C", "2017-01-01");
date_default_timezone_set('AMERICA/Bogota');
if (!isset($_SESSION['UsuarioAutorizado'])) {
    header('Location: ../index.php');
    exit();
} else {
    if ($_SESSION['UsuarioAutorizado'] != 1) {
        $ruta = "../novaquim/index.php";
        $mensaje = "Acceso no autorizado, verifique sus datos de acceso";
        mover_pag($ruta, $mensaje, 'error');
    }
}
function mover_pag($ruta, $mensaje, $icon, $formElement = '')
{
    echo '<script >
   	alerta("' . $mensaje . '","' . $icon . '","' . $ruta . '","' . $formElement . '" );
   	</script>';
}

/*session_start();
// Establecer tiempo de vida de la sesión en segundos
$inactividad = 600;
// Comprobar si $_SESSION["timeout"] está establecida
if(isset($_SESSION["timeout"])){
    // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
    $sessionTTL = time() - $_SESSION["timeout"];
    if($sessionTTL > $inactividad){
        session_destroy();
        header("Location: /logout.php");
    }
}
// El siguiente key se crea cuando se inicia sesión
$_SESSION["timeout"] = time();
//esta parte para el login
session_start();
    if($_POST["usuario"] = "admin" && $_POST["password"] == sha1($password)){
        $_SESSION["autorizado"] = true;
        session_regenerate_id();
    }

*/


?>

