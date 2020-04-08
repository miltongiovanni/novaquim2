<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $CategoriaProvOperador = new CategoriasProvOperaciones();
    $categoriasProv=$CategoriaProvOperador->getCatsProv();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => count($categoriasProv),
        'recordsFiltered' => count($categoriasProv)
        );
    $datosRetorno  = array(
        $titulo,  
        'data'    => $categoriasProv
       ); 

print json_encode($datosRetorno);

?>