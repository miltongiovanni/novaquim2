<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $MPrimasOperador = new MPrimasOperaciones();
    $mPrimas=$MPrimasOperador->getTableMPrimas();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => count($mPrimas),
        'recordsFiltered' => count($mPrimas)
        );
    $datosRetorno  = array(
        $titulo,  
        'data'    => $mPrimas
       ); 


print json_encode($datosRetorno);


?>