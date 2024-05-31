<?php

function cargarClases($classname)
    {
      require '../../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $ProductosDistribucionOperador = new ProductosDistribucionOperaciones();
    $productos=$ProductosDistribucionOperador->getTableProductosDistribucion();

    $datosRetorno  = array(
        'draw' => 0,
        'recordsTotal'    => count($productos),
        'recordsFiltered' => count($productos),
        'data'    => $productos
       ); 


print json_encode($datosRetorno);


?>