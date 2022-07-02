<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$ProveedorOperador = new ProveedoresOperaciones();
$DetProveedorOperador = new DetProveedoresOperaciones();
$proveedores = $ProveedorOperador->getTableProveedores();
$datos = [];
for ($i = 0; $i < count($proveedores); $i++) {
    $detProveedor = $DetProveedorOperador->getTableDetProveedores($proveedores[$i]['idProv']);
    $datos[$i]['nitProv'] = $proveedores[$i]['nitProv'];
    $datos[$i]['nomProv'] = $proveedores[$i]['nomProv'];
    $datos[$i]['dirProv'] = $proveedores[$i]['dirProv'];
    $datos[$i]['contProv'] = $proveedores[$i]['contProv'];
    $datos[$i]['telProv'] = $proveedores[$i]['telProv'];
    $datos[$i]['emailProv'] = $proveedores[$i]['emailProv'];
    $datos[$i]['desCatProv'] = $proveedores[$i]['desCatProv'];
    $datos[$i]['detProveedor'] = $detProveedor;
}

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($datos),
    'recordsFiltered' => count($datos),
    'data' => $datos
);
print json_encode($datosRetorno);

?>