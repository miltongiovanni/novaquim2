<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $PreciosOperador = new PreciosOperaciones();
    $precios=$PreciosOperador->getTablePreciosHTML();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => count($precios),
        'recordsFiltered' => count($precios)
        );
    $datosRetorno  = array(
        $titulo,  
        'data'    => $precios
       ); 

print json_encode($datosRetorno);

?>