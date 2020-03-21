<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$codProducto = $_POST['codProducto'];
$ProductoOperador = new ProductosOperaciones();



function mover_pag($ruta, $nota)
{
    echo '<script language="Javascript">
	alert("' . $nota . '")
	self.location="' . $ruta . '"
	</script>';
}

?>
