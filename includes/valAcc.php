<?php
//$err=error_reporting(16);
session_start();
include 'config.php';
if (!isset($_SESSION['UsuarioAutorizado'])) {
    header("Location: " . APP_URL);
    exit();
} else {
    if ($_SESSION['UsuarioAutorizado'] != 1) {
        $_SESSION['flash_message'] = "Acceso no autorizado, verifique sus datos de acceso";
        header("Location: " . APP_URL );
        exit();
    }

    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > TIEMPO_INACTIVIDAD)) {
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['flash_message'] = "Sesión expirada";
        header("Location: " . APP_URL );
        exit();
    } else {
        $_SESSION["last_activity"] = time();
    }
}
function mover_pag($ruta, $mensaje, $icon, $formElement = '')
{
    echo '<script >
   	alerta("' . $mensaje . '","' . $icon . '","' . $ruta . '","' . $formElement . '" );
   	</script>';
}

?>

