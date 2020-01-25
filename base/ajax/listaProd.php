<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $ProductosOperador = new ProductosOperaciones();
    $productos=$ProductosOperador->getTableProductos();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => count($productos),
        'recordsFiltered' => count($productos)
        ); 
    for($i = 0; $i < count($productos); $i++){
        $datos[]  = array(
            $productos[$i]["codProducto"],
            $productos[$i]["nomProducto"],
            $productos[$i]["catProd"],
            $productos[$i]["densMin"],
            $productos[$i]["densMax"],
            $productos[$i]["pHmin"],
            $productos[$i]["pHmax"],
            $productos[$i]["fragancia"],
            $productos[$i]["color"],
            $productos[$i]["apariencia"]
        ); 
    }
    $datosRetorno  = array(
        $titulo,  
        'data'    => $datos
       ); 


print json_encode($datosRetorno);


?>