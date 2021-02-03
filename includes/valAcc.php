
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<!--<script src="js/jquery-3.3.1.min.js"></script>-->
<script src="../js/validar.js"></script>

<?php
//$err=error_reporting(16);
session_start();
define("BASE_C", "980000");
define("FECHA_C", "2017-01-01");
date_default_timezone_set('AMERICA/Bogota');
if($_SESSION['Autorizado']!=1)
  	 {
		 $ruta = "../novaquim/index.php";
		 $mensaje = "Acceso no autorizado, verifique sus datos de acceso";
		 mover_pag($ruta, $mensaje, 'error');
	}
function mover_pag($ruta, $mensaje, $icon,  $formElement='')
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

