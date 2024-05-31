<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$notaCreditoOperador = new NotasCreditoOperaciones();
$notasCredito = $notaCreditoOperador->getTableNotasCredito();
$detNotasCreditoOperador = new DetNotaCrOperaciones();
for($i=0;$i<count($notasCredito); $i++){
    $notasCredito[$i]['detNotaCr']= $detNotasCreditoOperador->getDetNotaCr($notasCredito[$i]['idNotaC']);
}

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($notasCredito),
    'recordsFiltered' => count($notasCredito),
    'data' => $notasCredito
);
print json_encode($datosRetorno);

?>