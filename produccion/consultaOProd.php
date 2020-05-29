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
$OProdOperador= new OProdOperaciones();
if (!$OProdOperador->isValidLote($lote)) {
    echo ' <script >
				alert("El número de lote no es válido, vuelva a intentar de nuevo");
				history.back();
			</script>';
} else {

    $_SESSION['lote'] = $lote;
    header("Location: detO_Prod.php");
    exit;
}



?>
