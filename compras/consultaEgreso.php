<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
    //echo $nombre_campo . " = " . $valor . "<br>";
    eval($asignacion);
}
$egresoOperador= new EgresoOperaciones();
if (!$egresoOperador->isValidIdEgreso($idEgreso)) {
    echo ' <script >
				alert("El número del egreso no es válido, vuelva a intentar de nuevo");
				history.back();
			</script>';
} else {

    $_SESSION['idEgreso'] = $idEgreso;
    header("Location: egreso.php");
    exit;
}



?>
