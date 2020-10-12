<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
$DetProveedorOperador = new DetProveedoresOperaciones();
$datos = array($idProv, $Codigo);
$DetProveedorOperador->deleteDetProveedor($datos);
$ruta = "detProveedor.php";
mover_pag($ruta, "Detalle proveedor eliminado correctamente");


?>
