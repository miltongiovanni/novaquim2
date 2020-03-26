<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $ProductosDistribucionOperador = new ProductosDistribucionOperaciones();
    $productos=$ProductosDistribucionOperador->getTableProductosDistribucion();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => count($productos),
        'recordsFiltered' => count($productos)
        ); 
    for($i = 0; $i < count($productos); $i++){
        $datos[]  = array(
            $productos[$i]["idDistribucion"],
            $productos[$i]["producto"],
            $productos[$i]["precio"],
            $productos[$i]["iva"],
            $productos[$i]["catDis"],
            $productos[$i]["coSiigo"]
        ); 
    }
    $datosRetorno  = array(
        $titulo,  
        'data'    => $datos
       ); 


print json_encode($datosRetorno);


?>