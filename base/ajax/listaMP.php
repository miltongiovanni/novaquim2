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
    for($i = 0; $i < count($mPrimas); $i++){
        $datos[]  = array(
            $mPrimas[$i]["codMPrima"],
            $mPrimas[$i]["nomMPrima"],
            $mPrimas[$i]["aliasMPrima"],
            $mPrimas[$i]["catMP"],
            $mPrimas[$i]["minStockMprima"],
            $mPrimas[$i]["aparienciaMPrima"],
            $mPrimas[$i]["olorMPrima"],
            $mPrimas[$i]["colorMPrima"],
            $mPrimas[$i]["pHmPrima"],
            $mPrimas[$i]["densidadMPrima"],
            $mPrimas[$i]["codMPrimaAnt"]
        ); 
    }
    $datosRetorno  = array(
        $titulo,  
        'data'    => $datos
       ); 


print json_encode($datosRetorno);


?>