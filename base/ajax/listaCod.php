<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $PreciosOperador = new PreciosOperaciones();
    $precios=$PreciosOperador->getTablePreciosHTML();

    $datosRetorno  = array(
        'draw' => 0,
        'recordsTotal'    => count($precios),
        'recordsFiltered' => count($precios),
        'data'    => $precios
       ); 

print json_encode($datosRetorno);

?>