<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idCliente=$_GET['idCliente'];
$reciboOperador = new RecCajaOperaciones();
$recibos = $reciboOperador->getEstadoCuentaCliente($idCliente);
for($i=0;$i<count($recibos); $i++){
    $recibos[$i]['detEstado']= $reciboOperador->getRecCajaFactura($recibos[$i]['idFactura']);
}

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($recibos),
    'recordsFiltered' => count($recibos),
    'data' => $recibos
);
print json_encode($datosRetorno);

?>