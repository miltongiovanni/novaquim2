<?php
include "../includes/valAcc.php";
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
$DetProveedorOperador = new DetProveedoresOperaciones();
$datos = array($idProv, $Codigo);
$DetProveedorOperador->deleteDetProveedor($datos);
$ruta = "detProveedor.php";
mover_pag($ruta, "Detalle proveedor eliminado correctamente");
function mover_pag($ruta, $Mensaje)
{
    echo '<script >
   alert("' . $Mensaje . '");
   self.location="' . $ruta . '";
   </script>';
}

?>
