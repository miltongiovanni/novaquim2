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
    $datosRetorno  = array(
        $titulo,  
        'data'    => $productos
       ); 


print json_encode($datosRetorno);


?>