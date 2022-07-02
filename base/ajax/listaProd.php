<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $ProductosOperador = new ProductosOperaciones();
    $productos=$ProductosOperador->getTableProductos();

    $datosRetorno  = array(
        'draw' => 0,
        'recordsTotal'    => count($productos),
        'recordsFiltered' => count($productos),
        'data'    => $productos
       ); 


print json_encode($datosRetorno);


?>