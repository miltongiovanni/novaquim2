<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idFactura = $_POST['idFactura'];
$facturaOperador = new FacturasOperaciones();
if (!$facturaOperador->isValidIdFactura($idFactura)) {
    echo ' <script >
				alert("El número de factura no es válido, vuelva a intentar de nuevo");
				history.back();
			</script>';
} else {
    $_SESSION['idFactura'] = $idFactura;
    header("Location: det_factura.php");
    exit;
}
