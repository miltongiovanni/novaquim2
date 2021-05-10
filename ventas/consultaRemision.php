<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idRemision = $_POST['idRemision'];
$remisionOperador = new RemisionesOperaciones();
if (!$remisionOperador->isValidRemision($idRemision)) {
    echo ' <script >
				alert("El número de la remisión no es válido, vuelva a intentar de nuevo");
				history.back();
			</script>';
} else {
    $_SESSION['idRemision'] = $idRemision;
    header("Location: det_remision.php");
    exit;
}
