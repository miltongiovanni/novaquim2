<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idRecCaja = $_POST['idRecCaja'];
$recCajaOperador = new RecCajaOperaciones();
if (!$recCajaOperador->isValidIdRecCaja($idRecCaja)) {
    echo ' <script >
				alert("El número de recibo de caja no es válido, vuelva a intentar de nuevo");
				history.back();
			</script>';
} else {
    $_SESSION['idRecCaja'] = $idRecCaja;
    header("Location: recibo_caja.php");
    exit;
}
