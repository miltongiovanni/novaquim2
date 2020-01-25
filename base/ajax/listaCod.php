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
    for($i = 0; $i < count($precios); $i++){
        $datos[]  = array(
            $precios[$i]["Código"],
            $precios[$i]["Descripción"],
            $precios[$i]["Precio Fábrica"],
            $precios[$i]["Precio Distribución"],
            $precios[$i]["Precio Detal"],
            $precios[$i]["Precio Mayorista"],
            $precios[$i]["Precio Super"]
        ); 
    }
    $datosRetorno  = array(
        $titulo,  
        'data'    => $datos
       ); 

print json_encode($datosRetorno);

?>